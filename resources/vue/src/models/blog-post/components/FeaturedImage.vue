<template>
    <div 
        class="col-span-full"
        @dragover.prevent="handleDragOver"
        @drop.prevent="handleDrop"
        @dragleave="dragging = false">
        <div 
            class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
            :class="{ 'bg-gray-100': dragging }">
            <div class="text-center">
                <PhotoIcon class="mx-auto size-12 text-gray-300" aria-hidden="true" />
                <div class="mt-4 flex text-sm/6 text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                        <span>
                            {{ __blog('Upload a file') }}
                        </span>
                        <input 
                            id="file-upload" 
                            name="file-upload" 
                            type="file" 
                            class="sr-only" 
                            @change="handleFileChange" 
                        />
                    </label>
                    <p class="pl-1">
                        {{ __blog('or drag and drop') }}
                    </p>
                </div>
                <p class="text-xs/5 text-gray-600">
                    {{ __blog('PNG, JPG, GIF up to 10MB') }}
                </p>
            </div>
        </div>
        <div v-if="previewImage || previewUrl" class="mt-4 relative">
            <img :src="previewImage || previewUrl" alt="Preview Image" class="w-full rounded-md" />
            <button 
                @click="removeImage"
                class="absolute top-2 right-2 text-red-600 rounded-full p-1 hover:text-red-400"
                title="Remove image">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>
</template>

<script>
    import { PhotoIcon } from '@heroicons/vue/24/solid';

    export default {
        components: {
            PhotoIcon,
        },
        props: {
            // Imagen previa opcional desde el padre
            previewImage: {
                type: String,
                default: null,
            },
        },
        emits: ['onFeaturedImageChange'],
        data() {
            return {
                previewUrl: null, // URL para la previsualización local
                dragging: false, // Estado para resaltar el área de carga en drag & drop
            };
        },
        methods: {
            handleFileChange(event) {
                const file = event.target.files[0];
                this.processFile(file);
            },
            handleDragOver() {
                this.dragging = true;
            },
            handleDrop(event) {
                this.dragging = false;
                const file = event.dataTransfer.files[0];
                this.processFile(file);
            },
            processFile(file) {
                if (file) {
                    // Crear una URL para previsualizar la imagen localmente
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewUrl = e.target.result; // Mostrar la previsualización
                    };
                    reader.readAsDataURL(file);

                    let formData = new FormData();
                    const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    formData.append('_token', csrf_token);
                    formData.append('file', file);
                    formData.append('visibility', 'public');

                    fetch(this.fileUploadUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                        return response.json();
                        } else {
                        throw new Error('An error has occurred');
                        }
                    })
                    .then(data => {
                        this.$emit('onFeaturedImageChange', data.path);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
            },
            removeImage() {
                // Limpiar la previsualización y emitir el evento al padre
                this.previewUrl = null;
                this.$emit('onFeaturedImageChange', null);
            },
        },
    };
</script>

<style scoped>
.bg-gray-100 {
    background-color: #f7fafc;
}
</style>
