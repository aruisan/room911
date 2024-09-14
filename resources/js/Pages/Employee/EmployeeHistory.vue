<template>
  <Head title="Employee History" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="container mx-auto p-4">
        <!-- Filters -->
        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-md mb-4">
          <div class="flex space-x-2">
            <input
              type="date"
              v-model="startDate"
              placeholder="Initial access date"
              class="border p-2 rounded-md"
            />
            <input
              type="date"
              v-model="endDate"
              placeholder="Final access date"
              class="border p-2 rounded-md"
            />
          </div>
          <div class="flex space-x-2">
            <button @click="filterAccessLogs" class="bg-blue-500 text-white px-4 py-2 rounded-md">
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
              <th class="p-2" colspan="2">Employee {{ employee.first_name }} {{ employee.last_name }}</th>
            </tr>
            <tr>
              <th class="p-2">Date And Time</th>
              <th class="p-2">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="access_log in access_logs.data" :key="access_log.id" class="border-b">
              <td class="p-2">{{ formattedDate(access_log.created_at) }}</td>
              <td class="p-2">{{ access_log.successful ? 'Successful' : 'Failed' }}</td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 flex justify-between items-center">
          <!-- Mostrar la página actual y total de páginas -->
          <div class="text-gray-500">
            Page {{ access_logs.current_page }} of {{ access_logs.last_page }}
          </div>

          <!-- Controles de Paginación -->
          <div class="flex space-x-2">
            <Link
              v-for="(link, l) in access_logs.links"
              v-show="link.url != null"
              :key="l"
              :href="link.url"
              class="bg-blue-500 text-white px-4 py-2 rounded-md"
              v-html="link.label"
            ></Link>
          </div>
          <div class="flex space-x-4">
            <!-- Contenedor para agrupar los enlaces -->
            <Link :href="route('employees.index')" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4">
              List employee
            </Link>

            <button
              @click="downloadPDF"
              class="bg-red-500 text-white px-4 py-2 rounded-md mb-4"
            >
              Download PDF
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { format, parseISO } from 'date-fns';
import { enUS } from 'date-fns/locale';

// Definir propiedades y datos reactivas
const props = defineProps({
  employee: {
    type: Object,
    required: true,
  },
  access_logs: {
    type: Object,
    required: true,
  },
});

// Valores por defecto para los filtros, manteniendo los filtros seleccionados
const startDate = ref(props.access_logs.start_date || '');
const endDate = ref(props.access_logs.end_date || '');

// Función para formatear la fecha
const formattedDate = (date) => format(parseISO(date), 'PPPpp', { locale: enUS });

// Función para filtrar registros de acceso por fecha
const filterAccessLogs = () => {
  if (!startDate.value || !endDate.value) {
    alert('Please select both start and end dates.');
    return;
  }

  router.visit(route('employees.history', { employee: props.employee.id, start_date: startDate.value, end_date: endDate.value }), {
    preserveState: true,
    preserveScroll: true,
  });
};

// Función para limpiar los filtros
const clearFilters = () => {
  startDate.value = '';
  endDate.value = '';
  filterAccessLogs();
};

// Función para manejar la navegación y preservar los filtros
const navigate = (url) => {
  router.visit(url, {
    method: 'get',
    data: {
      start_date: startDate.value,
      end_date: endDate.value,
    },
    preserveState: true,
    preserveScroll: true,
  });
};

// Función para descargar el PDF del histórico de acceso
const downloadPDF = () => {
  const url = route('employees.history.download', { employee: props.employee.id, start_date: startDate.value, end_date: endDate.value });
  window.open(url, '_blank'); // Abre el PDF en una nueva pestaña para descarga
};

</script>
