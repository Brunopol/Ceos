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
                                <th>ENTRADA</th>
                                <th>SAÍDA</th>
                                <th>NOME</th>
                                <th>RG/CPF</th>
                                <th>EMPRESA</th>
                                <th>PLACA</th>
                                <th>AÇÕES</th>
                                <th class="none">PESSOA RESPONSÁVEL</th>
                                <th class="none">SETOR RESPONSÁVEL</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>



                    <!-- Modal Adicionar Acesso -->
                    <div class="fixed z-50 inset-0 flex items-center justify-center overflow-auto bg-black bg-opacity-50 hidden"
                        id="modal-id-add-backdrop">
                        <div class="relative w-3/5 my-6 mx-auto">
                            <div
                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">

                                <div class="flex items-start justify-between p-5 border-b border-slate-200 rounded-t">
                                    <h3 class="text-3xl font-semibold" id="modalTitle">
                                        Adicionar Acesso
                                    </h3>
                                    <button class="text-slate-600 hover:text-slate-800 focus:outline-none"
                                        type="button" onclick="closeModal('modal-id-add')">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <form id="formAddAcesso" class="p-4">
                                    <div class="grid grid-cols-2 gap-4">

                                        <div class="mb-4">
                                            <input type="text" value="" id="id" class="hidden">

                                            <div class="mb-4">
                                                <label for="nome" class="block text-sm font-medium text-gray-700">
                                                    NOME
                                                </label>
                                                <input type="text" id="nome" name="nome" value=""
                                                    autocomplete="off" oninput="pegarAcessoNomes('{{ url('') }}')"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">

                                                <div id="divNomeAcessos"
                                                    class="rounded-md py-2 px-3 max-h-60 overflow-y-auto border border-gray-300">


                                                </div>

                                            </div>

                                        </div>

                                        <div class="grid grid-cols-2 gap-4">

                                            <div class="mb-4">
                                                <label for="rgCpf" class="block text-sm font-medium text-gray-700">
                                                    RG ou CPF
                                                </label>
                                                <input type="text" id="rgCpf" name="rgCpf"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                            </div>

                                            <div class="mb-4">
                                                <label for="transportadora"
                                                    class="block text-sm font-medium text-gray-700">
                                                    EMPRESA
                                                </label>
                                                <input type="text" id="transportadora" name="transportadora" list="empresasDatalist" oninput="buscarempresas('{{ url('') }}')"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400" autocomplete="off">
                                                <datalist id="empresasDatalist">
                                                   
                                                </datalist>
                                            </div>

                                            <div class="mb-4">
                                                <label for="setorResponsavel"
                                                    class="block text-sm font-medium text-gray-700">
                                                    SETOR RESPONSÁVEL
                                                </label>
                                                <input type="text" id="setorResponsavel" name="setorResponsavel" list="SetorResponsavelDataList" oninput="buscarsetores('{{ url('') }}')" onclick="buscarsetores('{{ url('') }}')"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400" autocomplete="off">
                                                    <datalist id="SetorResponsavelDataList">
                                                       
                                                    </datalist>
                                            </div>

                                            <div class="mb-4">
                                                <label for="pessoaResponsavel"
                                                    class="block text-sm font-medium text-gray-700">
                                                    PESSOA RESPONSÁVEL
                                                </label>
                                                <input type="text" id="pessoaResponsavel" name="pessoaResponsavel" list="PessoaResponsavelDataList" oninput="buscarpessoas('{{ url('') }}')" onclick="buscarpessoas('{{ url('') }}')"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                                    <datalist id="PessoaResponsavelDataList">
                                                       
                                                    </datalist>

                                            </div>

                                            <div class="mb-4 " id="placaDiv">
                                                <label for="placa" class="block text-sm font-medium text-gray-700">
                                                    PLACA
                                                </label>
                                                <input type="text" id="placa" name="placa"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                            </div>

                                            <div class="mb-4 " id="placaDiv">
                                                <label for="placa" class="block text-sm font-medium text-gray-700">
                                                    USUÁRIO
                                                </label>
                                                <input type="text" value="NÃO FUNC AINDA" readonly
                                                    class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                            </div>

                                            <div class="mb-4 " id="horaSaidaDiv">
                                                <label for="horaSaida" class="block text-sm font-medium text-gray-700">
                                                    HORA SAÍDA
                                                </label>
                                                <input type="time" id="horaSaida" name="horaSaida"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                            </div>

                                            <div class="mb-4 " id="horaEntradaDiv">
                                                <label for="horaEntrada"
                                                    class="block text-sm font-medium text-gray-700">
                                                    HORA ENTRADA
                                                </label>
                                                <input type="time" id="horaEntrada" name="horaEntrada"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                            </div>

                                            <!-- Error Message -->
                                            <div id="errorMessage"
                                                class="bg-red-500 text-white p-2 rounded-md mb-4 hidden">
                                                <span>Error, preencha corretamente todos os campos</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->


                                    <div class="p-5 border-t border-slate-200 rounded-b">
                                        <div class="grid grid-cols-1 md:grid-cols-1 md:grid-rows-3 md:gap-3">
                                            <label class="inline-flex items-center">
                                                <input id="cbCarro" type="checkbox" onclick="checkBoxToggleCarro()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">PLACA</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input id="cbHoraSaida" type="checkbox"
                                                    onclick="checkBoxToggleHoraSaida()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">HORÁRIO SAÍDA</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input id="cbHoraEntrada" type="checkbox"
                                                    onclick="checkBoxToggleHoraEntrada()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">HORÁRIO ENTRADA</span>
                                            </label>
                                        </div>
                                        <div class="flex justify-end mt-3">
                                            <button
                                                class="text-red-500 font-bold text-sm mr-3 focus:outline-none hover:text-red-700"
                                                type="button" onclick="closeModal('modal-id-add')">FECHAR</button>
                                            <button id="adicionarButton"
                                                class="hidden bg-emerald-500 text-white font-bold text-sm py-2 px-4 rounded shadow hover:shadow-md transition duration-300"
                                                onclick="adicionarAcesso(event, '{{ url('') }}')">ADICIONAR</button>

                                            <button id="atualizarButton"
                                                class="hidden bg-emerald-500 text-white font-bold text-sm py-2 px-4 rounded shadow hover:shadow-md transition duration-300"
                                                onclick="atualizarAcesso(event, '{{ url('') }}')">ATUALIZAR</button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>





                    <!-- Modal Registrar Saida -->
                    <div class="fixed z-50 inset-0 flex items-center justify-center overflow-auto bg-black bg-opacity-50 hidden"
                        id="modal-id-reg">
                        <div class="relative w-3/5 my-6 mx-auto">
                            <div
                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">

                                <div class="flex items-start justify-between p-5 border-b border-slate-200 rounded-t">
                                    <h3 class="text-3xl font-semibold" id="modalTitle">
                                        Registrar Saída
                                    </h3>
                                    <button class="text-slate-600 hover:text-slate-800 focus:outline-none"
                                        type="button" onclick="closeModal('modal-id-reg')">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <form id="formRegistrarSaida" class="p-4">

                                    <input type="text" value="" id="idReg" class="hidden">

                                    <div class="mb-4" id="">
                                        <label for="horaSaida" class="block text-sm font-medium text-gray-700">
                                            DATA SAÍDA
                                        </label>
                                        <input type="date" id="dataSaidaReg" name="dataSaida"
                                            class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                    </div>

                                    <div class="mb-4" id="">
                                        <label for="horaSaida" class="block text-sm font-medium text-gray-700">
                                            HORA SAÍDA
                                        </label>
                                        <input type="time" id="horaSaidaReg" name="horaSaida"
                                            class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                    </div>

                                    <div class="flex justify-end mt-3">
                                        <button id=""
                                            class=" bg-emerald-500 text-white font-bold text-sm py-2 px-4 rounded shadow hover:shadow-md transition duration-300"
                                            onclick="registrarSaidaAcesso(event, '{{ url('') }}')">REGISTRAR</button>

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
            ajax: "controleDeAcesso",
            columnDefs: [{
                    className: "align-left",
                    "targets": 0,
                    render: function(data) {
                        return new Date(data).toLocaleDateString();
                    }
                },

                {
                    "width": "20%",
                    "targets": 3
                },
                {
                    "width": "20%",
                    "targets": 4
                },
                {
                    "width": "20%",
                    "targets": 5
                },
                {
                    "width": "20%",
                    "targets": 6
                },

            ],
            columns: [{
                    data: 'created_at',
                    orderable: true
                },
                {
                    data: 'horaEntrada',
                    orderable: true
                },
                {
                    data: 'horaSaida.saida',
                    orderable: true,
                    render: function(data, type, row) {


                        if (data == null) {
                            return `<button onclick="registrarHoraSaida(${row.horaSaida.id})" class="bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                     Registrar
                                    </button>`
                        }

                        var createdDate = new Date(row.created_at);
                        var formattedCreatedDate =
                            `${createdDate.getDate()}/${createdDate.getMonth() + 1}/${createdDate.getFullYear()}`;

                        console.log(formattedCreatedDate);
                        console.log(row.dataSaida);

                        if (row.dataSaida != formattedCreatedDate && row.dataSaida != null) {
                            return `${row.dataSaida} às ${data}`;
                        }

                        return data
                    }
                },

                {
                    data: 'nome',
                    name: 'nome'
                },
                {
                    data: 'rgCpf',
                    orderable: false
                },
                {
                    data: 'empresa',
                    orderable: false
                },
                {
                    data: 'placa',
                    orderable: false
                },
                {
                    data: 'actions',
                    orderable: false,
                    render: function(data, type, row) {

                        var actionsData = data

                        return `
                            <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                onclick="mostrarAcesso('${ actionsData.url_show }')">
                               EDITAR
                            </button>
                            
                        `;
                    }
                },
                {
                    data: 'pessoaResponsavel',
                    orderable: false
                },
                {
                    data: 'setorResponsavel',
                    orderable: false
                }

            ],
            order: [

                [2, 'asc']
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

<script src="{{ asset('javascript/controleDeAcesso.js') }}"></script>
