<template>
    <AuthenticatedLayout>
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gradient-to-r from-gray-500 to-blue-500 backdrop-blur-lg shadow-md rounded-lg px-8 py-10 w-[600px] ">
                <div class="container mx-auto p-4">
                    <h1 class="text-slate-700 text-center mb-3 [text-shadow:_0_1px_0_rgb(0_0_0_/_40%)]">Import Employees</h1>
                    <form @submit.prevent="uploadEmployees" enctype="multipart/form-data">
                        <div>
                            <select v-model="selectedDepartment" class="border p-2 rounded-md" required>
                                <option v-for="department in departments" :key="department.id" :value="department.id">
                                    {{ department.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="file" class="block mb-2">Select Excel File:</label>
                            <input type="file" @change="handleFileUpload" class="border p-2 rounded-md"  accept=".xlsx,.xls,.csv" required />
                        </div>
                        
                        <div class="mt-6 flex items-center justify-center">
                            <SecondaryButton @click="back">
                                Cancelar
                            </SecondaryButton>
                            <PrimaryButton class="ml-2">
                                Upload
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
 import { ref, onMounted } from 'vue';
 import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
 import { usePage, router } from '@inertiajs/vue3';
  import { Inertia } from '@inertiajs/inertia';

  import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
  
    const departments = ref([]);
    const { props } = usePage();

    onMounted(() => {
        departments.value = props.departments;
    });

    console.log('depart', departments)
  
    const selectedDepartment = ref('');
    const file = ref(null);
  
    const handleFileUpload = (event) => {
        file.value = event.target.files[0];
    };
  
    const uploadEmployees = () => {
        const formData = new FormData();
        formData.append('file', file.value);
        formData.append('department_id', selectedDepartment.value);
    
        Inertia.post('/employees-import', formData, {
        onSuccess: () => {
            alert('Employees uploaded successfully!');
        },
        onError: (errors) => {
            console.error(errors);
        },
        });
    };

    const back = () => {
        router.visit(route('employees.index'));
    }
  </script>
  