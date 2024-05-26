<template>
    <Head title="Histórico de Consultas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Histórico de Consultas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1>Histórico de Consultas</h1>
                        <div v-if="historico.length === 0 && !loading">
                            <p>Nenhuma consulta passada encontrada.</p>
                        </div>
                        <div v-else>
                            <div v-for="consultation in historico" :key="consultation.id" class="mb-4 p-4 border rounded">
                                <h3 class="text-lg font-semibold">{{ consultation.psicologo.full_name }}</h3>
                                <p>Data: {{ consultation.date }}</p>
                                <p>Hora: {{ consultation.time }}</p>
                                <!-- Adicione outros campos da consulta conforme necessário -->
                            </div>
                        </div>
                        <div v-if="loading">
                            <p>Carregando histórico...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    data() {
        return {
            historico: [],
            loading: true
        };
    },
    mounted() {
        this.getHistorico();
    },
    methods: {
        async getHistorico() {
            try {
                const response = await axios.get('/consultas/historico');
                this.historico = response.data;
                this.loading = false;
            } catch (error) {
                console.error('Erro ao recuperar o histórico:', error);
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
/* Adicione estilos personalizados conforme necessário */
</style>
