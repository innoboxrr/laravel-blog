<template>
    <div class="min-h-full">

        <!-- Pinned projects -->
        <div class="mt-6 px-4 sm:px-6 lg:px-8">
            <h2 class="text-sm font-medium text-gray-900">
                Pinned Projectsfff
            </h2>
            <ul role="list" class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
                <li 
                    v-for="project in pinnedProjects" 
                    :key="project.id" 
                    class="relative col-span-1 flex rounded-md shadow-sm">
                    <div :class="[project.bgColorClass, 'flex w-16 shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white']">
                        {{ project.initials }}
                    </div>
                    <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                        <div class="flex-1 truncate px-4 py-2 text-sm">
                            <a href="#" class="font-medium text-gray-900 hover:text-gray-600">{{ project.title }}</a>
                            <p class="text-gray-500">{{ project.totalMembers }} Members</p>
                        </div>
                        <Menu as="div" class="shrink-0 pr-2">
                            <MenuButton class="inline-flex size-8 items-center justify-center rounded-full bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                <span class="sr-only">Open options</span>
                                <EllipsisVerticalIcon class="size-5" aria-hidden="true" />
                            </MenuButton>
                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="absolute right-10 top-3 z-10 mx-3 mt-1 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                View
                                            </a>
                                        </MenuItem>
                                    </div>
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                Removed from pinned
                                            </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                href="#" 
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                Share
                                            </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Projects list (only on smallest breakpoint) -->
        <div class="mt-10 sm:hidden">
            <div class="px-4 sm:px-6">
                <h2 class="text-sm font-medium text-gray-900">Projects</h2>
            </div>
            <ul role="list" class="mt-3 divide-y divide-gray-100 border-t border-gray-200">
                <li 
                    v-for="project in projects" 
                    :key="project.id">
                    <a href="#" class="group flex items-center justify-between px-4 py-4 hover:bg-gray-50 sm:px-6">
                        <span class="flex items-center space-x-3 truncate">
                            <span :class="[project.bgColorClass, 'size-2.5 shrink-0 rounded-full']" aria-hidden="true"></span>
                            <span class="truncate text-sm/6 font-medium">
                                {{ project.title }}
                                {{ ' ' }}
                                <span class="truncate font-normal text-gray-500">in {{ project.team }}</span>
                            </span>
                        </span>
                        <ChevronRightIcon class="ml-4 size-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                    </a>
                </li>
            </ul>
        </div>

        <!-- Projects table (small breakpoint and up) -->
        <div class="mt-8 hidden sm:block">
            <div class="inline-block min-w-full border-b border-gray-200 align-middle">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-t border-gray-200">
                            <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900" scope="col">
                                <span class="lg:pl-2">
                                    Project
                                </span>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900" scope="col">
                                Members
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell" scope="col">
                                Last updated
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr 
                            v-for="project in projects" 
                            :key="project.id">
                            <td class="w-full max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <div class="flex items-center space-x-3 lg:pl-2">
                                    <div :class="[project.bgColorClass, 'size-2.5 shrink-0 rounded-full']" aria-hidden="true"></div>
                                    <a href="#" class="truncate hover:text-gray-600">
                                        <span>
                                            {{ project.title }}
                                            {{ ' ' }}
                                            <span class="font-normal text-gray-500">in {{ project.team }}</span>
                                        </span>
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <div class="flex shrink-0 -space-x-1">
                                        <img 
                                            v-for="member in project.members" 
                                            :key="member.handle" 
                                            class="size-6 max-w-none rounded-full ring-2 ring-white" 
                                            :src="member.imageUrl" 
                                            :alt="member.name" />
                                    </div>
                                    <span 
                                        v-if="project.totalMembers > project.members.length" 
                                        class="shrink-0 text-xs/5 font-medium">
                                        +{{ project.totalMembers - project.members.length }}
                                    </span>
                                </div>
                            </td>
                            <td class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ project.lastUpdated }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</template>


<script>
    import { toRefs } from 'vue';
    import { useGlobalStore } from '@blogStore/globalStore'; 
    import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
    import { ChevronRightIcon, EllipsisVerticalIcon } from '@heroicons/vue/20/solid'

    export default {
        name: 'BlogDashboardView',
        setup() {
            const globalStore = useGlobalStore();
            const { blog } = toRefs(globalStore);
            return {
                blog,
            };
        },
        components: {
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            ChevronRightIcon,
            EllipsisVerticalIcon,
        },
        data() {
            return {
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
