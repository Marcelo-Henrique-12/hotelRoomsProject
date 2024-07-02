<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    hotels: Array,
    room: Object,
});

// Inicializar o formulário com os dados da sala
const form = useForm({
    name: props.room.name || '',
    description: props.room.description || '',
    hotel_id: props.room.hotel_id || props.room.hotel.id || '',
});

const submit = () => {
    // Submete o formulário
    form.put(route('rooms.update', props.room.id), {
        onFinish: () => {
            if (Object.keys(form.errors).length === 0) {
                form.reset(); // Redefine o formulário se não houver erros
            }
        },
    });
};
</script>

<template>
    <Head title="Editar Quarto" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Editar Quarto</h2>
        </template>

        <div class="py-12 flex justify-center">
            <div class="max-w-7xl w-full sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-20 lg:p-20">
                    <form class="w-full" @submit.prevent="submit">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 mb-6">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="name">
                                    Nome
                                </label>
                                <input v-model="form.name"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="name" name="name" type="text" placeholder="Nome do quarto">
                                <p v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 mb-6">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="description">
                                    Descrição
                                </label>
                                <input v-model="form.description"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="description" name="description" type="text" placeholder="Descrição do quarto">
                                <p v-if="form.errors.description" class="text-red-500 text-xs italic">{{ form.errors.description }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 mb-6">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="hotel">
                                    Hotel
                                </label>
                                <select v-model="form.hotel_id"
                                    class="appearance-none block w-full text-gray-700 border rounded border-gray-300 py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                    id="hotel" name="hotel">
                                    <option disabled value="">Selecione um hotel</option>
                                    <option v-for="hotel in hotels" :key="hotel.id" :value="hotel.id">{{ hotel.name }}</option>
                                </select>
                                <p v-if="form.errors.hotel_id" class="text-red-500 text-xs italic">{{ form.errors.hotel_id }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-around mt-6">
                            <SecondaryButton class="py-4 px-6">
                                <Link :href="route('rooms.index')">Voltar</Link>
                            </SecondaryButton>
                            <PrimaryButton class="py-4 px-6" type="submit">Salvar</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
