<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({ hotels: Object })


</script>

<template>

    <Head title="Hotels" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hoteis Cadastrados</h2>
        </template>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <Link :href="route('hotels.create')"
                        class="text-sm text-white-600 hover:text-white-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <PrimaryButton class="ms-4 py-4 px-6">

                        Cadastrar Hotel

                    </PrimaryButton>
                    </Link>

                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nome
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Endereço
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Cidade
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Estado
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Ações
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <!-- Listagem dos hotéis cadastrados -->
                                            <template v-for="hotel in hotels" :key="hotel.id">
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ hotel.name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ hotel.address }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ hotel.city }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ hotel.state }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                        <!-- Ações com o Hotel -->
                                                        <div class="flex justify-center">
                                                        <Link :href="route('hotels.edit', hotel.id)"
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                        Editar
                                                        </Link>
                                                        <span class="mx-2">|</span>

                                                        <Link :href="route('hotels.show', hotel.id)"
                                                            class="text-green-600 hover:text-green-900">
                                                        Visualizar
                                                        </Link>
                                                        <span class="mx-2">|</span>
                                                            <Link :href="route('hotels.destroy', hotel.id)" method="DELETE"
                                                                class="text-red-600 hover:text-red-900">
                                                                    Deletar
                                                            </Link>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
