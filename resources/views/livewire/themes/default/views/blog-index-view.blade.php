<div>
    @if(empty($search))
        @include($themeDir . '.layout.includes.hero')
    @else
        <div class="container mx-auto mt-8 px-4">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 dark:text-white">
                        {{ __('Search results for') }}:
                        <span class="text-blue-600 dark:text-blue-400">“{{ $search }}”</span>
                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        {{ __('We found') }} <strong>{{ $posts->total() }}</strong> {{ __('results') }} —
                        {{ __('Showing') }} <strong>{{ $posts->count() }}</strong> {{ __('per page') }}
                    </p>
                </div>
                <a href="{{ blog_route('index', ['blog' => $blog->id]) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-md hover:bg-gray-700 transition dark:bg-gray-700 dark:hover:bg-gray-600">
                    ← {{ __('Back to home') }}
                </a>
            </div>
        </div>
    @endif
    <div class="container mx-auto mt-4">
        <div class="grid lg:grid-cols-3 gap-x-0 md:gap-x-6">
            <div class="col-span-3 lg:col-span-2">
                <section class="articles">
                    <article class="article before:bg-blueColor mb-7.5">
                        <div class="articles-header">
                            <time datetime="2022-10-11">12 hours ago</time>
                            <span class="articles-header-tag">Hot</span>
                            <span class="articles-header-category">
                            <a href="#" class="text-blueColor hover:underline float-right" title="">CSS</a>
                            </span>
                        </div>
                        <div class="articles-content px-8">
                            <h2 class="text-3xl leading-10 md:text-4xl md:leading-46px my-6.5">
                                <a class="text-secondary font-black hover:underline" href="blog_post.html" title="">
                                10 Interview Questions Every JavaScript Developer
                                Should Know
                                </a>
                            </h2>
                            <p class="font-secondary">
                                I was young, single, and freshly employed to direct National Journal’s Presentation
                                Center, a searchable library of white-label
                                PowerPoint presentations on political and policy developments. By day, I led a team of
                                fellows in creating data
                                visualizations...
                            </p>
                        </div>
                        <div class="articles-footer">
                            <ul class="articles-footer-info flex items-center mb-5 md:mb-0">
                                <li>
                                    <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                                    <i class="pe-7s-comment text-4xl mr-3 text-secondary"></i> 
                                    7 Response
                                    </a>
                                </li>
                                <li class="ml-5.5">
                                    <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                                    <i class="pe-7s-like text-4xl mr-3 text-secondary"></i> 
                                    1221
                                    </a>
                                </li>
                            </ul>
                            <a title="" class="btn" href="blog_post.html">Read more</a>
                        </div>
                    </article>
                    <article class="article before:bg-redColor my-7.5">
                        <div class="articles-header">
                            <time datetime="2022-10-11">January 16, 2022</time>
                            <span class="articles-header-category">
                            <a href="#" class="text-redColor hover:underline float-right" title="">Javascript</a>
                            </span>
                        </div>
                        <div class="articles-content px-8">
                            <h2 class="text-3xl leading-10 md:text-4xl md:leading-46px my-6.5">
                                <a class="text-secondary font-black hover:underline" href="blog_post.html" title="">
                                State of the Art JavaScript in 2022
                                </a>
                            </h2>
                            <p class="font-secondary">
                                Class in JS is not harmless sugar for prototypal OO. Class is a virus that infects
                                everything it touches. It came to us formally
                                in
                                JavaScript with ES6, and at the same time, React was taking off. Lots of people started
                                using classes for React components...
                            </p>
                        </div>
                        <div class="articles-footer">
                            <ul class="articles-footer-info flex items-center mb-5 md:mb-0">
                                <li>
                                    <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                                    <i class="pe-7s-comment text-4xl mr-3 text-secondary"></i> 
                                    7 Response
                                    </a>
                                </li>
                                <li class="ml-5.5">
                                    <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                                    <i class="pe-7s-like text-4xl mr-3 text-secondary"></i> 
                                    1221
                                    </a>
                                </li>
                            </ul>
                            <a title="" class="btn" href="blog_post.html">Read more</a>
                        </div>
                    </article>
                    <article class="article before:bg-yellowColor my-7.5">
                        <div class="articles-header">
                            <time datetime="2022-10-11">12 hours ago</time>
                            <span class="articles-header-category">
                            <a href="#" class="text-yellowColor hover:underline float-right" title="">CSS</a>
                            </span>
                        </div>
                        <div class="articles-content px-8">
                            <h2 class="text-3xl leading-10 md:text-4xl md:leading-46px my-6.5">
                                <a class="text-secondary font-black hover:underline" href="blog_post.html" title="">
                                Want to learn JavaScript in 2022?
                                </a>
                            </h2>
                            <p class="font-secondary">
                                This is a walk-through of the steps I personally took in a single year, to begin
                                learning JavaScript. My goal was to be able to
                                get
                                a job in a position where Javascript would be at the forefront of what I do on a daily
                                basis...
                            </p>
                        </div>
                        <div class="articles-footer">
                            <ul class="articles-footer-info flex items-center mb-5 md:mb-0">
                                <li>
                                    <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                                    <i class="pe-7s-comment text-4xl mr-3 text-secondary"></i> 
                                    7 Response
                                    </a>
                                </li>
                                <li class="ml-5.5">
                                    <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                                    <i class="pe-7s-like text-4xl mr-3 text-secondary"></i> 
                                    1221
                                    </a>
                                </li>
                            </ul>
                            <a title="" class="btn" href="blog_post.html">Read more</a>
                        </div>
                    </article>
                    <article class="article before:bg-greenColor my-7.5">
                        <div class="articles-header">
                            <time datetime="2022-10-11">12 hours ago</time>
                            <span class="articles-header-category">
                            <a href="#" class="hover:underline float-right" title="">Other</a>
                            </span>
                        </div>
                        <div class="articles-content px-8">
                            <h2 class="text-3xl leading-10 md:text-4xl md:leading-46px my-6.5">
                                <a class="text-secondary font-black hover:underline" href="blog_post.html" title="">
                                Want to learn JavaScript in 2022?
                                </a>
                            </h2>
                            <p class="font-secondary">
                                This is a walk-through of the steps I personally took in a single year, to begin
                                learning JavaScript. My goal was to be able to
                                get
                                a job in a position where Javascript would be at the forefront of what I do on a daily
                                basis...
                            </p>
                        </div>
                        <div class="articles-footer">
                            <ul class="articles-footer-info flex items-center mb-5 md:mb-0">
                                <li>
                                    <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                                    <i class="pe-7s-comment text-4xl mr-3 text-secondary"></i> 
                                    7 Response
                                    </a>
                                </li>
                                <li class="ml-5.5">
                                    <a href="#" class="text-primary flex items-center hover:text-secondary transition-colors duration-200" title="">
                                    <i class="pe-7s-like text-4xl mr-3 text-secondary"></i> 
                                    1221
                                    </a>
                                </li>
                            </ul>
                            <a title="" class="btn" href="blog_post.html">Read more</a>
                        </div>
                    </article>
                    <!-- PAGINATION -->
                    <nav class="flex justify-between items-center text-center border-t border-solid border-borderColor py-7.5 overflow-auto" aria-label="...">
                        <a title="" href="#" class="btn-small pagination-back">Back</a>
                        <ul class="pagination hidden md:flex">
                            <li class="pagination-active">
                                <a class="pagination-page-link" href="#">1 <span class="sr-only">(current)</span></a>
                            </li>
                            <li><a class="pagination-page-link" href="#">2</a></li>
                            <li><a class="pagination-page-link" href="#">3</a></li>
                            <li><a class="pagination-page-link" href="#">...</a></li>
                            <li><a class="pagination-page-link" href="#">25</a></li>
                        </ul>
                        <a title="" href="blog_post.html" class="btn-small pagination-next">Next</a>
                    </nav>
                </section>
            </div>
            @include($themeDir . '.layout.includes.aside')
        </div>
    </div>
</div>
