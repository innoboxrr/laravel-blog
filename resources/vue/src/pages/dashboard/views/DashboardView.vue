<template>
    <div class="min-h-full">
        <div class="mt-6 px-4 sm:px-6 lg:px-8">
            <h2 class="text-sm font-medium text-gray-900">
                {{ __blog('Pinned Categories') }}
            </h2>
            <ul 
                role="list" 
                class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
                <li 
                    v-for="category in pinnedCategories" 
                    :key="category.id" 
                    class="relative col-span-1 flex rounded-md shadow-sm">
                    <div 
                        :class="[
                            'bg-' + ['red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink'][category.id % 7] + '-600',
                            'flex w-16 shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white'
                        ]">
                        <span class="text-lg">{{ category.name.charAt(0) }}</span>
                    </div>
                    <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                        <div class="flex-1 truncate px-4 py-2 text-sm">
                            <a href="#" class="font-medium text-gray-900 hover:text-gray-600">
                                {{ category.name }}
                            </a>
                            <p v-if="category.posts_count > 0" class="text-gray-500">
                                {{ category.posts_count }} 
                                <span v-if="category.posts_count > 1">{{ __blog('posts') }}</span>
                                <span v-else>{{ __blog('post') }}</span>
                            </p>
                            <p v-else class="text-gray-500">
                                {{ __blog('No posts') }}
                            </p>
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
                                                {{ __blog('Filter') }}
                                            </a>
                                        </MenuItem>
                                    </div>
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                @click="unpinCategory(category)"
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                {{ __blog('Remove from pinned') }}
                                            </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a 
                                                @click="categoryBeingEdited = category"
                                                :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                {{ __blog('Edit') }}
                                            </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </li>
            </ul>
            <edit-category-modal 
                v-if="categoryBeingEdited"
                :key="'edit-category-modal-' + categoryBeingEdited?.id"
                :categories="categories"
                :category-being-edited="categoryBeingEdited"
                @cancelEdit="categoryBeingEdited = null"
                @saveCategoryEdit="categoryEdited" />
        </div>

        <!-- Projects list (only on smallest breakpoint) -->
        <div class="mt-10 sm:hidden">
            <div class="px-4 sm:px-6">
                <h2 class="text-sm font-medium text-gray-900">Posts</h2>
            </div>
            <ul role="list" class="mt-3 divide-y divide-gray-100 border-t border-gray-200">
                <li 
                    v-for="post in posts" 
                    :key="post.id">
                    <a href="#" class="group flex items-center justify-between px-4 py-4 hover:bg-gray-50 sm:px-6">
                        <span class="flex items-center space-x-3 truncate">
                            <span :class="[post.bgColorClass, 'size-2.5 shrink-0 rounded-full']" aria-hidden="true"></span>
                        </span>
                        {{ post.title }}
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
                                    {{ __blog('Blog posts') }}
                                </span>
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell" scope="col">
                                {{ __blog('Last updated') }}
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr 
                            v-for="post in posts" 
                            :key="post.id">
                            <td class="w-full max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <div class="flex items-center space-x-3 lg:pl-2">
                                    <div :class="[post.bgColorClass, 'size-2.5 shrink-0 rounded-full']" aria-hidden="true"></div>
                                    <a href="#" class="truncate hover:text-gray-600">
                                        <span>
                                            {{ post.title }}
                                            {{ ' ' }}
                                            <span class="font-normal text-gray-500">in {{ post.team }}</span>
                                        </span>
                                    </a>
                                </div>
                            </td>
                            <td class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ post.created_at }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium relative">
                                <Menu as="div" class="shrink-0 pr-2">
                                    <MenuButton class="inline-flex size-8 items-center justify-center rounded-full bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                        <span class="sr-only">Open options</span>
                                        <EllipsisVerticalIcon class="size-5" aria-hidden="true" />
                                    </MenuButton>
                                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems class="absolute right-10 top-3 z-10 mx-3 mt-1 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                                            <div class="py-1">
                                                <MenuItem v-slot="{ active }">
                                                    <router-link 
                                                        :to="{
                                                            name: 'BlogPostsEditor',
                                                            params: { id: post.id }
                                                        }"
                                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __blog('Edit') }}
                                                    </router-link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                    <router-link
                                                        :to="{
                                                            name: 'BlogPostsShow',
                                                            params: { id: post.id }
                                                        }"
                                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __blog('Admin view') }}
                                                    </router-link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                    <a 
                                                        href="#" 
                                                        target="_blank"
                                                        :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __blog('Site siew') }}
                                                    </a>
                                                </MenuItem>
                                            </div>
                                            <div class="py-1">
                                                <MenuItem v-slot="{ active }">
                                                    <a 
                                                        href="#" 
                                                        :class="[active ? 'bg-red-100 text-red-900 outline-none' : 'text-red-700', 'block px-4 py-2 text-sm']">
                                                        {{ __blog('Delete') }}
                                                    </a>
                                                </MenuItem>
                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>


<script>
    import { watch, toRefs } from 'vue';
    import { useGlobalStore } from '@blogStore/globalStore'; 
    import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
    import { ChevronRightIcon, EllipsisVerticalIcon } from '@heroicons/vue/20/solid'
    import { unpinCategory } from '@blogModels/blog-category/helpers/utils';
    import EditCategoryModal from '@blogModels/blog-category/components/category-selector/EditCategoryModal.vue';

    export default {
        name: 'BlogDashboardView',
        setup() {
            const globalStore = useGlobalStore();
            const { blog, categories, posts, postFilters  } = toRefs(globalStore);
            const fetchCategories = globalStore.fetchCategories;

            watch(postFilters, async () => {
                await globalStore.fetchPosts();
            });

            return {
                fetchCategories,
                blog,
                categories,
                posts,
                postFilters,
            };
        },
        components: {
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            ChevronRightIcon,
            EllipsisVerticalIcon,
            EditCategoryModal,
        },
        data() {
            return {
                categoryBeingEdited: null,
            }
        },
        mounted() {
            this.$setTitle(this.__blog('Dashboard'));
        },
        computed: {
            pinnedCategories() {
                return this.categories.filter((category) => category.pinned === 1 || category.pinned === true);
            },
        },
        methods: {
            unpinCategory,
            categoryEdited(category) {
                this.categoryBeingEdited = null;
                this.fetchCategories();
            },
        }
    };
</script>

<style scoped>
/* Personaliza los estilos adicionales aquí */
</style>
