<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, defineProps } from 'vue';
import axios from 'axios';
import { mask } from 'vue-the-mask';


const props = defineProps({
    hotel: Object,
    rooms: Array,
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


</script>

<template>

    <Head title="Hotels" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Visualizar Hotel</h2>
        </template>

        <div class="py-12 flex">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-20">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Hotel</h2>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="name">
                                Nome
                            </label>
                            <input v-model="form.name" disabled
                                class="appearance-none bg-gray-200 block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
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
                            <input v-model="form.zip_code" @blur="fetchAddress" @input="formatZipCode" disabled
                                v-mask="'#####-###'"
                                class="bg-gray-200 appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
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
                            <input v-model="form.city" disabled
                                class="bg-gray-200 appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                id="city" type="text" placeholder="Albuquerque">
                            <p v-if="form.errors.city" class="text-red-500 text-xs italic">{{ form.errors.city }}
                            </p>
                        </div>

                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="state">
                                Estado
                            </label>
                            <input v-model="form.state" disabled
                                class="bg-gray-200 appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
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
                            <input v-model="form.address" disabled
                                class="bg-gray-200 appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
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
                            <input v-model="form.website" disabled
                                class="bg-gray-200 appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                id="website" name="website" type="text" placeholder="Website">
                            <p v-if="form.errors.website" class="text-red-500 text-xs italic">{{ form.errors.website
                                }}</p>
                        </div>
                    </div>

                    <PrimaryButton class="py-4 px-6">
                        <Link :href="route('hotels.index')">
                        Voltar
                        </Link>
                    </PrimaryButton>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-20 mt-5">

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center mb-5">Quartos vinculados</h2>

                    <div class="flex items-center justify-start">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Id
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Listagem dos hotéis cadastrados -->
                                <template v-for="room in rooms" :key="room.id">
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ room.id }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ room.name }}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
