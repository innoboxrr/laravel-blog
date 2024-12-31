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
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="size-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <div class="mt-16 h-0 flex-1 overflow-y-auto">
                                <nav class="px-2">
                                    <div class="space-y-1">
                                        <a 
                                            v-for="item in navigation" 
                                            :key="item.name" 
                                            :href="item.href" 
                                            :class="[item.current ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center rounded-md px-2 py-2 text-base/5 font-medium']" 
                                            :aria-current="item.current ? 'page' : undefined">
                                            <component 
                                                :is="item.icon" 
                                                :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 size-6 shrink-0']" 
                                                aria-hidden="true" />
                                            {{ item.name }}
                                        </a>
                                    </div>
                                    <div class="mt-8">
                                        <h3 class="px-3 text-sm font-medium text-gray-500" id="mobile-teams-headline">
                                            Categorías
                                        </h3>
                                        <div 
                                            class="mt-1 space-y-1" 
                                            role="group" 
                                            aria-labelledby="mobile-teams-headline">
                                            <a 
                                                v-for="team in teams" 
                                                :key="team.name" 
                                                :href="team.href" 
                                                class="group flex items-center rounded-md px-3 py-2 text-base/5 font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                                <span :class="[team.bgColorClass, 'mr-4 size-2.5 rounded-full']" aria-hidden="true" />
                                                <span class="truncate">{{ team.name }}</span>
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
                <Menu as="div" class="relative inline-block px-3 text-left">
                    <div>
                        <MenuButton 
                            class="group w-full rounded-md bg-gray-100 px-3.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                            <span class="flex w-full items-center justify-between">
                                <span class="flex min-w-0 items-center justify-between space-x-3">
                                    <img class="size-10 shrink-0 rounded-full bg-gray-300" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" alt="" />
                                    <span class="flex min-w-0 flex-1 flex-col">
                                        <span class="truncate text-sm font-medium text-gray-900">Jessy Schwarz</span>
                                        <span class="truncate text-sm text-gray-500">@jessyschwarz</span>
                                    </span>
                                </span>
                                <ChevronUpDownIcon class="size-5 shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                            </span>
                        </MenuButton>
                    </div>
                    <transition 
                        enter-active-class="transition ease-out duration-100" 
                        enter-from-class="transform opacity-0 scale-95" 
                        enter-to-class="transform opacity-100 scale-100" 
                        leave-active-class="transition ease-in duration-75" 
                        leave-from-class="transform opacity-100 scale-100" 
                        leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="absolute left-0 right-0 z-10 mx-3 mt-1 origin-top divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                            <div class="py-1">
                                <MenuItem v-slot="{ active }">
                                    <a 
                                        href="#" 
                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        View profile
                                    </a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a 
                                        href="#" 
                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Settings
                                    </a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a 
                                        href="#" 
                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Notifications
                                    </a>
                                </MenuItem>
                            </div>
                            <div class="py-1">
                                <MenuItem v-slot="{ active }">
                                    <a 
                                        href="#" 
                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Get desktop app
                                    </a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a 
                                        href="#" 
                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Support
                                    </a>
                                </MenuItem>
                            </div>
                            <div class="py-1">
                                <MenuItem v-slot="{ active }">
                                    <a 
                                        href="#" 
                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Logout
                                    </a>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
                <!-- Sidebar Search -->
                <div class="mt-6 grid grid-cols-1 px-3">
                    <input 
                        type="search" 
                        name="search" 
                        aria-label="Search" 
                        class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pl-10 pr-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" 
                        placeholder="Search" />
                    <MagnifyingGlassIcon 
                        class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400" 
                        aria-hidden="true" />
                </div>
                <!-- Navigation -->
                <nav class="mt-6 px-3">
                    <div class="space-y-1">
                        <a 
                            v-for="item in navigation" 
                            :key="item.name" 
                            :href="item.href" 
                            :class="[item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center rounded-md px-2 py-2 text-sm font-medium']" 
                            :aria-current="item.current ? 'page' : undefined">
                            <component 
                                :is="item.icon" 
                                :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 size-6 shrink-0']" 
                                aria-hidden="true" />
                            {{ item.name }}
                        </a>
                    </div>
                    <div class="mt-8">
                        <!-- Secondary navigation -->
                        <h3 class="px-3 text-sm font-medium text-gray-500" id="desktop-teams-headline">
                            Teams
                        </h3>
                        <div class="mt-1 space-y-1" role="group" aria-labelledby="desktop-teams-headline">
                            <a 
                                v-for="team in teams" 
                                :key="team.name" 
                                :href="team.href" 
                                class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                                <span :class="[team.bgColorClass, 'mr-4 size-2.5 rounded-full']" aria-hidden="true"></span>
                                <span class="truncate">{{ team.name }}</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main column -->
        <div class="flex flex-col lg:pl-64">
            <!-- Search header -->
            <div class="sticky top-0 z-10 flex h-16 shrink-0 border-b border-gray-200 bg-white lg:hidden">
                <button 
                    type="button" 
                    class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden" 
                    @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3CenterLeftIcon class="size-6" aria-hidden="true" />
                </button>
                <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
                    <form class="grid w-full flex-1 grid-cols-1" action="#" method="GET">
                        <input 
                            type="search" 
                            name="search" 
                            aria-label="Search" 
                            style="outline: none; box-shadow: none;" 
                            class="col-start-1 row-start-1 block size-full border-0 rounded-md bg-white py-2 pl-8 pr-3 text-base text-gray-900 placeholder:text-gray-400 sm:text-sm/6"
                            placeholder="Search" />
                        <MagnifyingGlassIcon 
                            class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400" 
                            aria-hidden="true" />
                    </form>
                    <div class="flex items-center">
                        <!-- Profile dropdown -->
                        <Menu as="div" class="relative ml-3">
                            <div>
                                <MenuButton class="relative flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img 
                                        class="size-8 rounded-full" 
                                        src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" 
                                        alt="" />
                                </MenuButton>
                            </div>
                            <transition 
                                enter-active-class="transition ease-out duration-100" 
                                enter-from-class="transform opacity-0 scale-95" 
                                enter-to-class="transform opacity-100 scale-100" 
                                leave-active-class="transition ease-in duration-75" 
                                leave-from-class="transform opacity-100 scale-100" 
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                View profile
                                            </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                Settings
                                            </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                Notifications
                                            </a>
                                        </MenuItem>
                                    </div>
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                Get desktop app
                                            </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                Support
                                            </a>
                                        </MenuItem>
                                    </div>
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                Logout
                                            </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
            <main class="flex-1">

                <!-- Page title & actions -->
                <div class="border-b border-gray-200 px-4 py-2 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-lg/6 font-medium text-gray-900 sm:truncate">
                            Home
                        </h1>
                    </div>
                    <div class="mt-4 flex sm:ml-4 sm:mt-0">
                        <button 
                            type="button" 
                            class="order-1 ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:order-[0] sm:ml-0">
                            Share
                        </button>
                        <button 
                            type="button" 
                            class="order-[0] inline-flex items-center rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600 sm:order-1 sm:ml-3">
                            Create
                        </button>
                    </div>
                </div>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>


<script>
    import { watch, toRefs } from 'vue';
    import { useGlobalStore } from '@blogStore/globalStore'; // Alias para la tienda global
    import { Dialog, DialogPanel, Menu, MenuButton, MenuItem, MenuItems, TransitionChild, TransitionRoot } from '@headlessui/vue'
    import { Bars3CenterLeftIcon, XMarkIcon } from '@heroicons/vue/24/outline'
    import { ChevronUpDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'

    export default {
        name: 'BlogDashboardView',
        props: {
            blog: {
                type: Object,
                required: true, // Asegúrate de pasar el blog desde el componente padre
            },
        },
        setup(props) {
            const globalStore = useGlobalStore();
            const { navigation } = toRefs(globalStore);
            globalStore.setBlog(props.blog);

            watch(() => props.blog, (newBlog) => {
                    globalStore.setBlog(newBlog);
                },
                { immediate: true }
            );

            return {
                navigation
            };
        },
        components: {
            TransitionRoot,
            Dialog,
            DialogPanel,
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            TransitionChild,
            Bars3CenterLeftIcon,
            XMarkIcon,
            ChevronUpDownIcon,
            MagnifyingGlassIcon,
        },
        data() {
            return {
                sidebarOpen: false,

                projects: [
                    {
                    id: 1,
                    title: 'GraphQL API 123456789',
                    initials: 'GA',
                    team: 'Engineering',
                    members: [
                        {
                        name: 'Dries Vincent',
                        handle: 'driesvincent',
                        imageUrl:
                            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        },
                        {
                        name: 'Lindsay Walton',
                        handle: 'lindsaywalton',
                        imageUrl:
                            'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        },
                        {
                        name: 'Courtney Henry',
                        handle: 'courtneyhenry',
                        imageUrl:
                            'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        },
                        {
                        name: 'Tom Cook',
                        handle: 'tomcook',
                        imageUrl:
                            'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        },
                    ],
                    totalMembers: 12,
                    lastUpdated: 'March 17, 2020',
                    pinned: true,
                    bgColorClass: 'bg-pink-600',
                    },
                    // More projects...
                ],
                teams: [
                    { name: 'Engineering', href: '#', bgColorClass: 'bg-indigo-500' },
                    { name: 'Human Resources', href: '#', bgColorClass: 'bg-green-500' },
                    { name: 'Customer Success', href: '#', bgColorClass: 'bg-yellow-500' },
                ]
            }
        },
        computed: {
            pinnedProjects() {
                return this.projects.filter((project) => project.pinned);
            },
        }
    };
</script>

<style scoped>
/* Personaliza los estilos adicionales aquí */
</style>
