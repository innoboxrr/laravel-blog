<footer class="bg-white pt-8 mt-10">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-3 gap-x-0 md:gap-x-6">
            <div class="col-span-1">
                <div class="footer-section my-38px">
                    <h3 class="footer-section-title">
                        {{ __('Latest Posts') }}
                    </h3>
                    <ul class="footer-section-content">
                        @foreach ($layoutData['latest_posts'] as $post)
                            <li class="footer-section-content-response flex gap-3">
                                <img
                                    src="{{ $post->thumbnail_image }}"
                                    alt="{{ $post->title }}"
                                    class="w-12 h-12 rounded object-cover"
                                    loading="lazy"
                                >
                                <div>
                                    <h4>
                                        <a class="text-secondary hover:underline"
                                        href="{{ blog_post_route($post) }}">
                                        {{ \Illuminate\Support\Str::limit($post->title, 50) }}
                                        </a>
                                    </h4>
                                    <time datetime="{{ $post->published_at->toIso8601String() }}">
                                        {{ $post->published_at->diffForHumans() }}
                                    </time>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-span-1">
                <div class="footer-section my-38px">
                    <h3 class="footer-section-title">
                        {{ __('Recent Comments') }}
                    </h3>
                    <ul class="footer-section-content">
                        @foreach ($layoutData['latest_comments'] as $comment)
                            <li class="footer-section-content-response">
                                <img class="footer-section-content-img"
                                    src="{{ $comment->user->avatar_url }}"
                                    alt="{{ $comment->user->name }}"
                                    width="56"
                                    height="56">
                                <div class="footer-section-content-response-wrapper">
                                    <h4>
                                        <span class="text-secondary">{{ $comment->user->name }}</span> en 
                                        <a href="{{ blog_post_route($comment->commentable) }}"
                                        class="response-subject light-link underline"
                                        title="{{ $comment->commentable->title }}">
                                        {{ \Illuminate\Support\Str::limit($comment->commentable->title, 30) }}
                                        </a>
                                    </h4>
                                    <p class="font-primary mt-2.5">{{ \Illuminate\Support\Str::limit($comment->body, 90) }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-span-1">
                <div class="footer-section my-38px border-b border-solid border-secondBorderColor">
                    <img
                        class="mb-5.5 "
                        src="{{ $layoutData['logo'] }}" 
                        alt="Logo"
                        width="32"
                        height="32"
                        >
                    <div class="footer-section-content">
                        <p class="mb-9 mt-9 font-primary">
                            {!! $layoutData['blog.footer_text'] !!}
                        </p>
                    </div>
                </div>
                <div class="footer-section my-38px">
                    <h3 class="footer-section-title mb-34px">
                        {{ __('Newsletter') }}
                    </h3>
                    <div class="footer-section-content">
                        <p class="font-primary mt-2.5 mb-4">
                            {{ __('Stay up to do date with my posts, subscribe to newsletter:') }}
                        </p>
                        <form action="{{ route('api.larablog.blog_subscriber.create') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                            <input type="hidden" name="blog_subscriber_type" value="email">
                            <input type="email" name="email" class="form-control" placeholder="{{ __('Type Email') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright flex items-center justify-between flex-col md:flex-row-reverse border-t border-solid border-borderColor py-5">
            <ul class="flex gap-2">
                @foreach($layoutData['social_icons'] as $network => $icon)
                    @if(!empty($layoutData['blog.socias'][$network]))
                        <li>
                            <a 
                                href="{{ $layoutData['blog.socias'][$network] }}" 
                                class="social-icon"
                                title="{{ ucfirst(str_replace('-', ' ', $network)) }}"
                                target="_blank" 
                                rel="noopener noreferrer">
                                <i class="fab {{ $icon }}"></i>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <p class="font-primary mt-2 md:mt-0 text-center md:text-left">
                &copy; {{ __('Powered by') }}
                <a href="#" title="" class="text-secondary hover:underline">
                    {{ config('app.name') }}
                </a>. 
                {{ date('Y') }}. {{ __('All Rights Reserved.') }}
            </p>
        </div>
    </div>
</footer>