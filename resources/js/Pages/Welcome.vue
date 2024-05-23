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
    <div class="bg-white text-black min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <!-- Navbar -->
        <nav class="fixed top-0 left-0 w-full bg-black shadow-md z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href='/' class="text-2xl font-bold text-white">Clínica de Psicologia</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#servicos" class="text-white hover:text-gray-600">Serviços</a>
                        <a href="#sobre" class="text-white hover:text-gray-600">Sobre</a>
                        <a href="#depoimentos" class="text-white hover:text-gray-600">Depoimentos</a>
                        <template v-if="canLogin">
                            <a
                                v-if="$page.props.auth.user"
                                href="/dashboard"
                                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                            >
                                Dashboard
                            </a>
                            <template v-else>
                                <a
                                    href="/login"
                                    class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                >
                                    Log in
                                </a>
                                <a
                                    v-if="canRegister"
                                    href="/register"
                                    class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                >
                                    Register
                                </a>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl mt-16">
            <main class="mt-6">
                <!-- Sobre a Clínica -->
                <section id="sobre" class="mb-10">
                    <h2 class="text-2xl font-semibold mb-4">Sobre a Clínica</h2>
                    <p class="text-lg">A Clínica de Psicologia é um espaço acolhedor e seguro, onde nossos psicólogos altamente qualificados estão comprometidos em fornecer cuidados de saúde mental de qualidade para indivíduos, casais e famílias.</p>
                </section>

                <!-- Descrição dos serviços -->
                <section id="servicos" class="mb-10">
                    <h2 class="text-2xl font-semibold mb-4">Serviços</h2>
                    <div class="text-lg space-y-4">
                        <div>
                            <h3 class="text-xl font-semibold">Terapia Individual</h3>
                            <p>Oferecemos sessões de terapia individual para adultos, adolescentes e crianças. Nossos terapeutas são especializados em diversas abordagens, incluindo terapia cognitivo-comportamental, psicoterapia psicodinâmica e terapia humanista. Trabalhamos com questões como ansiedade, depressão, estresse, baixa autoestima, e muito mais.</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Terapia de Casal</h3>
                            <p>A terapia de casal é uma oportunidade para parceiros explorarem e resolverem conflitos em um ambiente seguro e neutro. Ajudamos casais a melhorar a comunicação, fortalecer o vínculo emocional e encontrar soluções para problemas recorrentes.</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Terapia Familiar</h3>
                            <p>A terapia familiar visa melhorar a dinâmica e a comunicação entre os membros da família. É ideal para resolver conflitos, lidar com mudanças significativas ou crises familiares, e promover um ambiente de apoio mútuo.</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Psicoterapia Infantil</h3>
                            <p>As crianças muitas vezes expressam suas emoções de maneira diferente dos adultos. Nossos especialistas em psicoterapia infantil utilizam técnicas lúdicas e criativas para ajudar os pequenos a lidar com suas emoções, desenvolver habilidades sociais e superar dificuldades comportamentais.</p>
                        </div>
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
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <img
                                    class="h-12 w-12 rounded-full"
                                    src="https://source.unsplash.com/random/100x100"
                                    alt=""
                                />
                            </div>
                            <div class="flex-1">
                                <blockquote class="text-lg font-medium">
                                    "Estou muito grato pelos serviços oferecidos pela Clínica de Psicologia. A terapia foi transformadora para mim e minha família."
                                </blockquote>
                                <cite class="block text-sm font-semibold">- João Silva</cite>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <img
                                    class="h-12 w-12 rounded-full"
                                    src="https://source.unsplash.com/random/101x101"
                                    alt=""
                                />
                            </div>
                            <div class="flex-1">
                                <blockquote class="text-lg font-medium">
                                    "A equipe da Clínica de Psicologia é muito profissional e atenciosa. Recomendo fortemente seus serviços a todos que precisam de apoio emocional."
                                </blockquote>
                                <cite class="block text-sm font-semibold">- Maria Santos</cite>
                            </div>
                        </div>
                    </div>
                </section>
            <!-- Envio de Email -->
            <form @submit.prevent="sendEmail" class="mt-4">
                <div class="mb-4">
                  <label for="email" class="block text-gray-700">Email:</label>
                  <input type="email" v-model="email" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" />
                </div>
                <div class="mb-4">
                  <label for="subject" class="block text-gray-700">Assunto:</label>
                  <input type="text" v-model="subject" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" />
                </div>
                <div class="mb-4">
                  <label for="message" class="block text-gray-700">Mensagem:</label>
                  <textarea v-model="message" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Enviar</button>
              </form>
            </main>
        </div>
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
