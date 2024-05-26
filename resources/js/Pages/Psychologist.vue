<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/inertia-vue3';

// Substitua pelo ID do psicólogo logado
const psicologoId = 1;

// Armazena as notificações não lidas
const notifications = ref([]);

// Função para verificar notificações
const checkNotifications = async () => {
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
onMounted(() => {
  intervalId = setInterval(checkNotifications, 5000); // Verifica a cada 5 segundos
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
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

