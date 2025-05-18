<div>
    <section class="blog-post-bottom-section">
        <div class="container mx-auto">
            <div>
                <div class="last-read py-4.5">
                    <h2 class="text-lg text-bodyColor mb-4.5 leading-46px">
                        Últimas Lecturas
                    </h2>

                    <div class="article-banners">
                        <div class="grid grid-cols-3 gap-x-6">
                            @foreach($relatedPosts as $related)
                                <div class="col-span-3 md:col-span-1">
                                    <div class="article-banner-wrapper">
                                        <a 
                                            class="group" 
                                            href="{{ blog_post_route($related) }}" 
                                            title="{{ $related->title }}">
                                            <div class="relative h-full w-full py-5.5 px-7.5 group-hover:bg-bodyBg transition-colors duration-200">
                                                <h2 class="h2">{{ $related->title }}</h2>
                                                @php
                                                    $category = $related->categories->first();
                                                    $colors = ['blue', 'green', 'red', 'yellow', 'purple', 'indigo', 'pink'];
                                                    $color = $colors[array_rand($colors)];
                                                @endphp
                                                <span class="category-tag !border-{{ $color }}Color !text-{{ $color }}Color">
                                                    {{ $category->name ?? 'General' }}
                                                </span>
                                                <p class="text-13px text-bodyColor font-primary mt-2.5">
                                                    {{ Str::limit(strip_tags($related->content), 100) }}
                                                </p>
                                                <time datetime="{{ $related->published_at?->format('Y-m-d') }}" class="banner-time !text-primary">
                                                    {{ $related->published_at?->format('F j, Y') }}
                                                </time>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
