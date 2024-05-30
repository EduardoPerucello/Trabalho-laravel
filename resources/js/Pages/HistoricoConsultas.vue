<template>
  <div>
    <Head title="Paciente" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Paciente
        </h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <h1 class="text-2xl font-semibold mb-4">Consultas Passadas</h1>
              <div v-if="pastConsultations.length === 0 && !loading">
                <p>Nenhuma consulta.</p>
              </div>
              <div v-else>
                <div v-for="consultation in pastConsultations" :key="consultation.id" class="mb-6">
                  <div>
                    <h2 class="text-lg font-semibold">{{ consultation.patient_name }}</h2>
                    <p class="text-gray-700">Data: {{ consultation.date }}</p>
                    <p class="text-gray-700">Hora: {{ formatTime(consultation.time) }}</p>
                    <p class="text-gray-700">Psicólogo: {{ consultation.psicologo_name }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { Head } from '@inertiajs/inertia-vue3';

export default {
  components: {
    AuthenticatedLayout
  },
  data() {
    return {
      consultations: [],
      loading: true
    };
  },
  mounted() {
    this.getConsultations();
    // Iniciar o mecanismo de atualização periódica
    setInterval(this.checkConsultations, 60000); // Verificar a cada minuto
  },
  computed: {
    pastConsultations() {
      const now = new Date();
      return this.consultations.filter(consultation => {
        const consultationTime = new Date(consultation.date + 'T' + consultation.time);
        return consultationTime < now;
      });
    }
  },
  methods: {
    async getConsultations() {
      try {
        const response = await axios.get('/consultas');
        this.consultations = response.data;
        this.loading = false;
      } catch (error) {
        console.error('Erro ao recuperar as consultas:', error);
        this.loading = false;
      }
    },
    formatTime(time) {
      const [hour, minute] = time.split(':');
      return `${hour}:${minute}`;
    },
  },
};
</script>
