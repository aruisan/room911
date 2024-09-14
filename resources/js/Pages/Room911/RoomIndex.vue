<template>
  <Head title="Employee List" />

  <AuthenticatedLayout>
        <div class="py-12">
            <div class="container mx-auto p-4">
                <h1>Welcome the Room 911
                    {{ employee.first_name }} {{ employee.last_name }}</h1>
            </div>
        </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/vue3';
    const props = defineProps({
        employee: {
            type: Object,
            required: true,
        },
    });

</script>