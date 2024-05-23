<template>
    <div>
      <h1>Histórico de Agendamentos</h1>
      <ul v-if="appointments.length">
        <li v-for="appointment in appointments" :key="appointment.id">
          {{ appointment.date }} - {{ appointment.time }}
        </li>
      </ul>
      <p v-else>Nenhum agendamento encontrado.</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  
  const appointments = ref([]);
  
  // Função para buscar os agendamentos
  const fetchAppointments = async () => {
    try {
      const { data } = await usePage().inertia.get('/api/appointments');
      appointments.value = data.appointments;
    } catch (error) {
      console.error('Erro ao recuperar os agendamentos:', error);
    }
  };
  
  // Chamada à função para buscar os agendamentos quando o componente for montado
  onMounted(fetchAppointments);
  </script>
  