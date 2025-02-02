<template>
    <Menu as="div" class="relative inline-block text-left">
        <div>
            <MenuButton class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ __blog('Actions') }}
                <svg
                    class="ml-2 -mr-1 h-5 w-5 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </MenuButton>
        </div>
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                <div class="py-1">
                    <MenuItem v-slot="{ active }" v-for="(item, index) in actions" :key="index">
                        <button
                            @click="selectAction(item.value)"
                            :class="getButtonClasses(active, item.value)" >
                            {{ item.label }}
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
    name: 'CreateActionsDropdown',
    components: {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
    },
    emits: ['actionSelected'],
    data() {
        return {
            action: 'normalPost', // Acción seleccionada por defecto
            actions: [
                { value: 'normalPost', label: this.__blog('Normal Post Creation') },
                { value: 'generateWithAI', label: this.__blog('Generate with AI') },
                { value: 'transcriptWithAI', label: this.__blog('Transcript with AI') },
                { value: 'videoToTextAI', label: this.__blog('Video to Text With AI') },
                { value: 'translateWithAI', label: this.__blog('Translate with AI') },
            ],
        };
    },
    methods: {
        selectAction(action) {
            this.action = action; // Actualizar acción seleccionada
            this.$emit('actionSelected', action); // Emitir evento
        },
        getButtonClasses(active, value) {
            const isSelected = this.action === value;
            return [
                active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                isSelected ? 'font-semibold bg-indigo-100 text-indigo-700' : '',
                'block w-full px-4 py-2 text-sm text-left',
            ].join(' ');
        },
    },
};
</script>
