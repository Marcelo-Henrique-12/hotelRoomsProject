<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref,watchEffect  } from 'vue';
import Modal from '@/Components/Modal.vue';


const props = defineProps({
    rooms: Object,
    success: String,
});
const form = useForm({})

const showConfirmDeleteModal = ref(false)
const deleteRoomId = ref(null);
// Abrir o modal para confirmar a exclusão
const confirmDelete = (roomId)=>{
    showConfirmDeleteModal.value = true;
    deleteRoomId.value = roomId;

}

// função para fechar o Modal
const closeModal = ()=>{
    showConfirmDeleteModal.value = false;
}

// Função que irá deletar o quarto se confirmado o Modal
const deleteRoom = (deleteRoomId) => {
    if (deleteRoomId) {
        form.delete(route('rooms.destroy', deleteRoomId), {
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
</script>

<template>

    <Head title="Rooms" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Quartos Cadastrados</h2>
        </template>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <Link :href="route('rooms.create')"
                        class="text-sm text-white-600 hover:text-white-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <PrimaryButton class="ms-4 py-4 px-6">

                        Cadastrar Quarto

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

        <!-- Tabela de quartos -->
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
                                                    Descrição
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Hotel
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Ações
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <!-- Listagem dos quartos cadastrados -->
                                            <template v-for="room in rooms" :key="room.id">
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ room.name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ room.description }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ room.hotel.name }}
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                        <!-- Ações com o Quarto -->
                                                        <div class="flex justify-center">
                                                        <Link :href="route('rooms.edit', room.id)"
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                        Editar
                                                        </Link>
                                                        <span class="mx-2">|</span>

                                                        <Link :href="route('rooms.show', room.id)"
                                                            class="text-green-600 hover:text-green-900">
                                                        Visualizar
                                                        </Link>
                                                        <span class="mx-2">|</span>

                                                         <!-- Abre um modal para confirmar a exclusão -->
                                                            <button @click="() => confirmDelete(room.id)"
                                                                class="text-red-600 hover:text-red-900">
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
         <!-- Modal de confirmação de exclusão de um quarto-->
         <Modal :show="showConfirmDeleteModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-slate-800">
                    Ao deletar este quarto não será possível recuperá-lo. Tem certeza que deseja continuar?
                </h2>
                <div class="mt-6 flex space-x-4">
                    <DangerButton @click="deleteRoom(deleteRoomId)">
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
