<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Agendar Consulta" />

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Agendar Consulta</h1>
        <form @submit.prevent="submitForm" class="max-w-md mx-auto">
            <!-- Campos do formulário -->
            <div class="mb-4">
                <label for="patientId" class="block text-sm font-medium text-gray-700">Paciente</label>
                <input type="text" v-model="patientId" id="patientId" placeholder="ID do Paciente" class="mt-1 p-2 border rounded-md w-full">
            </div>
            <div class="mb-4">
                <label for="psicologoId" class="block text-sm font-medium text-gray-700">Psicólogo</label>
                <input type="text" v-model="psicologoId" id="psicologoId" placeholder="ID do Psicólogo" class="mt-1 p-2 border rounded-md w-full">
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
</template>

<script>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
    setup() {
        const { $inertia } = usePage();
        const patientId = ref('');
        const psicologoId = ref('');
        const date = ref('');
        const time = ref('');
        const errorMessage = ref('');

        const submitForm = async () => {
            console.log('submitForm chamado')
            try {
                const response = await axios.post('/appointments', {
                    patient_id: patientId.value,
                    psychologist_id: psychologistId.value,
                    date: date.value,
                    time: time.value
                });
                console.log(response.data);
                alert('Consulta agendada com sucesso para o paciente ' + patientId.value);
                alert('Botão de agendar clicado');
            } catch (error) {
                console.error(error);
                errorMessage.value = 'Não foi possível agendar a consulta.';
            }
        };

        return {
            patientId,
            psicologoId,
            date,
            time,
            errorMessage,
            submitForm
        };
    }
}
</script>
