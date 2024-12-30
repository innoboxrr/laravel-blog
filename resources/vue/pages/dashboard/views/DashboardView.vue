<template>
    <div>
        <p>{{ message }}</p>
        <p>Count: {{ count }}</p>
        <button @click="increment">Increment</button>
        <button @click="updateMessage('New Message from Pinia!')">Update Message</button>
        <pre>{{ blog }}</pre>
    </div>
</template>

<script>
import { toRefs } from 'vue';
import { useDashboardStore } from '../store/dashboardStore'; // Ruta correcta a tu tienda local
import { useGlobalStore } from '@blogStore/globalStore'; // Alias para la tienda global

export default {
    name: 'DashboardView',
    setup() {
        // Acceso a las tiendas
        const dashboardStore = useDashboardStore();
        const globalStore = useGlobalStore();

        // Convierte las propiedades de la tienda a referencias reactivas
        const { message, count } = toRefs(dashboardStore);
        const { blog } = toRefs(globalStore);

        // Retorna las referencias y acciones
        return {
            message,
            count,
            increment: dashboardStore.increment,
            updateMessage: dashboardStore.updateMessage,
            blog,
        };
    },
};
</script>
