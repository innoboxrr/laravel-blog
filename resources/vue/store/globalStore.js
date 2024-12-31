import { indexModel as indexCategoryModel } from '@blogModels/blog-category'
import { defineStore } from 'pinia';
import { 
    Bars4Icon, 
    ClockIcon, 
    HomeIcon, 
} from '@heroicons/vue/24/outline'

const navigation = [
    { name: 'Inicio', href: '#', icon: HomeIcon, current: true },
    { name: 'Categorías', href: '#', icon: Bars4Icon, current: false },
    { name: 'Publicaciones', href: '#', icon: ClockIcon, current: false },
    { name: 'Etiquetas', href: '#', icon: ClockIcon, current: false },
    { name: 'Suscriptores', href: '#', icon: ClockIcon, current: false },
    { name: 'Configuración', href: '#', icon: ClockIcon, current: false },
    { name: 'Salir', href: '#', icon: ClockIcon, current: false },
];

export const useGlobalStore = defineStore('blog-global', {
    state: () => ({
        blog: null, // Inicialmente el blog es null
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
