<template>
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Secretaria
        </h2>
      </template>
      <div v-if="patient">
        <h1>{{ patient.full_name }}</h1>
        <p>Endereço: {{ patient.endereco }}, {{ patient.bairro }}, {{ patient.cidade }}, {{ patient.estado }}</p>
        <p>CEP: {{ patient.cep }}</p>
        <p>Telefone: {{ patient.phone }}</p>
  
        <h2>Sessões</h2>
        <ul>
          <li v-for="appointment in patient.appointments" :key="appointment.id">
            {{ appointment.date }} - {{ appointment.time }}:
            <input type="text" v-model="appointment.note">
            <button @click="updateAppointment(appointment)">Atualizar Nota</button>
          </li>
        </ul>
  
        <router-link :to="{ name: 'patient-edit', params: { id: patient.id } }">Editar Paciente</router-link>
      </div>
      <div v-else>
        <p>Carregando...</p>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import axios from 'axios';
  
  const { data, created, methods } = useData();
  
  function useData() {
    const patient = ref(null);
  
    const fetchPatient = async () => {
      const id = $route.params.id;
      try {
        const response = await axios.get(`/api/patients/${id}`);
        patient.value = response.data;
      } catch (error) {
        console.error('Erro ao buscar paciente:', error);
      }
    };
  
    const updateAppointment = async (appointment) => {
      try {
        const response = await axios.put(`/api/appointments/${appointment.id}`, { note: appointment.note });
        console.log('Nota atualizada com sucesso');
      } catch (error) {
        console.error('Erro ao atualizar nota:', error);
      }
    };
  
    created(() => {
      fetchPatient();
    });
  
    return { patient, updateAppointment };
  }
  </script>
  