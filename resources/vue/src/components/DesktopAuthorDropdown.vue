<template>
    <Menu as="div" class="relative inline-block px-3 text-left">
        <div>
            <MenuButton 
                class="group w-full rounded-md bg-gray-100 px-3.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                <span class="flex w-full items-center justify-between">
                    <span class="flex min-w-0 items-center justify-between space-x-3">
                        <img 
                            class="size-10 shrink-0 rounded-full bg-gray-300" 
                            src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" 
                            alt="" />
                        <span class="flex min-w-0 flex-1 flex-col">
                            <span class="truncate text-sm font-medium text-gray-900">
                                Jessy Schwarz
                            </span>
                            <span class="truncate text-sm text-gray-500">
                                @jessyschwarz
                            </span>
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
</template>

<script>
    import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
    import { ChevronUpDownIcon } from '@heroicons/vue/20/solid';

    export default {
        components: {
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            ChevronUpDownIcon,
        },
    };
</script>
