<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import axios from 'axios';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const email = ref('');
const subject = ref('');
const message = ref('');

const sendEmail = async () => {
    try {
        const response = await axios.post('/send-email', {
            email: email.value,
            subject: subject.value,
            message: message.value,
        });
        alert(response.data.message);
    } catch (error) {
        console.error('Erro ao enviar email:', error);
        alert('Erro ao enviar email');
    }
};

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-white text-black min-h-screen">
        <!-- Navbar -->
        <nav class="bg-black text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <a href="/" class="text-2xl font-bold">Clínica de Psicologia</a>
                <div class="space-x-4">
                    <a href="#servicos" class="hover:text-gray-600">Serviços</a>
                    <a href="#sobre" class="hover:text-gray-600">Sobre</a>
                    <a href="#depoimentos" class="hover:text-gray-600">Depoimentos</a>
                    <template v-if="canLogin">
                        <template v-if="$page.props.auth.user">
                            <a v-if="$page.props.auth.user.role === 'secretaria'" href="/dashboard" class="btn btn-primary">Dashboard</a>
                            <a v-else-if="$page.props.auth.user.role === 'patient'" href="/patient" class="btn btn-primary">Patient</a>
                            <a v-else-if="$page.props.auth.user.role === 'psicologo'" href="/psicologo" class="btn btn-primary">Psicólogo</a>
                        </template>
                        <template v-else>
                            <a href="/login" class="btn btn-secondary">Log in</a>
                            <a v-if="canRegister" href="/register" class="btn btn-secondary">Register</a>
                        </template>
                    </template>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        <div class="container mx-auto mt-16">
            <main>
                <!-- Sobre a Clínica -->
                <section id="sobre" class="mb-10">
                    <h2 class="text-2xl font-semibold mb-4">Sobre a Clínica</h2>
                    <p class="text-lg">A Clínica de Psicologia é um espaço acolhedor e seguro, onde nossos psicólogos altamente qualificados estão comprometidos em fornecer cuidados de saúde mental de qualidade para indivíduos, casais e famílias.</p>
                </section>

                <!-- Descrição dos serviços -->
                <section id="servicos" class="mb-10">
                    <h2 class="text-2xl font-semibold mb-4">Serviços</h2>
                    <div class="text-lg space-y-4">
                        <!-- Serviço 1 -->
                        <div>
                            <h3 class="text-xl font-semibold">Terapia Individual</h3>
                            <p>Oferecemos sessões de terapia individual para adultos, adolescentes e crianças. Nossos terapeutas são especializados em diversas abordagens, incluindo terapia cognitivo-comportamental, psicoterapia psicodinâmica e terapia humanista. Trabalhamos com questões como ansiedade, depressão, estresse, baixa autoestima, e muito mais.</p>
                        </div>
                        <!-- Serviço 2 -->
                        <div>
                            <h3 class="text-xl font-semibold">Terapia de Casal</h3>
                            <p>A terapia de casal é uma oportunidade para parceiros explorarem e resolverem conflitos em um ambiente seguro e neutro. Ajudamos casais a melhorar a comunicação, fortalecer o vínculo emocional e encontrar soluções para problemas recorrentes.</p>
                        </div>
                        <!-- Serviço 3 -->
                        <div>
                            <h3 class="text-xl font-semibold">Terapia Familiar</h3>
                            <p>A terapia familiar visa melhorar a dinâmica e a comunicação entre os membros da família. É ideal para resolver conflitos, lidar com mudanças significativas ou crises familiares, e promover um ambiente de apoio mútuo.</p>
                        </div>
                        <!-- Serviço 4 -->
                        <div>
                            <h3 class="text-xl font-semibold">Psicoterapia Infantil</h3>
                            <p>As crianças muitas vezes expressam suas emoções de maneira diferente dos adultos. Nossos especialistas em psicoterapia infantil utilizam técnicas lúdicas e criativas para ajudar os pequenos a lidar com suas emoções, desenvolver habilidades sociais e superar dificuldades comportamentais.</p>
                        </div>
                        <!-- Serviço 5 -->
                        <div>
                            <h3 class="text-xl font-semibold">Avaliação Psicológica</h3>
                            <p>Bem-vindo à Clínica de Psicologia Bem-Estar! Somos um espaço dedicado à promoção da saúde mental e ao bem-estar emocional. Nossa missão é oferecer um atendimento acolhedor e profissional, ajudando nossos pacientes a encontrar equilíbrio e qualidade de vida.</p>
                        </div>
                    </div>
                </section>

                <!-- Depoimentos de Pacientes -->
                <section id="depoimentos">
                    <h2 class="text-2xl font-semibold mb-4">Depoimentos de Pacientes</h2>
                    <div class="space-y-4">
                        <!-- Depoimento 1 -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" src="https://source.unsplash.com/random/100x100" alt="">
                            </div>
                            <div class="flex-1">
                                <blockquote class="text-lg font-medium">"Estou muito grato pelos serviços oferecidos pela Clínica de Psicologia. A terapia foi transformadora para mim e minha família."</blockquote>
                                <cite class="block text-sm font-semibold">- João Silva</cite>
                            </div>
                        </div>
                                               <!-- Depoimento 2 -->
                                               <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" src="https://source.unsplash.com/random/101x101" alt="">
                            </div>
                            <div class="flex-1">
                                <blockquote class="text-lg font-medium">"A equipe da Clínica de Psicologia é muito profissional e atenciosa. Recomendo fortemente seus serviços a todos que precisam de apoio emocional."</blockquote>
                                <cite class="block text-sm font-semibold">- Maria Santos</cite>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Formulário de Envio de Email -->
                <section class="mt-8 w-full">
                    <h2 class="text-2xl font-semibold mb-4">Entre em contado</h2>
                    <form @submit.prevent="sendEmail" class="space-y-4 w-full">
                        <div class="w-full">
                            <label for="email" class="block text-gray-700">Email:</label>
                            <input type="email" v-model="email" required class="input w-full" placeholder="Seu email" />
                        </div>
                        <div class="w-full">
                            <label for="subject" class="block text-gray-700">Assunto:</label>
                            <input type="text" v-model="subject" required class="input w-full" placeholder="Assunto" />
                        </div>
                        <div class="w-full">
                            <label for="message" class="block text-gray-700">Mensagem:</label>
                            <textarea v-model="message" required class="input w-full" placeholder="Sua mensagem"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Enviar</button>
                    </form>
                </section>
            </main>
        </div>

        <!-- Informações de Contato -->
        <section id="contato" class="bg-gray-100 py-12">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Informações de Contato -->
                    <div>
                        <h2 class="text-2xl font-semibold mb-4">Informações de Contato</h2>
                        <ul class="space-y-2">
                            <li><strong>Telefone:</strong> (XX) XXXX-XXXX</li>
                            <li><strong>E-mail:</strong> contato@clinicapsicologia.com</li>
                            <li><strong>Endereço:</strong> Rua Nome da Rua, Número - Bairro, Cidade, Estado</li>
                        </ul>
                    </div>
                    <!-- Horário de Funcionamento -->
                    <div>
                        <h2 class="text-2xl font-semibold mb-4">Horário de Funcionamento</h2>
                        <p><strong>Segunda a Sexta:</strong> 08:00 - 18:00</p>
                        <p><strong>Sábado:</strong> 08:00 - 12:00</p>
                        <p><strong>Domingo:</strong> Fechado</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rodapé -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto">
                <div class="flex justify-between items-center">
                    <p>&copy; 2024 Clínica de Psicologia. Todos os direitos reservados.</p>
                    <ul class="flex space-x-4">
                        <li><a href="#" class="hover:text-gray-300">Termos de Serviço</a></li>
                        <li><a href="#" class="hover:text-gray-300">Política de Privacidade</a></li>
                        <li><a href="#" class="hover:text-gray-300">Sitemap</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
};
</script>

