<section class="blog-post-bottom-section">
    <div class="container mx-auto">
        <div class="pb-2.5">
            <div class="articles-info pb-4.5 md:max-w-750px">
                <div class="flex items-start md:items-center justify-between flex-col-reverse md:flex-row">
                    <button class="btn !hover:bg-secondary w-full md:w-auto">
                        <a title="Write a response" href="#">
                            {{ __('Write a response') }}
                        </a>
                    </button>
                    <ul class="flex mb-5 md:mb-0">
                        <li>
                            <a title="" href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200">
                                <i class="pe-7s-comment text-4xl mr-3 text-secondary"></i> 
                                {{ $post->responses_count ?? 0 }} {{ __('Response') }}
                            </a>
                        </li>
                        <li class="ml-5.5">
                            <a title="" href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200">
                                <i class="pe-7s-like text-4xl mr-3 text-secondary"></i> 
                                {{ $post->likes_count ?? 0 }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="articles-author bg-white shadow-block p-25px mt-7.5 flex">
                    <img 
                        class="text-bodyColor h-[75px] w-[75px] mr-5 rounded-full object-cover"
                        src="{{ $author['avatar'] }}" 
                        alt="{{ $author['name'] }}"
                    >
                    <div class="articles-author-content">
                        <div class="articles-author-header flex justify-between md:items-center flex-col md:flex-row mb-3">
                            <h4 class="text-15px text-secondary mb-3.5 md:mb-0">{{ $author['name'] }}</h4>
                            <div class="author-social flex items-center gap-2">
                                @foreach($author['social'] as $platform => $url)
                                    @if (!empty($url))
                                        <a href="{{ $url }}" class="social-icon !w-6.5 !h-6.5 !text-xs" title="{{ ucfirst($platform) }}">
                                            <i class="fab fa-{{ $platform }}"></i>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <p class="font-primary !leading-25px">
                            {{ $author['bio'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
