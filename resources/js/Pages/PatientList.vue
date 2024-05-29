<template>
  <Head title="Secretaria" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Secretaria
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <h1>Pacientes</h1>
            <ul>
              <li v-for="patient in patients" :key="patient.id">
                <div class="flex items-center">
                  {{ patient.full_name }} - 
                  <!-- Coloquei o nome do paciente dentro do link de edição -->
                  <a :href="'/patient-edit/' + patient.id" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  components: {
    AuthenticatedLayout
  },
  setup() {
    const patients = ref([]);

    const fetchPatients = async () => {
      try {
        const response = await axios.get('/api/patients');
        patients.value = response.data;
      } catch (error) {
        console.error('Erro ao buscar pacientes:', error);
      }
    };

    onMounted(() => {
      fetchPatients();
    });

    return {
      patients
    };
  }
};
</script>
