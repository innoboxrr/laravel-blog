<template>
    <Menu as="div" class="relative ml-3">
        <div>
            <MenuButton class="relative flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">
                    {{ __blog('Open user menu') }}
                </span>
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
</template>

<script>
    import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';

    export default {
        components: {
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
        },
    };
</script>
