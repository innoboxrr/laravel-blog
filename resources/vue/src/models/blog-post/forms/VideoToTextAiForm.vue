<template>
    <div>
        <div class="rounded-md bg-blue-50 p-4">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="size-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-blue-700">
                        {{ __blog('Video to Text AI') }}
                    </p>
                </div>
            </div>
        </div>

        <div>
		
            <div 
                v-if="!isUploading"
                @click="openFileDialog"
                @drop.prevent="handleDrop" 
                @dragover.prevent 
                class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-gray-50 dark:hover:border-slate-400 dark:hover:bg-gray-500 pointer">
                
                <i class="fa-solid fa-file-video fa-2xl text-gray-500 my-3 dark:text-slate-400"></i>
                
                <p class="text-gray-700 text-sm pt-4 dark:text-slate-300 pointer">
                    {{ __('Drag and drop a video file here in MP4 format') }}
                </p>
                
                <p class="text-gray-400 text-xs pt-2 dark:text-slate-400 pointer">
                    {{ __('or click to select a file') }}
                </p>
                
                <input 
                    type="file" 
                    ref="fileInput" 
                    class="hidden" 
                    @change="handleFileChange" 
                    accept="video/mp4">

            </div>

            <div v-else>
                
                <!-- Vista previa del video (ajustar el tamaño aquí) -->
                <div class="preview-container mx-auto shadow-lg" style="max-width: 50%;">

                    <video 
                        class="mx-auto rounded-lg shadow-lg"
                        :src="videoPreview" 
                        controls></video>

                </div>

                <!-- Barra de progreso (usando UIkit) -->
                <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 mt-4">
                
                    <div 
                        class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" 
                        :style="`width: ${uploadProgress}%`"> 

                        {{ uploadProgress.toFixed(2) }}%

                    </div>
                
                </div>

            </div>

        </div>
    </div>
</template>

<script>
    import MultipartUploader from 'innoboxrr-multipart-uploader';
    export default {

        emits: ['submit'],

        data() {	    
            return {
                video: undefined, // Video model
                file: undefined, // File to upload
                fileName: undefined,
                fileSize: undefined,
                cloud: 'aws',
                uploader: null, // Objeto de MultipartUploader
                videoPreview: null, // Blop video
                uploadProgress: 0,
                isUploading: false,
            };
        },

        methods: {

            openFileDialog() {
                this.$refs.fileInput.click();
            },

            handleDrop(event) {
                const files = event.dataTransfer.files;
                if (files.length > 0) {
                    this.initUpload(files[0]);
                }
            },

            handleFileChange(event) {
                const files = event.target.files;
                if (files.length > 0) {
                    this.initUpload(files[0]);
                }
            },

            async initUpload(file) {
                this.file = file;
                this.fileName = this.file.name;
                this.fileSize = this.file.size;
                if(this.lesson.video) {
                    this.video = this.lesson.video;
                    await this.updateVideo();
                } else {
                    this.video = await this.createVideo();
                    console
                }
                this.startUpload();
            },

            async createVideo() {
                try {
                    let duration = await this.getVideoDuration(this.file);
                    let res = await createVideoModel({
                        duration: duration,
                        size: this.fileSize,
                        lesson_id: this.lesson.id
                    });
                    return res;
                } catch ( error ) {
                    this.alert('error');
                }
            },

            async updateVideo() {
                try {
                    let duration = await this.getVideoDuration(this.file);
                    let res = await updateVideoModel(this.video.id, {
                        duration: duration,
                        size: this.fileSize,
                    });
                    return res;
                } catch ( error ) {
                    this.alert('error');
                }
            },	

            startUpload() {
                this.isUploading = true;
                this.createVideoPreview();
                // video-id debe venir de la solicitud previa 
                this.uploader = new MultipartUploader(this.video.code, {
                    token: csrf_token, // csrf
                    initiateUploadRoute: route('videoprocessor.initiate.upload'),
                    signPartUploadRoute: route('videoprocessor.sign.part.upload'),
                    completeUploadRoute: route('videoprocessor.complete.upload'),
                    chunkSize: 5,
                });

                this.uploader.on('progress', progress => {
                    this.animateProgress(this.uploadProgress, progress);
                });

                this.uploader.startUpload(this.file).catch(error => {
                    this.updateVideoStatus('upload_started');
                });

                this.uploader.on('complete', status => {
                    this.updateVideoStatus('cloud_uploaded').then(() => {
                        this.$emit('submit', this.video);
                    });
                });

            },

            createVideoPreview() {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.videoPreview = e.target.result;
                };
                reader.readAsDataURL(this.file);
            },

            getVideoDuration(file) {
                return new Promise((resolve, reject) => {
                    const video = document.createElement('video');
                    video.addEventListener('loadedmetadata', () => {
                        // Devolver un entero
                        resolve(Math.round(video.duration));
                    });
                    video.addEventListener('error', () => {
                        reject('Error al cargar el video.');
                    });
                    video.src = URL.createObjectURL(file);
                });
            },

            animateProgress(start, end) {
                const duration = 500; // Duración de la animación en milisegundos
                const stepTime = 20; // Tiempo entre cada paso de la animación
                let currentProgress = start;
                const stepSize = (end - start) * stepTime / duration; // Tamaño de cada paso
                const interval = setInterval(() => {
                    currentProgress += stepSize;
                    if ((stepSize > 0 && currentProgress >= end) || (stepSize < 0 && currentProgress <= end)) {
                        currentProgress = end;
                        clearInterval(interval);
                    }
                    this.uploadProgress = currentProgress;
                }, stepTime);
            },

            async updateVideoStatus(status) {
                let res = await updateVideoModel(this.video.id, {
                    status: status,
                });
            }

        },
    }
</script>