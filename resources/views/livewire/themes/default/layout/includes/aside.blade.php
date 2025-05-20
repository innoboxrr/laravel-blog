<div class="col-span-3 lg:col-span-1 md:flex flex-wrap lg:block lg:flex-nowrap">
    <section class="side-section text-center mt-7.5 lg:mt-0 pt-45px">
        <img
            class=" mb-4.5 mx-auto"
            src="{{ $asideData['author.avatar'] }}"
            alt="Profile picture"
            width="100"
            height="100"
            >
        <h2 class="text-17px mb-2" @if($asideData['author.name'] == null) style="display: none;" @endif>
            {{ $asideData['author.name'] }}
        </h2>
        <span class="author-info" @if($asideData['author.title'] == null) style="display: none;" @endif>
            {{ $asideData['author.title'] }}
        </span>
        <span class="author-info" @if($asideData['author.company'] == null) style="display: none;" @endif>
            {{ $asideData['author.company'] }}
        </span>
        <div class="author-social flex items-center justify-center mt-5 mb-27px">
            @foreach($asideData['social_icons'] as $network => $icon)
                @if(!empty($asideData['author.socias'][$network]))
                    <a 
                        href="{{ $asideData['author.socias'][$network] }}" 
                        class="social-icon" 
                        title="{{ ucfirst(str_replace('-', ' ', $network)) }}"
                        target="_blank">
                        <i class="fab {{ $icon }}"></i>
                    </a>
                @endif
            @endforeach
            
        </div>
        <ul class="author-nav text-left">
            <li @if($asideData['author.resume'] == null) style="display: none;" @endif>
                <a 
                    class="author-nav-link" 
                    href="{{ $asideData['author.resume'] }}"
                    title="">
                    <i class="pe-7s-bookmarks text-3xl mr-3"></i> 
                    {{ __('Resume') }}
                </a>
            </li>
            <li @if($asideData['author.contact_url'] == null) style="display: none;" @endif>
                <a 
                    class="author-nav-link" 
                    href="{{ $asideData['author.contact_url'] }}"
                    title="">
                    <i class="pe-7s-paper-plane text-3xl mr-3"></i> 
                    {{ __('Write message') }}
                </a>
            </li>
        </ul>
    </section>
    <section class="side-section categories mt-7.5">
        <h2 class="side-section-title">
            {{ __('Categories') }}
        </h2>
        <ul>
            @foreach($asideData['categories'] as $category)
                <li class="relative">
                    <a 
                        class="category-link after:bg-blueColor"
                        href="{{ blog_route('category', ['blog' => $blog->id, 'category' => $category->slug]) }}" 
                        title="{{ $category->name }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
    <section 
        class="side-section advertisement p-1.5 mt-7.5"
        @if($asideData['advertisement.image'] == null && $asideData['advertisement.code'] == null) 
            style="display: none;"
        @endif>
        @if($asideData['advertisement.type'] == 'image')
            <a 
                href="{{ $asideData['advertisement.url'] }}" 
                title="{{ $asideData['advertisement.title'] }}"
                target="_blank">
                <img
                    class=" w-full h-full"
                    src="{{ $asideData['advertisement.image'] }}" 
                    alt="{{ $asideData['advertisement.alt'] }}"
                    width="277"
                    height="328" />
            </a>
        @else
            <div class="w-full h-full">
                {!! $asideData['advertisement.code'] !!}
            </div>
        @endif
    </section>
    <section class="side-section tags mt-7.5">
        <h2 class="side-section-title">
            {{ __('Tags') }}
        </h2>
        <ul class="tags-content pt-29px px-29px pb-5.5">
            @foreach($asideData['tags'] as $tag)
                <li class="badge">
                    <a 
                        class="badge-link" 
                        href="{{ blog_route('tag', ['blog' => $blog->id, 'tag' => $tag->id]) }}" 
                        title="{{ $tag->name }}">
                        {{ $tag->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
</div>