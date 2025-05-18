<article class="article before:bg-{{ $color }}Color my-7.5">
    <div class="articles-header">
        <time datetime="{{ $post->created_at->toDateString() }}">
            {{ $post->created_at->diffForHumans() }}
        </time>
        @if($category)
            <span class="articles-header-category">
                <a  
                    href="{{ blog_category_route($category) }}" 
                    class="text-{{ $color }}Color hover:underline float-right" title="">
                    {{ $category->name }}
                </a>
            </span>
        @endif
    </div>
    <div class="articles-content px-8">
        <h2 class="text-3xl leading-10 md:text-4xl md:leading-46px my-6.5">
            <a 
                class="text-secondary font-black hover:underline" 
                href="{{ blog_post_route($post) }}">
                {{ $post->title }}
            </a>
        </h2>
        <p class="font-secondary">
            {{ \Illuminate\Support\Str::limit($post->excerpt ?? strip_tags($post->content), 200) }}
        </p>
    </div>
    <div class="articles-footer">
        <ul class="articles-footer-info flex items-center mb-5 md:mb-0">
            <li>
                <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                    <i class="pe-7s-comment text-4xl mr-3 text-secondary"></i>
                    {{ $post->comments_count ?? 0 }} {{ __('Comments') }}
                </a>
            </li>
            <li class="ml-5.5">
                <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                    <i class="pe-7s-like text-4xl mr-3 text-secondary"></i>
                    {{ $post->likes_count ?? 0 }}
                </a>
            </li>
        </ul>
        <a class="btn" href="{{ blog_post_route($post) }}">
            {{ __('Read more') }}
        </a>
    </div>
</article>
