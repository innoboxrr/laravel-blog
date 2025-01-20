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

        <div class="mt-4">
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
                this.fileName = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15) + '.mp4';
                this.fileSize = this.file.size;

                this.startUpload();
            },

            async startUpload() {
                // let duration = await this.getVideoDuration(this.file);
                this.isUploading = true;
                this.createVideoPreview();

                let csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let code = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);

                // video-id debe venir de la solicitud previa 
                this.uploader = new MultipartUploader(code, {
                    token: csrf_token, // csrf
                    filename: this.fileName,
                    initiateUploadRoute: route('s3resumableuploads.initiate.upload'),
                    signPartUploadRoute: route('s3resumableuploads.sign.part.upload'),
                    completeUploadRoute: route('s3resumableuploads.complete.upload'),
                    chunkSize: 5,
                });

                this.uploader.on('progress', progress => {
                    this.animateProgress(this.uploadProgress, progress);
                });

                this.uploader.startUpload(this.file).catch(error => {
                    console.error('Error al subir el archivo', error);
                });

                this.uploader.on('complete', status => {
                    console.log('status', status);
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
        },
    }
</script>