<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/inertia-vue3';

// Armazena as notificações não lidas
const notifications = ref([]);

// Função para verificar notificações
const checkNotifications = async (psicologoId) => {
  try {
    const response = await axios.get(`/notifications/${psicologoId}`);
    notifications.value = response.data;
    if (notifications.value.length > 0) {
      notifications.value.forEach(notification => {
        alert(notification.message);
        markAsRead(notification.id);
      });
    }
  } catch (error) {
    console.error('Erro ao verificar notificações:', error);
  }
};

// Função para marcar notificações como lidas
const markAsRead = async (notificationId) => {
  try {
    await axios.post(`/notifications/read/${notificationId}`);
  } catch (error) {
    console.error('Erro ao marcar notificação como lida:', error);
  }
};

// Iniciar e parar o polling
let intervalId;
onMounted(async () => {
  try {
    const psicologoId = window.location.pathname.split('/').pop();
    intervalId = setInterval(() => checkNotifications(psicologoId), 5000); // Verifica a cada 5 segundos
  } catch (error) {
    console.error('Erro ao obter o ID do psicólogo logado:', error);
  }
});

onUnmounted(() => {
  clearInterval(intervalId);
});
</script>

<template>
  <Head title="Psicologo" />

  <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Psicologo
          </h2>
      </template>

      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <!-- Botão para acessar a lista de psicólogos -->
                      <a href="/patient-view" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                          Lista de Pacientes
                      </a>
                  </div>
              </div>
          </div>
      </div>
      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <!-- Botão para acessar os documentos -->
                      <a href="/documentos" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                          Documentos
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </AuthenticatedLayout>
</template>
