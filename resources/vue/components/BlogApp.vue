<template>
    <router-view />
</template>

<script>
import { watch } from 'vue';
import { useGlobalStore } from '../store/globalStore'; // Ajusta la ruta según tu estructura

export default {
    name: 'BlogApp',
    props: {
        blog: {
            type: Object,
            required: true, // Asegúrate de pasar el blog desde el componente padre
        },
    },
    setup(props) {
        const globalStore = useGlobalStore();

        // Actualiza la tienda global con el blog inicial
        globalStore.setBlog(props.blog);

        // Observa cambios en el prop `blog` y actualiza la tienda global si cambia
        watch(
            () => props.blog,
            (newBlog) => {
                globalStore.setBlog(newBlog);
            },
            { immediate: true } // Ejecuta inmediatamente al montar
        );

        return {};
    },
};
</script>
