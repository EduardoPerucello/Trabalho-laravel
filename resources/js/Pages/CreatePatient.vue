<template>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold mb-6 text-center">Cadastrar Paciente</h1>
        <form @submit.prevent="submitForm" class="space-y-6">
            <div>
                <label for="full_name" class="block text-gray-700 font-semibold">Nome Completo</label>
                <input v-model="form.nome" type="text" id="full_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>
            <div>
                <label for="cep" class="block text-gray-700 font-semibold">CEP</label>
                <input v-model="form.cep" @blur="preencherEndereco" type="text" id="cep" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>
            <div>
                <label for="address" class="block text-gray-700 font-semibold">Endereço</label>
                <input v-model="form.endereco" type="text" id="endereco" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly required>
            </div>
            <div>
                <label for="bairro" class="block text-gray-700 font-semibold">Bairro</label>
                <input v-model="form.bairro" type="text" id="bairro" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly required>
            </div>
            <div>
                <label for="cidade" class="block text-gray-700 font-semibold">Cidade</label>
                <input v-model="form.cidade" type="text" id="cidade" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly required>
            </div>
            <div>
                <label for="estado" class="block text-gray-700 font-semibold">Estado</label>
                <input v-model="form.estado" type="text" id="estado" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly required>
            </div>
            <div>
                <label for="phone" class="block text-gray-700 font-semibold">Número de Celular (WhatsApp)</label>
                <input v-model="form.telefone" type="text" id="phone" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
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
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { ref } from 'vue';

const form = useForm({
    nome: '',
    cep: '',
    endereco: '',
    bairro: '',
    cidade: '',
    estado: '',
    telefone: '',
    email: '',
    password: ''
});

const processing = ref(false);

const submitForm = async () => {
    try {
        processing.value = true;
        // Aqui você pode enviar os dados do formulário para o servidor
        // Por exemplo, usando o Axios para enviar uma requisição POST
        await axios.post('/patients', form.value);
        
        // Após o envio bem-sucedido, você pode limpar o formulário ou fazer outras ações necessárias
        form.value = {
            nome: '',
            cep: '',
            endereco: '',
            bairro: '',
            cidade: '',
            estado: '',
            telefone: '',
            email: '',
            password: ''
        };
        
        alert('Formulário enviado com sucesso!');
    } catch (error) {
        console.error('Erro ao enviar formulário:', error);
        alert('Ocorreu um erro ao enviar o formulário. Por favor, tente novamente mais tarde.');
    } finally {
        processing.value = false;
    }
};

const preencherEndereco = async () => {
    try {
        // Remover qualquer caractere que não seja número do CEP
        const cepNumerico = form.cep.replace(/\D/g, '');

        // Verificar se o CEP possui 8 dígitos
        if (cepNumerico.length !== 8) {
            throw new Error('CEP inválido. O CEP deve conter 8 dígitos.');
        }

        // Fazer a requisição para obter os detalhes do endereço
        const response = await axios.get(`https://viacep.com.br/ws/${cepNumerico}/json/`);

        console.log('Resposta da API do ViaCEP:', response.data);

        // Preencher os campos do endereço com os dados obtidos
        form.endereco = response.data.logradouro;
        form.bairro = response.data.bairro;
        form.cidade = response.data.localidade;
        form.estado = response.data.uf;

        console.log('Campos do formulário após preenchimento:', form.value);
    } catch (error) {
        console.error('Erro ao buscar endereço:', error);
        alert(error.message || 'Ocorreu um erro ao buscar o endereço. Por favor, tente novamente.');
    }
};
</script>

<Head title="Cadastro de Usuario" />
