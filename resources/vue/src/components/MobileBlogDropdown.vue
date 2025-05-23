<template>
    <Menu as="div" class="relative ml-3">
        <div>
            <MenuButton
                class="relative flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            >
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">Seleccionar blog</span>
                <img
                    class="size-8 rounded-full object-cover"
                    :src="blog.payload?.author?.avatar ? `/storage/${blog.payload.author.avatar}` : fallbackAvatar"
                    alt="avatar"
                />
            </MenuButton>
        </div>
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <MenuItems
                class="absolute right-0 z-10 mt-2 w-64 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
            >
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
                                'w-full flex items-center gap-2 px-4 py-2 text-sm truncate',
                            ]"
                        >
                            <img
                                class="size-6 rounded-full object-cover"
                                :src="b.payload?.author?.avatar ? `/storage/${b.payload.author.avatar}` : fallbackAvatar"
                                alt="avatar"
                            />
                            <div class="text-left">
                                <div class="truncate font-medium">
                                    {{ b.name }}
                                </div>
                                <div class="truncate text-xs text-gray-500">
                                    {{ b.payload?.author?.email || b.domain }}
                                </div>
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

export default {
    name: 'MobileBlogDropdown',
    components: {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
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
