<template>
    <Head title="Paciente" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Paciente
            </h2>
        </template>
       
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ul class="list-none">
                            <li v-for="patient in patients" :key="patient.id">
                                <div>
                                    <a :href="'/appointments-create/' + patient.id" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block text-sm w-48">
                                        Agendar Consulta
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ul class="list-none">
                            <li v-for="patient in patients" :key="patient.id">
                                <div>
                                    <a :href="'/consultas-agendadas/' + patient.id" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block text-sm w-48">
                                        Consultas Agendadas
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ul class="list-none">
                            <li v-for="patient in patients" :key="patient.id">
                                <div>
                                    <a :href="'/historico/' + patient.id" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block text-sm w-48">
                                        Histórico de Consultas
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { usePage } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        AuthenticatedLayout
    },
    setup() {
        const patients = ref([]);

        const fetchPatients = async () => {
            try {
                const response = await axios.get('/api/patients');
                patients.value = response.data;
            } catch (error) {
                console.error('Erro ao buscar pacientes:', error);
            }
        };

        onMounted(() => {
            fetchPatients();
        });

        return {
            patients
        };
    }
}
</script>
