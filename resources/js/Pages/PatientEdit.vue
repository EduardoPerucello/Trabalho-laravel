<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Psicologo
      </h2>
    </template>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
      <h1 class="text-2xl font-bold mb-6 text-center">Editar Paciente</h1>
      <form @submit.prevent="submitForm" class="space-y-6">
        <div v-if="errors.length" class="mb-4">
          <ul>
            <li v-for="(error, index) in errors" :key="index" class="text-red-500">{{ error }}</li>
          </ul>
        </div>
        <div>
          <label for="full_name" class="block text-gray-700 font-semibold">Nome Completo</label>
          <input v-model="form.full_name" type="text" id="full_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div>
          <label for="cep" class="block text-gray-700 font-semibold">CEP</label>
          <input v-model="form.cep" @blur="preencherEndereco" type="text" id="cep" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div>
          <label for="endereco" class="block text-gray-700 font-semibold">Endereço</label>
          <input v-model="form.endereco" type="text" id="endereco" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly required>
        </div>
        <div>
          <label for="bairro" class="block text-gray-700 font-semibold">Bairro</label>
          <input v-model="form.bairro" type="text" id="bairro" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly required>
        </div>
        <div>
          <label for="cidade" class="block text-gray-700 font-semibold">Cidade</label>
          <input v-model="form.cidade" type="text" id="cidade" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly required>
        </div>
        <div>
          <label for="estado" class="block text-gray-700 font-semibold">Estado</label>
          <input v-model="form.estado" type="text" id="estado" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly required>
        </div>
        <div>
          <label for="phone" class="block text-gray-700 font-semibold">Número de Celular (WhatsApp)</label>
          <input v-model="form.phone" type="text" id="phone" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <button :disabled="processing" type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-200">
          <template v-if="processing">Processando...</template>
          <template v-else>Salvar</template>
        </button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { ref } from 'vue';

const form = ref({
  full_name: '',
  cep: '',
  endereco: '',
  bairro: '',
  cidade: '',
  estado: '',
  phone: ''
});

const errors = ref([]);
const processing = ref(false);

const preencherEndereco = async () => {
  try {
    const cepNumerico = form.value.cep.replace(/\D/g, '');
    if (cepNumerico.length !== 8) {
      throw new Error('CEP inválido. O CEP deve conter 8 dígitos.');
    }
    const response = await axios.get(`https://viacep.com.br/ws/${cepNumerico}/json/`);
    form.value.endereco = response.data.logradouro;
    form.value.bairro = response.data.bairro;
    form.value.cidade = response.data.localidade;
    form.value.estado = response.data.uf;
  } catch (error) {
    console.error('Erro ao buscar endereço:', error);
    alert(error.message || 'Ocorreu um erro ao buscar o endereço. Por favor, tente novamente.');
  }
};

const submitForm = async () => {
  const patientId = window.location.pathname.split('/').pop(); // Extrai o patient_id da URL
  try {
    processing.value = true;
    const response = await axios.put(`/patients-update/${patientId}`, form.value);
    console.log('Paciente atualizado com sucesso:', response.data);
    // Limpar o formulário após o sucesso
    form.value = {
      full_name: '',
      cep: '',
      endereco: '',
      bairro: '',
      cidade: '',
      estado: '',
      phone: ''
    };
    errors.value = [];
    processing.value = false;
    // Aqui você pode redirecionar para a página de detalhes do paciente ou exibir uma mensagem de sucesso.
    alert('Paciente atualizado com sucesso!');
  } catch (error) {
    processing.value = false;
    if (error.response && error.response.status === 422) {
      errors.value = Object.values(error.response.data.errors).flat();
    } else {
      console.error('Erro ao atualizar paciente:', error);
      // Aqui você pode exibir uma mensagem de erro genérica.
    }
  }
};
</script>
