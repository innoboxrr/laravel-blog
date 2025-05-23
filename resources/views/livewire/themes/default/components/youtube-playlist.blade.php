<div class="mb-10">
    @if($currentVideoId)
        <div class="relative w-full mb-6">
            <div class="aspect-video bg-black rounded overflow-hidden">
                <iframe
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/{{ $currentVideoId }}?autoplay=1"
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    @endif

    <div class="relative group" @if(count($playlist) <= 1) hidden @endif>
        <!-- Botón Anterior -->
        <button
            type="button"
            onclick="document.getElementById('youtubePlaylistScroll').scrollBy({ left: -320, behavior: 'smooth' })"
            class="absolute left-0 top-0 bottom-0 z-10 flex items-center justify-center px-2 bg-gradient-to-r from-white via-white/80 to-transparent hover:from-gray-100 rounded-l transition duration-200"
        >
            <svg class="w-5 h-5 text-gray-600 hover:text-gray-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Lista horizontal de videos -->
        <div
            id="youtubePlaylistScroll"
            class="flex gap-4 overflow-x-auto px-1 py-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent scroll-smooth snap-x snap-mandatory"
        >
            @foreach($playlist as $video)
                <div
                    wire:click="selectVideo('{{ $video['id'] }}')"
                    class="cursor-pointer snap-start shrink-0 w-48 md:w-56 border rounded shadow-sm hover:shadow-md transition bg-white {{ $video['id'] === $currentVideoId ? 'ring-2 ring-blue-500' : '' }}"
                >
                    <img
                        src="https://img.youtube.com/vi/{{ $video['id'] }}/hqdefault.jpg"
                        alt="{{ $video['title'] ?? 'Video' }}"
                        class="w-full h-32 object-cover rounded-t"
                    >
                    <div class="p-2">
                        <div class="text-sm font-semibold line-clamp-2">
                            {{ $video['title'] ?? 'Título no disponible' }}
                        </div>
                        <div class="text-xs text-gray-400 mt-1 truncate">
                            {{ $video['id'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Botón Siguiente -->
        <button
            type="button"
            onclick="document.getElementById('youtubePlaylistScroll').scrollBy({ left: 320, behavior: 'smooth' })"
            class="absolute right-0 top-0 bottom-0 z-10 flex items-center justify-center px-2 bg-gradient-to-l from-white via-white/80 to-transparent hover:from-gray-100 rounded-r transition duration-200"
        >
            <svg class="w-5 h-5 text-gray-600 hover:text-gray-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>
