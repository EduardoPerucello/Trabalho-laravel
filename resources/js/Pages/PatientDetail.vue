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
            <h2 class="text-2xl font-semibold mb-4">Informações</h2>
            <div v-if="patient" :key="patient.id">
              <h1 class="text-3xl font-bold mb-2">{{ patient.full_name }}</h1>
              <p class="text-gray-700 mb-2">Endereço: {{ patient.endereco }}, {{ patient.bairro }}, {{ patient.cidade }}, {{ patient.estado }}</p>
              <p class="text-gray-700 mb-2">CEP: {{ patient.cep }}</p>
              <p class="text-gray-700 mb-2">Telefone: {{ patient.phone }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-semibold mb-4">Sessões</h2>
            <ul>
              <li v-for="session in sessions" :key="session.id" class="mb-4">
                <div class="flex justify-between items-center">
                  <div>
                    <p class="text-gray-700">Data: {{ session.date }}</p>
                    <p class="text-gray-700">Hora: {{ formatTime(session.time) }}</p>
                    <!-- Exibir a nota -->
                    <p class="text-gray-700">Nota: {{ session.note }}</p>
                  </div>
                  <div class="flex items-center space-x-4">
                    <label :for="'note-' + session.id" class="text-gray-700">Nova Nota:</label>
                    <input :id="'note-' + session.id" type="text" v-model="session.newNote" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring focus:ring-blue-200">
                    <button @click="updateNote(session)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">Adicionar Nota</button>
                  </div>
                </div>
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
    // Adicione uma nova propriedade 'newNote' para cada sessão
    sessions.value = response.data.map(session => ({
      ...session,
      newNote: ''
    }));
  } catch (error) {
    console.error('Erro ao buscar sessões:', error);
  }
};

const updateNote = async (session) => {
  try {
    await axios.put(`/appointments/${session.id}/note`, { note: session.newNote });
    console.log('Nota adicionada com sucesso');
    session.note = session.newNote !== '' ? session.newNote : null; // Atualize a nota para a nova nota ou null se estiver vazia
    session.newNote = ''; // Limpe o campo de entrada de texto para a nova nota após adicionar
  } catch (error) {
    console.error('Erro ao adicionar nota:', error);
  }
};

const formatTime = (time) => {
  const [hour, minute] = time.split(':');
  return `${hour}:${minute}`;
};

onMounted(() => {
  fetchPatient();
});
</script>
