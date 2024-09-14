<template>
    <Head title="Employee create" />
    <AuthenticatedLayout>
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gradient-to-r from-gray-500 to-blue-500 backdrop-blur-lg shadow-md rounded-lg px-8 py-10 w-[400px] ">
                <div class="container mx-auto p-4">
                    <h1 class="text-slate-700 text-center mb-3 [text-shadow:_0_1px_0_rgb(0_0_0_/_40%)]">{{ isEdit ? 'Edit Employee' : 'Create Employee' }}</h1>
                    <form @submit.prevent="submitForm">
                        <div>
                            <TextInput
                                type="text"
                                placeholder="First Name"
                                class="mt-1 block w-full px-4 py-3 rounded-md bg-white/20 text-white focus:ring-2 focus:ring-blue-400"
                                v-model="employee.first_name"
                                required
                                autofocus
                            />
                        </div>
                        <div>
                            <TextInput
                                type="text"
                                placeholder="Last Name"
                                class="mt-1 block w-full px-4 py-3 rounded-md bg-white/20 text-white focus:ring-2 focus:ring-blue-400"
                                v-model="employee.last_name"
                                required
                                autofocus
                            />
                        </div>

                        <div>
                            <TextInput
                                type="text"
                                placeholder="Internal ID"
                                class="mt-1 block w-full px-4 py-3 rounded-md bg-white/20 text-white focus:ring-2 focus:ring-blue-400"
                                v-model="employee.internal_id"
                                required
                                autofocus
                            />
                        </div>
                        <div>
                            <select v-model="employee.department_id" class="mt-1 block w-full px-4 py-3 rounded-md bg-white/20 focus:ring-2 focus:ring-blue-400">
                                <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                                    {{ dept.name }}
                                </option>
                            </select>
                        </div>
                        <div class="mt-6 flex items-center justify-center">
                            <SecondaryButton @click="back">
                                Cancelar
                            </SecondaryButton>
                            <PrimaryButton class="ml-2">
                                {{ isEdit ? 'Update' : 'Create' }}
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
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage, router } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const employee = ref({
  first_name: '',
  last_name: '',
  internal_id: '',
  department_id: '',
});

const departments = ref([]);
const isEdit = ref(false);
const { props } = usePage();

onMounted(() => {
  departments.value = props.departments;

  if (props.employee) {
    isEdit.value = true;
    employee.value = props.employee;
  }
});

const submitForm = () => {
  if (isEdit.value) {
    Inertia.put(`/employees/${employee.value.id}`, employee.value);
  } else {
    Inertia.post('/employees', employee.value);
  }
};

const back = () => {
    router.visit(route('employees.index'));
}
</script>
