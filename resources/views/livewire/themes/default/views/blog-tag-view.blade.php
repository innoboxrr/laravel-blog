<div>
    <div class="container mx-auto mt-8 px-4">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-semibold text-grey-800">
                    {{ __('Tag') }}: 
                    <span class="text-blue-600 dark:text-blue-400">“{{ $tag->name }}”</span>
                </h1>
                <p class="mt-1 text-sm text-gray-400">
                    {{ __('Total posts') }}: <strong>{{ $posts->total() }}</strong> — 
                    {{ __('Showing') }} <strong>{{ $posts->count() }}</strong> {{ __('per page') }}
                </p>
            </div>
            <a href="{{ blog_route('index', ['blog' => $blog->id]) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-md hover:bg-gray-700 transition dark:bg-gray-700 dark:hover:bg-gray-600">
                ← {{ __('Back to home') }}
            </a>
        </div>
    </div>

    <div class="container mx-auto mt-4">
        <div class="grid lg:grid-cols-3 gap-x-0 md:gap-x-6">
            <div class="col-span-3 lg:col-span-2">
                <section class="articles">
                    @foreach($posts as $post)
                        @livewire('laravel-blog::livewire.components.blog-post-card', [
                            'post' => $post,
                            'color' => 'blue',
                        ], key($post->id))
                    @endforeach
                    {{ $posts->links() }}
                </section>
            </div>
            @include($themeDir . '.layout.includes.aside')
        </div>
    </div>

    @livewire('laravel-blog::livewire.components.subscribe-component', [
        'showName' => true,
        'showPhone' => true,
        'alwaysShow' => false
    ])
</div>
