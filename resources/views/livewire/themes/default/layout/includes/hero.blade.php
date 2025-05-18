@php
    $shuffled = $posts->shuffle()->take(5)->values(); // random y aseguramos índice
@endphp

<section class="banners py-5 md:py-10">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-4 lg:grid-cols-6 gap-x-0 md:gap-x-6">
            @foreach($shuffled as $index => $post)
                <div class="md:px-0
                    @if($index < 2) md:col-span-2 lg:col-span-3
                    @else md:col-span-2 lg:col-span-2
                    @endif
                ">
                    <div class="banner-wrapper">
                        <a class="group" href="{{ blog_post_route($post) }}" title="{{ $post->title }}">
                            <div class="banner-wrapper-content">
                                <h2 class="h2 text-white">{{ $post->title }}</h2>
                                @if($post->categories->first())
                                    <span class="category-tag">{{ $post->categories->first()->name }}</span>
                                @endif
                                <time datetime="{{ optional($post->published_at ?? $post->created_at)->toDateString() }}" class="banner-time">
                                    {{ optional($post->published_at ?? $post->created_at)->format('F d, Y') }}
                                </time>
                            </div>
                        </a>
                        <img 
                            src="{{ data_get($post->payload, 'images.large') ?? asset('images/default-banner.webp') }}"
                            alt="{{ $post->title }}"
                            class="w-full"
                            width="434"
                            height="371" />
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
