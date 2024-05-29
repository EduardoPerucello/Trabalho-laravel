<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Secretaria
      </h2>
    </template>

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
      <h1 class="text-2xl font-bold mb-6 text-center">Cadastrar Psicólogo</h1>
      <form @submit.prevent="submitForm" class="space-y-6">
        <div v-if="Object.keys(errors).length" class="mb-4">
          <ul>
            <li v-for="(error, index) in errors" :key="index" class="text-red-500">{{ error }}</li>
          </ul>
        </div>
        <div>
          <label for="nome" class="block text-gray-700 font-semibold">Nome Completo</label>
          <input v-model="form.nome" type="text" id="nome" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div>
          <label for="email" class="block text-gray-700 font-semibold">Email</label>
          <input v-model="form.email" type="email" id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div>
          <label for="password" class="block text-gray-700 font-semibold">Senha</label>
          <input v-model="form.password" type="password" id="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <button :disabled="processing" type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-200">
          <template v-if="processing">Processando...</template>
          <template v-else>Cadastrar</template>
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
  nome: '',
  email: '',
  password: ''
});

const errors = ref({});
const processing = ref(false);

const submitForm = async () => {
  try {
    processing.value = true;
    const response = await axios.post('/psicologo', form.value);
    alert(response.data.message);
    // Limpar o formulário após o sucesso
    form.value = {
      nome: '',
      email: '',
      password: ''
    };
    errors.value = {};
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
      alert('Erro na validação dos dados.');
    } else {
      alert('Erro ao cadastrar o psicólogo. Por favor, tente novamente.');
    }
  } finally {
    processing.value = false;
  }
};
</script>
