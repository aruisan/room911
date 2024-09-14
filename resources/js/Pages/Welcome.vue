<script setup>
import { ref} from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        default: '10.1',
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const openModalAccessRoom = ref(false);
const internal_id = ref('');

const goLogin = () => {
    router.visit(route('login'))
}

const submitForm = () => {
    Inertia.post(`/access-log`, {'internal_id':internal_id.value});
};

</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen  bg-gradient-to-r from-gray-500 to-blue-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('employees.index')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Employees List</Link
            >

            <template v-else>
                <PrimaryButton @click="goLogin">
                    Employees
                </PrimaryButton>
                <PrimaryButton class="ml-2" @click="openModalAccessRoom = true">
                    Room 911
                </PrimaryButton>
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
           
        </div>

        <Modal :show="openModalAccessRoom" @close="openModalAccessRoom = false" maxWidth="sm">
            <div class="bg-white p-8 shadow-lg rounded-md">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.656 0 3-1.343 3-3S13.656 5 12 5 9 6.343 9 8s1.344 3 3 3zm0 2c-3.314 0-6 1.343-6 3v2h12v-2c0-1.657-2.686-3-6-3z"></path>
                    </svg>
                </div>
               <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <input v-model="internal_id"  type="text" placeholder="ID" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex justify-center">
                        <button class="px-6 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none">
                            Access
                        </button>
                    </div>
               </form>
            </div>
        </Modal>

    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
