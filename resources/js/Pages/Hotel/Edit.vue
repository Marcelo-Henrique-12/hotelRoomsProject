<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref,defineProps } from 'vue';
import axios from 'axios';
import { mask } from 'vue-the-mask';


const props = defineProps({
    hotel: Object,
});

// Inicializa o formulário com os dados do hotel
const form = useForm({
    name: props.hotel.name || '',
    address: props.hotel.address || '',
    city: props.hotel.city || '',
    state: props.hotel.state || '',
    zip_code: props.hotel.zip_code || '',
    website: props.hotel.website || '',
});


// Variáveis para controle de carregamento e erros
const loadingCep = ref(false);
const cepError = ref('');

// Função para buscar o endereço com base no CEP
const fetchAddress = async () => {
    const cep = form.zip_code.replace(/\D/g, '');
    if (cep.length !== 8) {
        cepError.value = 'Formato de CEP inválido.';
        return;
    }

    try {
        loadingCep.value = true;
        const response = await axios.get(`https://viacep.com.br/ws/${cep}/json/`);
        const data = response.data;

        if (data.erro) {
            cepError.value = 'CEP não encontrado.';
            return;
        }

        form.address = data.logradouro;
        form.city = data.localidade;
        form.state = data.uf;
        cepError.value = '';
    } catch (error) {
        cepError.value = 'Erro ao consultar CEP.';
    } finally {
        loadingCep.value = false;
    }
};

const submit = () => {
    // Remove a máscara do CEP antes de enviar
    form.zip_code = form.zip_code.replace(/\D/g, '');

    //submete o formulário
    form.put(route('hotels.update', props.hotel.id), {
        onFinish: () => {
            if (Object.keys(form.errors).length === 0) {
                form.reset();  // Irá redefir o formulário se não houver erros para manter os dados preenchidos
            }
        },
    });
};

const formatZipCode = () => {
    form.zip_code = form.zip_code.replace(/\D/g, ''); // Remove todos os não-dígitos
    if (form.zip_code.length > 5) {
        // Aplica a máscara se o CEP tiver mais de 5 dígitos
        form.zip_code = form.zip_code.replace(/^(\d{5})(\d)/, '$1-$2');
    }
};



</script>

<template>

    <Head title="Hotels" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Editar Hotel</h2>
        </template>
        <div class="py-12 flex justify-center">
            <div class="max-w-7xl w-full sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-20 lg:p-20">
                    <form class="w-full " @submit.prevent="submit">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="name">
                                    Nome
                                </label>
                                <input v-model="form.name"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="name" name="name" type="text" placeholder="Nome do Hotel">
                                <p v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-4">
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="zip_code">
                                    CEP
                                </label>
                                <input v-model="form.zip_code" @blur="fetchAddress" @input="formatZipCode"
                                    v-mask="'#####-###'"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="zip_code" type="text" placeholder="12345-678">
                                <p v-if="form.errors.zip_code" class="text-red-500 text-xs italic">{{
                                    form.errors.zip_code }}
                                </p>
                                <small v-if="loadingCep" class="text-gray-500">Consultando CEP...</small>
                                <small v-if="cepError" class="text-red-500">{{ cepError }}</small>
                            </div>

                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="city">
                                    Cidade
                                </label>
                                <input v-model="form.city"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="city" type="text" placeholder="Albuquerque">
                                <p v-if="form.errors.city" class="text-red-500 text-xs italic">{{ form.errors.city }}
                                </p>
                            </div>

                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="state">
                                    Estado
                                </label>
                                <input v-model="form.state"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="state" type="text" placeholder="Seu Estado">
                                <p v-if="form.errors.state" class="text-red-500 text-xs italic">{{ form.errors.state }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="address">
                                    Endereço
                                </label>
                                <input v-model="form.address"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="address" name="address" type="text" placeholder="Endereço">
                                <p v-if="form.errors.address" class="text-red-500 text-xs italic">{{ form.errors.address
                                    }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="website">
                                    Website
                                </label>
                                <input v-model="form.website"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="website" name="website" type="text" placeholder="Website">
                                <p v-if="form.errors.website" class="text-red-500 text-xs italic">{{ form.errors.website
                                    }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-around">
                            <SecondaryButton class="py-4 px-6">
                                <Link :href="route('hotels.index')">
                                    Voltar
                                </Link>
                            </SecondaryButton>
                            <PrimaryButton class="py-4 px-6" type="submit">
                                Salvar
                            </PrimaryButton>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
