<template>
    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">
            🎥 {{ label }}
        </label>

        <div class="space-y-2">
            <div 
                v-for="(video, index) in localPlaylist" 
                :key="index"
                class="flex items-center gap-4 p-2 border rounded-md shadow-sm bg-white">
                
                <img 
                    :src="'https://img.youtube.com/vi/' + video.id + '/hqdefault.jpg'" 
                    alt="Thumbnail" 
                    class="w-20 h-auto rounded"
                >

                <div class="flex-1">
                    <div class="font-semibold text-sm">{{ video.title || 'Título no disponible' }}</div>
                    <div class="text-xs text-gray-500">{{ video.id }}</div>
                </div>

                <button 
                    @click="removeVideo(index)" 
                    type="button" 
                    class="text-red-500 hover:text-red-700 text-sm">
                    ✖
                </button>
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <input 
                v-model="newVideoId" 
                type="text" 
                placeholder="ID de video de YouTube" 
                :class="inputClass"
            >
            <button 
                type="button" 
                @click="addVideo" 
                class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                Añadir
            </button>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'YoutubePlaylist',
        props: {
            modelValue: {
                type: Array,
                default: () => [],
            },
            label: {
                type: String,
                default: 'Playlist de YouTube',
            }
        },
        emits: ['update:modelValue'],
        data() {
            return {
                newVideoId: '',
                localPlaylist: [],
            };
        },
        watch: {
            modelValue: {
                handler(val) {
                    this.localPlaylist = [...val];
                },
                immediate: true,
                deep: true,
            }
        },
        methods: {
            async addVideo() {
                const raw = this.newVideoId.trim();
                if (!raw) return;

                const id = this.extractVideoId(raw);
                if (!id) return;

                const title = await this.fetchTitle(id);

                this.localPlaylist.push({ id, title });
                this.newVideoId = '';
                this.emitUpdate();
            },

            extractVideoId(input) {
                // Si es un ID simple (11 caracteres, alfanumérico)
                if (/^[a-zA-Z0-9_-]{11}$/.test(input)) {
                    return input;
                }

                // Extrae ID desde varias formas de URL
                const regex = /(?:v=|\/embed\/|\.be\/)([a-zA-Z0-9_-]{11})/;
                const match = input.match(regex);
                return match ? match[1] : null;
            },

            removeVideo(index) {
                this.localPlaylist.splice(index, 1);
                this.emitUpdate();
            },

            emitUpdate() {
                this.$emit('update:modelValue', this.localPlaylist);
            },

            async fetchTitle(videoId) {
                try {
                    const res = await fetch(`https://noembed.com/embed?url=https://www.youtube.com/watch?v=${videoId}`);
                    const data = await res.json();
                    return data.title || 'Título no disponible';
                } catch (e) {
                    return 'Título no disponible';
                }
            }
        }
    };
</script>
