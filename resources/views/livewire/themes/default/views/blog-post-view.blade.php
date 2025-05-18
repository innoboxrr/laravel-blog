<div class="mt-10">
	<div class="article-navigation fixed bottom-0 w-full z-10">
		<ul class="flex justify-between">
			@if($previous)
				<li class="article-navigation-item">
					<a 
						class="article-navigation-item-link" 
						href="{{ blog_post_route($previous) }}"
						title="{{ __('Previous Article') }}">
						<div class="flex items-center justify-center md:justify-start">
							<i class="pe-7s-angle-left md:-ml-6.5 text-2xl"></i>
							<p class="font-primary">
								{{ __('Previous article') }}
							</p>
						</div>
						<h3 class="hidden md:block text-lg text-primary mb-1 font-black">
							{{ \Str::limit($previous->title, limit: 20) }}
						</h3>
					</a>
				</li>
			@else
				<li class="article-navigation-item"></li>
			@endif
			@if($next)
				<li class="article-navigation-item">
					<a 
						class="article-navigation-item-link" 
						href="{{ blog_post_route($next) }}"
						title="{{ __('Next Article') }}">
						<div class="flex items-center flex-row-reverse md:flex-row justify-center md:justify-start">
							<i class="pe-7s-angle-right md:-ml-6.5 text-2xl"></i>
							<p class="font-primary">
								{{ __('Next article') }}
							</p>
						</div>
						<h3 class="hidden md:block text-lg text-primary mb-1 font-black">
							{{ \Str::limit($next->title, limit: 20) }}
						</h3>
					</a>
				</li>
			@endif
		</ul>
	</div>
	<div class="container mx-auto">
		<div class="grid grid-cols-7 gap-x-0 md:gap-x-3 bg-white shadow-block">
			<div class="col-span-7 lg:col-span-6">
				<article>
					<div class="articles-header">
						<time datetime="2022-10-11">
							<span class="text-13px text-primary font-primary">
								{{ $post->created_at->format('F j, Y') }}
							</span>
						</time>
						<span class="articles-header-tag">
							{{ $post->tag ?? 'Hot' }}
						</span>
						<span class="articles-header-category">
							<a 
								href="{{ blog_category_route($category) }}"
								class="text-greenColor hover:underline float-right" 
								title="">
								{{ $category->name }}
							</a>
						</span>
					</div>
					<div class="articles-content px-8">
					<h1 class="text-3xl leading-10 md:text-42px md:leading-62px text-secondary font-black my-6.5">
						<a 
							class="hover:underline" 
							href="#" 
							title="{{ $post->title }}">
							{{ $post->title }}
						</a>
					</h1>
					<div class="mb-12 blog-post-article-text">{!! $post->content !!}</div>
					</div>
				</article>
			</div>
			@livewire('laravel-blog::livewire.components.share-post', [
				'post' => $post
			])
		</div>
	</div>
	<div class="mt-10"></div>
	@livewire('laravel-blog::livewire.components.post-about-author', [
		'post' => $post,
	])
	@livewire('laravel-blog::livewire.components.related-posts', [
		'post' => $post
	])

	<livewire:comments :model="$post"/>
</div>