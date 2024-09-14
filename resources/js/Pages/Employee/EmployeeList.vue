<template>
  <Head title="Employee List" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="container mx-auto p-4">
        <!-- Filters -->
        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-md mb-4">
          <div class="flex space-x-2">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Search by employee ID, name or last name"
              class="border p-2 rounded-md"
            />
            <select v-model="selectedDepartment" class="border p-2 rounded-md">
              <option value="">Filter by department</option>
              <option v-for="department in departments" :key="department.id" :value="department.id">
                {{ department.name }}
              </option>
            </select>
            <button @click="filterEmployees" class="bg-blue-500 text-white px-4 py-2 rounded-md">
              Filter
            </button>
            <button @click="clearFilters" class="bg-gray-300 text-black px-4 py-2 rounded-md">
              Clear Filter
            </button>
          </div>
        </div>
        <!-- Table -->
        <table class="w-full bg-white shadow-md rounded-md">
          <thead class="bg-gray-200">
            <tr>
              <th class="p-2">Employee ID</th>
              <th class="p-2">Firstname</th>
              <th class="p-2">Lastname</th>
              <th class="p-2">Department</th>
              <th class="p-2">Total access</th>
              <th class="p-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="employee in employees.data" :key="employee.id" class="border-b">
              <td class="p-2">{{ employee.internal_id }}</td>
              <td class="p-2">{{ employee.first_name }}</td>
              <td class="p-2">{{ employee.last_name }}</td>
              <td class="p-2">{{ employee.department.name }}</td>
              <td class="p-2">{{ employee.access_logs.length }}</td>
              <td class="p-2 flex space-x-2">
                <button class="bg-blue-500 text-white px-4 py-1 rounded-md" @click="editEmployee(employee.id)">
                  Update
                </button>
                <button
                  :class="`bg-${employee.access_allowed ? 'gray' : 'gray'}-500 text-white px-4 py-1 rounded-md`"
                  @click="enableEmployee(employee.id)"
                >
                  {{ employee.access_allowed ? 'enable' : 'disable' }}
                </button>
                <button class="bg-yellow-500 text-white px-4 py-1 rounded-md" @click="historyEmployee(employee.id)">
                  History
                </button>
                <button class="bg-red-500 text-white px-4 py-1 rounded-md" @click="deleteEmployee(employee.id)">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 flex justify-between items-center">
          <div class="text-gray-500">Page {{ employees.current_page }} of {{ employees.last_page }}</div>

          <!-- Controles de Paginación -->
          <div class="flex space-x-2">
            <Link
              v-for="(link, l) in employees.links"
              v-show="link.url != null"
              :key="l"
              :href="link.url"
              @click.prevent="navigate(link.url)"
              class="bg-blue-500 text-white px-4 py-2 rounded-md"
              v-html="link.label"
            ></Link>
          </div>
          <div class="flex space-x-4">
            <!-- Contenedor para agrupar los enlaces -->
            <Link :href="route('employees.create')" class="bg-blue-500 text-white px-4 py-2 rounded-md">
              New employee
            </Link>
            <Link :href="route('employees.formImport')" class="bg-blue-500 text-white px-4 py-2 rounded-md">
              Import employees
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps(['employees', 'departments', 'filters']);

// Persistir los filtros seleccionados utilizando los valores enviados desde el backend
const searchQuery = ref(props.filters.search || '');
const selectedDepartment = ref(props.filters.department_id || '');

// Función para enviar los filtros al backend
const filterEmployees = () => {
  Inertia.get('/employees', {
    search: searchQuery.value,
    department_id: selectedDepartment.value,
  }, {
    preserveState: true,
    preserveScroll: true,
  });
};

// Función para limpiar los filtros
const clearFilters = () => {
  searchQuery.value = '';
  selectedDepartment.value = '';
  filterEmployees();
};

// Función para manejar la navegación y preservar los filtros
const navigate = (url) => {
  Inertia.visit(url, {
    method: 'get',
    data: {
      search: searchQuery.value,
      department_id: selectedDepartment.value,
    },
    preserveState: true,
    preserveScroll: true,
  });
};

const deleteEmployee = (id) => {
  if (confirm('Are you sure you want to delete this employee?')) {
    Inertia.delete(`/employees/${id}`);
  }
};

const editEmployee = (employee_id) => {
  router.visit(route('employees.edit', employee_id));
};

const enableEmployee = (employee_id) => {
  let employee = props.employees.data.find((e) => e.id == employee_id);
  employee.access_allowed = !employee.access_allowed;
  console.log(employee);
  // Inertia.put(`/employees/${employee.id}`, employee);
};

const historyEmployee = (employee_id) => {
  router.visit(route('employees.history', employee_id));
};
</script>
