<div 
    x-data="{ copied: false }" 
    class="col-span-7 lg:col-span-1 p-5 md:p-0"
>
    <div class="side-section md:ml-7.5 md:mb-7.5 lg:ml-0">
        <h3 class="side-section-title !text-15px !py-5 !px-4">
            {{ __('Share this post') }}
        </h3>

        <ul class="py-2.5 space-y-2.5">
            <li class="px-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($postUrl) }}" 
                   class="text-13px flex items-center hover:text-blue-600 transition" 
                   target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-facebook-f w-4 mr-2.5"></i> Facebook
                </a>
            </li>
            <li class="px-4">
                <a href="https://twitter.com/intent/tweet?url={{ urlencode($postUrl) }}&text={{ urlencode($post->title) }}" 
                   class="text-13px flex items-center hover:text-black transition" 
                   target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-x-twitter w-4 mr-2.5"></i> X (Twitter)
                </a>
            </li>
            <li class="px-4">
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($postUrl) }}&title={{ urlencode($post->title) }}" 
                   class="text-13px flex items-center hover:text-blue-800 transition" 
                   target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-linkedin-in w-4 mr-2.5"></i> LinkedIn
                </a>
            </li>
            <li class="px-4">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . $postUrl) }}" 
                   class="text-13px flex items-center hover:text-green-600 transition" 
                   target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-whatsapp w-4 mr-2.5"></i> WhatsApp
                </a>
            </li>
            <li class="px-4">
                <a href="https://t.me/share/url?url={{ urlencode($postUrl) }}&text={{ urlencode($post->title) }}" 
                   class="text-13px flex items-center hover:text-blue-500 transition" 
                   target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-telegram-plane w-4 mr-2.5"></i> Telegram
                </a>
            </li>
            <li class="px-4">
                <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode($postUrl) }}" 
                   class="text-13px flex items-center hover:text-gray-600 transition">
                    <i class="fas fa-envelope w-4 mr-2.5"></i> Email
                </a>
            </li>
        </ul>

        <div class="px-4 pt-4">
            <button
                @click="navigator.clipboard.writeText('{{ $postUrl }}'); copied = true; setTimeout(() => copied = false, 2000);"
                class="text-13px flex items-center px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 transition"
            >
                <i class="fas fa-link mr-2.5"></i>
                {{ __('Copy link') }}
            </button>
            <span x-show="copied" x-transition class="text-green-600 text-xs mt-1 block">
                {{ __('Link copied!') }}
            </span>
        </div>
    </div>
</div>
