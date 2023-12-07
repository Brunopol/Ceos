<x-app-layout>

    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulo Controle De Acesso') }}
        </h2>
    </x-slot>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    

                    <button
                        class="self-start bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 mb-4"
                        type="button" onclick="toggleModal('modal-id-add')">
                        Novo
                    </button>


                    <table id="myTable" class="table table-striped nowrap cell-border hover stripe" style="width:100%">
                        <thead>
                            <tr>
                                <th>DATA</th>
                                <th>NOME PESSOA</th>
                                <th>NOME CHAVE</th>
                                <th>HORA ENTRADA</th>
                                <th>HORA SAÍDA</th>
                                <th>ACOES</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>


                    <!-- Modal Add chave -->
                    <div class="fixed z-50 inset-0 flex items-center justify-center overflow-auto bg-black bg-opacity-50 hidden"
                        id="modal-id-add">
                        <div class="relative w-3/5 my-6 mx-auto">
                            <div
                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">

                                <div class="flex items-start justify-between p-5 border-b border-slate-200 rounded-t">
                                    <h3 class="text-3xl font-semibold" id="modalTitle">
                                        EXCLUIR ACESSO:
                                    </h3>

                                    <input type="text" id="nomeAcesso" readonly
                                        class="bg-gray-200 border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">


                                    <button class="text-slate-600 hover:text-slate-800 focus:outline-none"
                                        type="button" onclick="toggleModal('modal-id-add')">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                </div>


                                <form id="formSolicitarDeletagem" class="p-4">

                                    <input type="text" name="id" id="idAcesso" class="hidden">

                                    <label for="motivo">MOTIVO PARA EXCLUSÃO</label>

                                    <div class="mb-4">
                                        <textarea name="motivo" id="motivo" class="w-full px-3 py-2 border rounded-md"></textarea>
                                    </div>

                                    <div class="flex justify-end mt-3">
                                        <button id=""
                                            class="bg-red-500 text-white font-bold text-sm py-2 px-4 rounded shadow hover:shadow-md transition duration-300"
                                            onclick="solicitarDeletagem(event, '{{ url('') }}')">DELETAR</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>


<script type="module">
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "chaves",
            columnDefs: [{
                    className: "align-left",
                    "targets": 0,
                    render: function(data) {
                        return new Date(data).toLocaleDateString();
                    }
                 },

            ],
            columns: [{
                    data: 'created_at',
                    orderable: true
                },
                {
                    data: 'nomePessoa',
                    orderable: true
                },
                {
                    data: 'nomeChave',
                    orderable: true
                },
                {
                    data: 'horaEntrada',
                    orderable: true
                },
                {
                    data: 'horaSaida.saida',
                    orderable: true,
                   
                },
                {
                    data: 'actions',
                    orderable: false,
                    render: function(data, type, row) {


                        return `
                            <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                onclick="mostrarAcesso('')">
                               EDITAR
                            </button>

                            <button class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                onclick="solicitarDeletagemButton('', '')">
                               DELETAR
                            </button>
                            
                        `;
                    }
                },

            ],
            order: [

                [0, 'asc']
            ],

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

<script src="{{ asset('javascript/chaves.js') }}"></script>
