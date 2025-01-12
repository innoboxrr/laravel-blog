import { indexModel as indexCategoryModel } from '@blogModels/blog-category'
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
    // { name: __blog('Settings'), href: '#', icon: CogIcon, current: false },
];

export const useGlobalStore = defineStore('blog-global', {
    state: () => ({
        blog: null, // Inicialmente el blog es null
        title: 'Blog',
        navigation: navigation,
        categories: [],
        posts: [],
        tags: [],
    }),
    actions: {
        setBlog(blogData) {
            this.blog = blogData; // Actualiza el blog
        },
        async fetchCategories() {
            this.categories = await indexCategoryModel({
                paginate: 0
            });
        }
    },
});
