<header class="shadow-header bg-white">
    <div class="container mx-auto">
        <div class="header-top flex justify-between items-center pt-5 pb-3.5 lg:border-b border-b-border border-borderColor">
            <div class="header-top-logo">
                <a href="{{ blog_route('index', ['blog' => $blog->id]) }}" title="Logo">
                <img  
                    src="{{ $layoutData['logo'] }}" 
                    alt="Dblog Logo"
                    width="32"
                    height="32" />
                </a>
            </div>
            <div class="header-top-text hidden lg:block">
                <p class="font-primary">
                    <a href="{{ blog_route('index', ['blog' => $blog->id]) }}" title="Logo">
                        {{ $layoutData['title'] }}
                    </a>
                </p>
            </div>
            <div class="flex items-center relative">
                <div class="header-top-search mr-2.5 lg:mr-0">
                    <div class="header-top-search-btn w-7 h-7">
                        <i class="pe-7s-search text-3xl text-primary cursor-pointer"></i>
                    </div>
                    <form 
                        id="search-form" 
                        class="absolute top-[calc(50%-24px)] right-0 w-200px mr-10 lg:mr-0 @if(request('search')) block @else hidden @endif" 
                        action="/" 
                        method="get">
                        <input 
                            type="text" 
                            name="search"
                            class="form-control" 
                            value="{{ request('search') }}"
                            placeholder="Search...">
                    </form>
                </div>
                <a href="#" class="light-link" title="Menu">
                    <div id="menu-animate-icon" class="block lg:hidden w-6 h-4.5 relative rotate-0 transition-transform cursor-pointer ml-2.5">
                        <span class="top-0 origin-left"></span>
                        <span class="top-2 origin-left"></span>
                        <span class="top-4 origin-left"></span>
                    </div>
                </a>
            </div>
        </div>
        <nav class="header-nav-desktop hidden lg:block py-5">
            <ul class="block lg:flex">
                <li class="ml-0 mr-5">
                    <a 
                        class="{{ request()->is('/') ? 'active-link' : '' }}" 
                        href="{{ blog_route('index', ['blog' => $blog->id]) }}" 
                        title="Home">
                        {{ __('Home') }}
                    </a>
                </li>
                <li class="relative mx-5 group">
                    <a 
                        href="#" 
                        class="dropdown-toggle light-link pb-10 after:absolute after:top-[calc(50%-18px)] after:-ml-0.5 after:text-24px after:font-icons after:content-['\e688'] after:transition-all lg:group-hover:after:rotate-180" title="Blog articles">
                        {{ __('Categories') }}
                    </a>
                    <ul class="dropdown-menu hidden lg:group-hover:block">
                        @foreach($layoutData['categories'] as $category)
                            <li class="after:bg-blueColor">
                                <a href="{{ blog_route('category', ['blog' => $blog->id, 'category' => $category->slug]) }}" title="{{ $category->name }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                {{--
                <li class="mx-5">
                    <a class="light-link" href="about_me.html" title="About me">About me</a>
                </li>
                <li class="mx-5">
                    <a class="light-link" href="portfolio.html" title="My projects">My projects</a>
                </li>
                --}}
                <li class="buyproducts-link ml-auto flex">
                    <a 
                        class="text-secondary flex items-center group" 
                        href="{{ blog_route('contact', ['blog' => $blog->id]) }}" 
                        title="Contacto">
                        <i class="pe-7s-mail text-3xl text-primary mr-2.5 group-hover:text-secondary"></i>
                        <span class="group-hover:underline">
                            Contacto
                        </span>
                    </a>
                </li>
                @auth
                    <li class="ml-5 flex items-center gap-3">
                        <span class="text-secondary flex items-center group">
                            <i class="pe-7s-user text-3xl text-primary mr-2.5 group-hover:text-secondary"></i>
                            {{ Auth::user()->name }}
                        </span>
                        <form method="POST" action="{{ blog_route('logout', ['blog' => $blog->id]) }}">
                            @csrf
                            <a href="#" class="text-secondary flex items-center group"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="pe-7s-power text-3xl text-primary mr-2.5 group-hover:text-secondary"></i>
                                <span class="group-hover:underline">Cerrar sesión</span>
                            </a>
                        </form>
                    </li>
                @else
                    <li class="ml-5 flex items-center">
                        <a 
                            href="{{ blog_route('login', ['blog' => $blog->id]) }}?redirect={{ urlencode(request()->fullUrl()) }}" 
                            class="text-secondary flex items-center group">
                            <i class="pe-7s-user text-3xl text-primary mr-2.5 group-hover:text-secondary"></i>
                            <span class="group-hover:underline">Iniciar sesión</span>
                        </a>
                    </li>
                @endauth

            </ul>
        </nav>
    </div>
</header>