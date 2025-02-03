<template>
    <div class="min-h-full">
        <!-- Mobile sidebar -->
        <TransitionRoot 
            as="template" 
            :show="sidebarOpen">
            <Dialog 
                class="relative z-40 lg:hidden" 
                @close="sidebarOpen = false">
                <TransitionChild 
                    as="template" 
                    enter="transition-opacity ease-linear duration-300" 
                    enter-from="opacity-0" 
                    enter-to="opacity-100" 
                    leave="transition-opacity ease-linear duration-300" 
                    leave-from="opacity-100" 
                    leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-600/75"></div>
                </TransitionChild>
                <div class="fixed inset-0 z-40 flex">
                    <TransitionChild 
                        as="template" 
                        enter="transition ease-in-out duration-300 transform" 
                        enter-from="-translate-x-full" 
                        enter-to="translate-x-0" 
                        leave="transition ease-in-out duration-300 transform" 
                        leave-from="translate-x-0" 
                        leave-to="-translate-x-full">
                        <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-white pb-4 pt-5">
                            <TransitionChild 
                                as="template" 
                                enter="ease-in-out duration-300" 
                                enter-from="opacity-0" 
                                enter-to="opacity-100" 
                                leave="ease-in-out duration-300" 
                                leave-from="opacity-100" 
                                leave-to="opacity-0">
                                <div class="absolute right-0 top-0 -mr-12 pt-2">
                                    <button 
                                        type="button" 
                                        class="relative ml-1 flex size-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" 
                                        @click="sidebarOpen = false">
                                        <span class="absolute -inset-0.5"></span>
                                        <span class="sr-only">
                                            {{ __blog('Close sidebar') }}
                                        </span>
                                        <XMarkIcon class="size-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <div class="mt-16 h-0 flex-1 overflow-y-auto">
                                <nav class="px-2">
                                    <div class="space-y-1">
                                        <router-link
                                            v-for="item in navigation" 
                                            :key="item.name" 
                                            :to="{
                                                name: item.path,
                                                params: item.params,
                                                query: item.query
                                            }" 
                                            :class="[item.current ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center rounded-md px-2 py-2 text-base/5 font-medium']" 
                                            :aria-current="item.current ? 'page' : undefined">
                                            <component 
                                                :is="item.icon" 
                                                :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 size-6 shrink-0']" 
                                                aria-hidden="true" />
                                            {{ item.name }}
                                        </router-link>
                                    </div>
                                    <div class="mt-8">
                                        <h3 class="px-3 text-sm font-medium text-gray-500" id="mobile-categories-headline">
                                            {{ __blog('Categories') }}
                                        </h3>
                                        <div 
                                            class="mt-1 space-y-1" 
                                            role="group" 
                                            aria-labelledby="mobile-categories-headline">
                                            <a 
                                                v-for="category in categories" 
                                                :key="category.name" 
                                                @click="postFilters.category_id = category.id; updateFilters()"
                                                class="group flex items-center rounded-md px-3 py-2 text-base/5 font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                                <span :class="[category.bgColorClass ?? 'bg-indigo-500', 'mr-4 size-2.5 rounded-full']" aria-hidden="true" />
                                                <span class="truncate">
                                                    {{ categoryDashIndentation(category.level) + category.name }}
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                    <div class="w-14 shrink-0" aria-hidden="true"></div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-gray-200 lg:bg-gray-100 lg:pb-4 lg:pt-5 mt-4">
            <div class="mt-5 flex h-0 flex-1 flex-col overflow-y-auto pt-1">
                <!-- Autores -->
                <desktop-author-dropdown v-if="false"/>
                <!-- Sidebar Search -->
                <div class="mt-2 grid grid-cols-1 px-3">
                    <input 
                        type="search" 
                        name="search" 
                        aria-label="Search" 
                        @input="postFilters.search = $event.target.value; updateFilters()"
                        class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pl-10 pr-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" 
                        placeholder="Search" />
                    <MagnifyingGlassIcon 
                        class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400" 
                        aria-hidden="true" />
                </div>
                <!-- Navigation -->
                <nav class="mt-6 px-3">
                    <div class="space-y-1">
                        <router-link 
                            v-for="item in navigation" 
                            :key="item.name" 
                            :to="{
                                name: item.path,
                                params: item.params,
                                query: item.query
                            }" 
                            :class="[item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center rounded-md px-2 py-2 text-sm font-medium']" 
                            :aria-current="item.current ? 'page' : undefined">
                            <component 
                                :is="item.icon" 
                                :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 size-6 shrink-0']" 
                                aria-hidden="true" />
                            {{ __blog(item.name) }}
                        </router-link>
                    </div>
                    <div class="mt-8">
                        <!-- Secondary navigation -->
                        <h3 class="px-3 text-sm font-medium text-gray-500" id="desktop-categories-headline">
                            {{ __blog('Categories') }}
                        </h3>
                        <div class="mt-1 space-y-1" role="group" aria-labelledby="desktop-categories-headline">
                            <a 
                                v-for="category in categories" 
                                :key="category.name" 
                                @click="postFilters.category_id = category.id; updateFilters()"
                                class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                                <span :class="[category.bgColorClass ?? 'bg-indigo-500', 'mr-4 size-2.5 rounded-full']" aria-hidden="true"></span>
                                <span class="truncate">
                                    {{ categoryDashIndentation(category.level) + category.name }}
                                </span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="flex flex-col lg:pl-64">
            <!-- Search header -->
            <div class="sticky top-0 z-10 flex h-16 shrink-0 border-b border-gray-200 bg-white lg:hidden">
                <button 
                    type="button" 
                    class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden" 
                    @click="sidebarOpen = true">
                    <span class="sr-only">
                        {{ __blog('Open sidebar') }}
                    </span>
                    <Bars3CenterLeftIcon class="size-6" aria-hidden="true" />
                </button>
                <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
                    <form class="grid w-full flex-1 grid-cols-1" action="#" method="GET">
                        <input 
                            type="search" 
                            name="search" 
                            aria-label="Search" 
                            style="outline: none; box-shadow: none;" 
                            @input="postFilters.search = $event.target.value; updateFilters()"
                            class="col-start-1 row-start-1 block size-full border-0 rounded-md bg-white py-2 pl-8 pr-3 text-base text-gray-900 placeholder:text-gray-400 sm:text-sm/6"
                            placeholder="Search" />
                        <MagnifyingGlassIcon 
                            class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400" 
                            aria-hidden="true" />
                    </form>
                    <div class="flex items-center">
                        <!-- Autores -->
                        <mobile-author-dropdown v-if="false" />
                    </div>
                </div>
            </div>
            <main class="flex-1">
                <div class="border-b border-gray-200 px-4 py-2 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8 hidden md:flex">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-lg/6 font-medium text-gray-900 sm:truncate">
                            {{ __blog(title) }}
                        </h1>
                    </div>
                    <div class="mt-4 flex sm:ml-4 sm:mt-0">
                        <router-link 
                            :to="{
                                name: 'BlogPostsEditor'
                            }"
                            type="button" 
                            class="order-[0] inline-flex items-center rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600 sm:order-1 sm:ml-3 hover:text-white">
                            <i class="fas fa-plus mr-2 mt-1"></i>
                            {{ __blog('New post') }}
                        </router-link>  
                    </div>
                </div>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>


<script>
    import { watch, toRefs, getCurrentInstance } from 'vue';
    import { debounce } from 'innoboxrr-js-libs/libs/utils';
    import { useGlobalStore } from '@blogStore/globalStore';
    import { categoryDashIndentation } from '@blogModels/blog-category/helpers/utils';
    import { useTranslationsStore } from '@blogStore/translationsStore';
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
    import { Bars3CenterLeftIcon, XMarkIcon } from '@heroicons/vue/24/outline'
    import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
    import DesktopAuthorDropdown from '@blogComponents/DesktopAuthorDropdown.vue';
    import MobileAuthorDropdown from '@blogComponents/MobileAuthorDropdown.vue';

    export default {
        name: 'BlogDashboardView',
        components: {
            TransitionRoot,
            Dialog,
            DialogPanel,
            TransitionChild,
            Bars3CenterLeftIcon,
            XMarkIcon,
            MagnifyingGlassIcon,
            DesktopAuthorDropdown,
            MobileAuthorDropdown,
        },
        props: {
            blog: {
                type: Object,
                required: true, // Asegúrate de pasar el blog desde el componente padre
            },
            lang: {
                type: String,
                default: 'en',
            },
        },
        setup(props) {
            // 1. Importar stores
            const globalStore = useGlobalStore();
            const translationsStore = useTranslationsStore();

            // 2. Acceder a propiedades globales
            const instance = getCurrentInstance();
            const $blogLoadLocale = instance?.appContext.config.globalProperties.$blogLoadLocale;

            // 3. Referenciar datos reactivos del store global
            const { navigation, title, categories } = toRefs(globalStore);

            // 4. Establecer el blog inicial
            const initializeBlog = () => {
                globalStore.initBlog(props.blog);
            };

            // 5. Cargar el idioma inicial
            const initializeLocale = () => {
                if (translationsStore.currentLang !== props.lang) {
                    $blogLoadLocale(props.lang);
                }
            };

            // 6. Configurar watchers reactivos
            const setupWatchers = () => {
                // Vigilar cambios en el blog
                watch(
                    () => props.blog,
                    (newBlog) => {
                        globalStore.initBlog(newBlog);
                    },
                    { immediate: true }
                );

                // Vigilar cambios en el idioma (lang)
                watch(
                    () => props.lang,
                    (newLang) => {
                        $blogLoadLocale(newLang);
                    },
                    { immediate: true }
                );
            };

            // Mecanismo de filtrado
            const postFilters = {
                category_id: null,
                search: '',
            };

            const updateFilters = debounce(() => {
                globalStore.setPostFilters(postFilters);
            }, 300);

            // 7. Inicializar lógica
            initializeBlog();
            initializeLocale();
            setupWatchers();

            // 8. Retornar propiedades reactivas
            return {
                navigation,
                title,
                categories,
                postFilters,
                updateFilters,
            };
        },
        data() {
            return {
                sidebarOpen: false,
            }
        },
        methods: {
            categoryDashIndentation,
        },
    };
</script>