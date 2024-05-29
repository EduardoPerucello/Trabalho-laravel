<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted } from 'vue';
</script>

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
            <!-- Botão para redirecionar para o histórico de agendamentos -->
            <a href="/create-patient" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              Cadastrar Usuários
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- Botão para redirecionar para o histórico de agendamentos -->
            <a href="/create-psicologo" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              Cadastrar Psicólogo
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- Botão para redirecionar para o histórico de agendamentos -->
            <a href="/avisar-psicologo" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              Avisar Psicólogo
            </a>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
