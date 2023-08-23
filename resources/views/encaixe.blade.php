<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulo Encaixe') }}
        </h2>
    </x-slot>

    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div id="loadingSpinner" class="text-center my-4 hidden">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    
                    <button
                        class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button"
                        onclick="toggleModal('modal-id-add', $(this).data('url'), $(this).data('referencia'))">
                        Novo 
                    </button>

                    <table id="myTable" class="table table-striped nowrap cell-border hover stripe"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ref</th>
                                <th>editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($encaixes as $encaixe)
                                <tr>
                                    <td>{{ $encaixe->referencia }}</td>
                                    <td>
                                        <button
                                            class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button" data-url="{{ route('encaixes.show', $encaixe->id) }}"
                                            data-referencia="{{ $encaixe->referencia }}"
                                            data-date="{{ $encaixe->created_at }}"
                                            onclick="toggleModal('modal-id', $(this).data('url'), $(this).data('referencia'), $(this).data('date'))">
                                            Mostrar
                                        </button>
                                        <button
                                            class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button"
                                            data-url="{{ route('encaixe.delete', $encaixe->id) }}"
                                            data-referencia="{{ $encaixe->referencia }}"
                                            onclick="deletarEncaixeConfirmar($(this).data('referencia'), $(this).data('url'))">
                                            Deletar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <!-- Model Adicionar Encaixe -->
                    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
                        id="modal-id-add">
                        <div class="relative w-2/5 h-1/3 my-6 mx-auto">
                            <div
                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full h-full bg-white outline-none focus:outline-none">

                                <div
                                    class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                                    <h3 class="text-3xl font-semibold">
                                        Adicionar Encaixe
                                    </h3>
                                </div>

                                <form id="formAddEncaixe">

                                    <div
                                        class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Referencia
                                        </label>
                                        <input type="text" id="referencia" name="referencia">
                                    </div>

                                    <!-- Footer -->
                                    <div id="errorMessage"
                                        class="hidden mt-1 bg-red-500 text-white p-1 rounded-b shadow-md items-center border-t border-solid border-slate-200">
                                        <span>Error, prencha corretamente todos os campos</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                                        <button
                                            class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button" onclick="closeModal('modal-id-add')">
                                            Fechar
                                        </button>
                                        <button
                                            class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            onclick="adicionarEncaixe(event, document.getElementById('referencia').value, '{{ url('') }}')">
                                            Salvar
                                        </button>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-add-backdrop"></div>


                    <!-- Model Para editar encaixe-->
                    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
                        id="modal-id">
                        <div class="relative w-3/7 h-1/2 my-6 mx-auto">
                            <!-- Content -->
                            <div
                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full h-full bg-white outline-none focus:outline-none">
                                <!-- Header -->
                                <div
                                    class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                                    <h3 class="text-3xl font-semibold" id="tituloEncaixeRef">
                                        Editar Encaixe
                                    </h3>
                                </div>
                                <!-- Body -->
                                <div class="flex flex-wrap justify-center items-center h-full" id="tabs-id">
                                    <div class="w-full">
                                        <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                                            <!-- Tab items -->
                                        </ul>
                                        <div
                                            class="relative flex flex-col min-w-0 break-words bg-white w-full h-full mb-6 shadow-lg rounded">
                                            <div class="px-4 py-5 flex-auto flex justify-center items-center">
                                                <div class="tab-content tab-space">
                                                    <!-- Tab content -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="module">
    $('document').ready(function() {
        $('#myTable').DataTable({
            fixedHeader: true,
            responsive: true,
            "lengthChange": true,
            "lengthMenu": [10, 25, 50, 75, 100],

            "language": {

                "decimal": "",
                "emptyTable": "Nenhum dado disponível na tabela",
                "info": "Mostrando _START_ até _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 até 0 de 0 entradas",
                "infoFiltered": "(filtrado de um total de _MAX_ entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Carregando...",
                "processing": "",
                "search": "Buscar:",
                "zeroRecords": "Nenhum registro correspondente encontrado",
                "paginate": {
                    "first": "Primeira",
                    "last": "Última",
                    "next": "Próxima",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": ativar para ordenar coluna de forma ascendente",
                    "sortDescending": ": ativar para ordenar coluna de forma descendente"
                }

            }

        });
    });
</script>

<script src="http://localhost/javascript/encaixe.js" type="text/javascript"></script>
