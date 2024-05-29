<meta name="csrf-token" content="{{ csrf_token() }}"></meta>

<template>
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
            <h2>Informações</h2>
            <div v-if="patient" :key="patient.id">
              <h1>{{ patient.full_name }}</h1>
              <p>Endereço: {{ patient.endereco }}, {{ patient.bairro }}, {{ patient.cidade }}, {{ patient.estado }}</p>
              <p>CEP: {{ patient.cep }}</p>
              <p>Telefone: {{ patient.phone }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <h2>Sessões</h2>
            <ul>
              <li v-for="session in sessions" :key="session.id" class="mb-4">
                <p>Data: {{ session.date }}</p>
                <p>Hora: {{ session.time }}</p>
                <label for="note">Nota:</label>
                <input type="text" v-model="session.note">
                <button @click="updateNote(session)">Adicionar Nota</button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { ref, onMounted } from 'vue';

const patient = ref(null);
const sessions = ref([]);

// Obtenção do ID do paciente da URL
const id = window.location.pathname.split('/').pop();

const fetchPatient = async () => {
  if (!id) {
    console.error('ID do paciente não encontrado');
    return;
  }

  try {
    const response = await axios.get(`/patients/${id}/info`);
    patient.value = response.data;
    fetchSessions(); // Após buscar o paciente, buscar as sessões associadas
  } catch (error) {
    console.error('Erro ao buscar paciente:', error);
  }
};

const fetchSessions = async () => {
  try {
    const response = await axios.get(`/patients/${id}/sessions`);
    sessions.value = response.data;
  } catch (error) {
    console.error('Erro ao buscar sessões:', error);
  }
};

const updateNote = async (session) => {
  try {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    await axios.put(`appointments/${session.id}/note`, { note: session.note }, {
      headers: {
        'X-CSRF-TOKEN': token
      }
    });
    
    console.log('Nota adicionada com sucesso');
  } catch (error) {
    console.error('Erro ao adicionar nota:', error);
  }
};

onMounted(() => {
  fetchPatient();
});
</script>
