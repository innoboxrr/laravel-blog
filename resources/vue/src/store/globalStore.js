import { indexModel as indexCategoryModel } from '@blogModels/blog-category'
import { indexModel as indexPostModel } from '@blogModels/blog-post'
import { createFlattenedCategories } from '@blogModels/blog-category/helpers/utils';
import { __blog } from '../utils/translate';
import { defineStore } from 'pinia';
import { 
    Bars4Icon, 
    ClockIcon, 
    HomeIcon, 
    TagIcon, 
    UserGroupIcon, 
    CogIcon, 
} from '@heroicons/vue/24/outline'

const navigation = [
    { name: __blog('Dashboard'), path: 'BlogAppDashboard', params: {}, query: {}, icon: HomeIcon, current: true },
    // { name: __blog('Categories'), href: '#', icon: Bars4Icon, current: false },
    // { name: __blog('Posts'), href: '#', icon: ClockIcon, current: false },
    // { name: __blog('Tags'), href: '#', icon: TagIcon, current: false },
    // { name: __blog('Subscribers'), href: '#', icon: UserGroupIcon, current: false },
    { name: __blog('Settings'), path: 'BlogAppSettings', params: {}, query: {}, icon: CogIcon, current: false },
];

export const useGlobalStore = defineStore('blog-global', {
    state: () => ({
        blog: null, // Inicialmente el blog es null
        title: 'Blog',
        navigation: navigation,
        categories: [],
        posts: [],
        tags: [],
        postFilters: {
            category_id: null,
            categories: [],
            tag_id: null,
            tags: [],
            search: '',
            order_by: 'created_at',
            order_direction: 'desc',
        },
    }),
    actions: {
        async initBlog(blogData) {
            this.blog = blogData; // Actualiza el blog
            await this.fetchCategories();
            await this.fetchPosts();
        },
        async fetchCategories() {
            this.categories = await indexCategoryModel({
                paginate: 0,
                blog_id: this.blog.id,
                only_parents: true,
                load_children: true,
                load_posts_count: true,
            });
            this.categories = createFlattenedCategories(this.categories);
        },
        setPostFilters(filters) {
            this.postFilters = { ...this.postFilters, ...filters }; // Combina los filtros
        },
        async fetchPosts() {
            this.posts = await indexPostModel({
                paginate: 0,
                blog_id: this.blog.id,
                ...this.postFilters,
            });
        },
        setActivePage(routeName) {
            this.navigation.forEach(item => {
                item.current = item.path === routeName;
            });
        }
    },
});
