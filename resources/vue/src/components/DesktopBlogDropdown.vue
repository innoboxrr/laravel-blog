<template>
    <Menu as="div" class="relative inline-block px-3 text-left">
        <div>
            <MenuButton 
                class="group w-full rounded-md bg-gray-100 px-3.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                <span class="flex w-full items-center justify-between">
                    <span class="flex min-w-0 items-center justify-between space-x-3">
                        <img 
                            class="size-10 shrink-0 rounded-full bg-gray-300 object-cover" 
                            :src="blog.payload?.author?.avatar ? `/storage/${blog.payload.author.avatar}` : fallbackAvatar"
                            alt="avatar" />
                        <span class="flex min-w-0 flex-1 flex-col">
                            <span class="truncate text-sm font-medium text-gray-900">
                                {{ blog.name }}
                            </span>
                            <span class="truncate text-sm text-gray-500">
                                {{ blog.payload?.author?.email || blog.domain }}
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

                <!-- Lista de blogs -->
                <div class="py-1">
                    <MenuItem
                        v-for="b in blogs"
                        :key="b.id"
                        v-slot="{ active }"
                    >
                        <button
                            @click="$emit('setBlog', b)"
                            type="button"
                            :class="[
                                active || b.id === blog.id
                                    ? 'bg-gray-100 text-gray-900 outline-none'
                                    : 'text-gray-700',
                                'w-full px-4 py-2 text-sm flex items-center gap-2',
                            ]"
                        >
                            <img 
                                class="size-6 rounded-full object-cover"
                                :src="b.payload?.author?.avatar ? `/storage/${b.payload.author.avatar}` : fallbackAvatar"
                                alt="avatar" />
                            <div class="text-left">
                                <div class="truncate font-medium">{{ b.name }}</div>
                                <div class="truncate text-xs text-gray-500">{{ b.payload?.author?.email || b.domain }}</div>
                            </div>
                        </button>
                    </MenuItem>
                </div>

                <!-- Botón para crear nuevo blog -->
                <div class="py-1">
                    <MenuItem v-slot="{ active }">
                        <button
                            @click="$emit('createBlog')"
                            type="button"
                            :class="[
                                active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700',
                                'block w-full px-4 py-2 text-sm text-left',
                            ]"
                        >
                            <i class="fa-solid fa-plus"></i>
                            Crear nuevo blog
                        </button>
                    </MenuItem>
                </div>

                <!-- Botón para eliminar blog actual -->
                <div class="py-1">
                    <MenuItem v-slot="{ active }">
                        <button
                            @click="$emit('deleteBlog', blog)"
                            type="button"
                            :class="[
                                active ? 'bg-red-100 text-red-800 outline-none' : 'text-red-600',
                                'block w-full px-4 py-2 text-sm text-left font-semibold',
                            ]"
                        >
                            <i class="fa-solid fa-trash-can"></i>
                            Eliminar blog
                        </button>
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
    name: 'BlogDropdown',
    components: {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        ChevronUpDownIcon,
    },
    props: {
        blog: {
            type: Object,
            required: true,
        },
        blogs: {
            type: Array,
            required: true,
        },
    },
    emits: ['setBlog', 'createBlog', 'deleteBlog'],
    data() {
        return {
            fallbackAvatar: 'https://ui-avatars.com/api/?name=Blog&background=random',
        };
    },
};
</script>
