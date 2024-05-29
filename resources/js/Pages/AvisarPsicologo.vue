<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Secretaria
      </h2>
    </template>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
      <h1 class="text-2xl font-bold mb-6 text-center">Lista de Psicólogos</h1>
      <ul>
        <li v-for="(psicologo, index) in psicologos" :key="index" class="mb-4 flex justify-between items-center">
          <span>{{ psicologo.full_name }}</span>
          <button @click="sendNotification(psicologo.id)" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-200">
            Notificar
          </button>
        </li>
      </ul>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const psicologos = ref([]);

const fetchPsychologists = async () => {
  try {
    const response = await axios.get('/api/psicologos');
    psicologos.value = response.data;
  } catch (error) {
    console.error('Erro ao buscar psicólogos:', error);
  }
};

const sendNotification = async (psicologoId) => {
  try {
    await axios.post('/notifications', {
      psicologo_id: psicologoId,
      message: 'Seu paciente chegou'
    });
    alert('Notificação enviada com sucesso');
  } catch (error) {
    console.error('Erro ao enviar notificação:', error);
  }
};

onMounted(() => {
  fetchPsychologists();
});
</script>
