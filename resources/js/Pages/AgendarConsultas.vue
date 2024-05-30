<template>
    <Head title="Cliente" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cliente
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="container mx-auto p-6">
                            <h1 class="text-2xl font-semibold mb-4">Agendar Consulta</h1>
                            <form @submit.prevent="submitForm" class="max-w-md mx-auto">
                            <div class="mb-4">
                                <label for="patients_id" class="block text-sm font-medium text-gray-700">Paciente</label>
                                <input v-model="patientId" id="patients_id" placeholder="ID do Paciente" class="mt-1 p-2 border rounded-md w-full" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="psicologo_id" class="block text-sm font-medium text-gray-700">Psicólogo</label>
                                <input type="text" v-model="psicologoId" id="psicologo_id" placeholder="ID do Psicólogo" class="mt-1 p-2 border rounded-md w-full">
                            </div>
                            <div class="mb-4">
                                <label for="date" class="block text-sm font-medium text-gray-700">Data</label>
                                <input type="date" v-model="date" id="date" class="mt-1 p-2 border rounded-md w-full">
                            </div>
                            <div class="mb-6">
                                <label for="time" class="block text-sm font-medium text-gray-700">Horário</label>
                                <input type="time" v-model="time" id="time" class="mt-1 p-2 border rounded-md w-full">
                            </div>
                            <div v-if="errorMessage" class="text-red-500 mb-4">{{ errorMessage }}</div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agendar</button>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, useRoute } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';

const { $inertia } = usePage();
const patientId = window.location.pathname.split('/').pop();
const psicologoId = ref('');
const date = ref('');
const time = ref('');
const errorMessage = ref('');
const successMessage = ref('');

const submitForm = async () => {
    errorMessage.value = '';
    successMessage.value = '';
    console.log(patientId);
    console.log(psicologoId.value);
    console.log(date.value);
    console.log(time.value);
    try {
        const response = await axios.post('/appointments', {
            patients_id: patientId,
            psicologo_id: psicologoId.value,
            date: date.value,
            time: time.value
        });
        
        successMessage.value = 'Consulta agendada com sucesso para o paciente ' + patientId;
        // Limpar os campos após o sucesso
        psicologoId.value = '';
        date.value = '';
        time.value = '';
    } catch (error) {
        console.error(error);
        errorMessage.value = 'Não foi possível agendar a consulta.';
    }
};
</script>