<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
        <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-r from-blue-500 to-gray-500 h-screen">
            <div class="bg-white/10 backdrop-blur-lg shadow-md rounded-lg px-8 py-10 w-[400px]">
                    <div class="flex justify-center mb-6">
                        <div class="h-16 w-16 rounded-full bg-blue-600 flex items-center justify-center">
                            <!-- Icono del usuario -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-3.9 0-7-3.1-7-7S8.1 0 12 0s7 3.1 7 7-3.1 7-7 7zm-7 4c0 2.2 1.8 4 4 4h6c2.2 0 4-1.8 4-4v-1c0-2.2-1.8-4-4-4H9c-2.2 0-4 1.8-4 4v1z" />
                            </svg>
                        </div>
                    </div>
                    <slot />
            </div>
        </div>
</template>
