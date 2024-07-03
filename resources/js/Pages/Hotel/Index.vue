<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watchEffect} from 'vue';
import Modal from '@/Components/Modal.vue';


const props = defineProps({
    hotels: Object,
    success: String,
    filters: Object,
});


const form = useForm({})

const showConfirmDeleteModal = ref(false)
const deleteHotelId = ref(null);

// Abrir o modal para confirmar a exclusão
const confirmDelete = (hotelId)=>{
    showConfirmDeleteModal.value = true;
    deleteHotelId.value = hotelId;
}

// função para fechar o Modal
const closeModal = ()=>{
    showConfirmDeleteModal.value = false;
}

// Função que irá deletar o hotel e seus quartos se confirmado o Modal
const deleteHotel = (deleteHotelId) => {
    if (deleteHotelId) {
        form.delete(route('hotels.destroy', deleteHotelId), {
            onSuccess: () => {
                closeModal();
            }
        });
    }
};




// Mensagem de Feedback de error ou sucess
const show = ref(false);
const message = ref('');

watchEffect(() => {
  if (message.value) {
    show.value = true;
    setTimeout(() => {
      show.value = false;
      message.value = '';
    }, 4000); // Tempo em milissegundos antes do card de feedback desaoarecer
  }
});



// Observa a propriedade para exibir a mensagem de sucesso
watchEffect(() => {
  if (props.success) {
    message.value = props.success;
  }
});


// Barra de pesquisar
const filters = ref({
    name:  props.filters.name || '',
    city:  props.filters.city || '',
    state:  props.filters.state || '',
});

// Limpar os campos de pesquisa, mostrar todos os dados
const clearFilters = () => {
    filters.value.name = '';
    filters.value.city = '';
    filters.value.state = '';
    form.get(route('hotels.index'), { name: '', city: '',state:'' });
};
</script>

<template>

    <Head title="Hotels" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="flex justify-center font-semibold text-xl text-gray-800 leading-tight">Hoteis Cadastrados</h2>
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
                <!-- Mensagem de Feeback de Erro ou Sucesso -->
                <div v-if="show" class="fixed top-20 right-5 z-50">
                    <div class="bg-green-500 text-white rounded-md px-4 py-2 shadow-lg">
                      {{ message }}
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">


                    <!-- Barra de Pesquisa -->
                    <div class="flex justify-start mb-10">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesquisar Hotel</h2>
                    </div>
                    <div class="mb-10">
                        <form
                            @submit.prevent="$inertia.get(route('hotels.index'), { name: filters.name, city: filters.city, state: filters.state  })">
                            <div class="flex space-x-4">
                                <input v-model="filters.name" type="text" placeholder="Nome do Hotel"
                                    class="border border-gray-300 p-2 flex-grow rounded-md">
                                <input v-model="filters.city" type="text" placeholder="Cidade "
                                    class="border border-gray-300 p-2 flex-grow rounded-md">
                                <input v-model="filters.state" type="text" placeholder="Estado"
                                    class="border border-gray-300 p-2 flex-grow rounded-md">


                                <SecondaryButton type="button" @click="clearFilters" class="py-2 px-10 bg-gray-300">
                                    Limpar
                                    campos</SecondaryButton>
                                <PrimaryButton type="submit" class="py-2 px-10">Pesquisar</PrimaryButton>
                            </div>
                        </form>
                    </div>


                    <!-- Tabela de Hotéis -->
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
                                                         <!-- Abre um modal para confirmar a exclusão -->
                                                            <button @click="confirmDelete(hotel.id)" class="text-red-600 hover:text-red-900">
                                                                Deletar
                                                            </button>
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

         <!-- Modal de confirmação de exclusão de um Hotel e seus quartos-->
         <Modal :show="showConfirmDeleteModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-slate-800">
                    Ao deletar este hotel não será possível recupera-lo, e seus quartos vinculados também serão apagados. Tem certeza em continuar ?
                </h2>
                <div class="mt-6 flex space-x-4">
                    <DangerButton @click="deleteHotel(deleteHotelId)">
                        Deletar
                    </DangerButton>
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>
                </div>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>
