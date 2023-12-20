<x-app-layout>

    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulo Controle De Frotas') }}
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
                                                <input type="text" id="transportadora" name="transportadora"
                                                    list="empresasDatalist"
                                                    oninput="buscarempresas('{{ url('') }}')"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                                                    autocomplete="off">
                                                <datalist id="empresasDatalist">

                                                </datalist>
                                            </div>

                                            <div class="mb-4">
                                                <label for="setorResponsavel"
                                                    class="block text-sm font-medium text-gray-700">
                                                    SETOR RESPONSÁVEL
                                                </label>
                                                <input type="text" id="setorResponsavel" name="setorResponsavel"
                                                    list="SetorResponsavelDataList"
                                                    oninput="buscarsetores('{{ url('') }}')"
                                                    onclick="buscarsetores('{{ url('') }}')"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                                                    autocomplete="off">
                                                <datalist id="SetorResponsavelDataList">

                                                </datalist>
                                            </div>

                                            <div class="mb-4">
                                                <label for="pessoaResponsavel"
                                                    class="block text-sm font-medium text-gray-700">
                                                    PESSOA RESPONSÁVEL
                                                </label>
                                                <input type="text" id="pessoaResponsavel" name="pessoaResponsavel"
                                                    list="PessoaResponsavelDataList"
                                                    oninput="buscarpessoas('{{ url('') }}')"
                                                    onclick="buscarpessoas('{{ url('') }}')"
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

                                            <div class="mb-4 " id="">
                                                <label for="placa" class="block text-sm font-medium text-gray-700">
                                                    USUÁRIO
                                                </label>
                                                <input type="text" value="Antes do dia 21/11/23" id="usuario"
                                                    readonly
                                                    class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                            </div>

                                            <div class="mb-4 " id="horaEntradaDiv">
                                                <label for="horaEntrada"
                                                    class="block text-sm font-medium text-gray-700">
                                                    HORA ENTRADA
                                                </label>
                                                <input type="time" id="horaEntrada" name="horaEntrada"
                                                    class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                            </div>

                                            <div class="mb-4 " id="horaSaidaDiv">
                                                <label for="horaSaida"
                                                    class="block text-sm font-medium text-gray-700">
                                                    HORA SAÍDA
                                                </label>
                                                <input type="time" id="horaSaida" name="horaSaida"
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
                                                <input id="cbHoraEntrada" type="checkbox"
                                                    onclick="checkBoxToggleHoraEntrada()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">HORÁRIO ENTRADA</span>
                                            </label>

                                            <label class="inline-flex items-center">
                                                <input id="cbHoraSaida" type="checkbox"
                                                    onclick="checkBoxToggleHoraSaida()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">HORÁRIO SAÍDA</span>
                                            </label>

                                            <label class="inline-flex items-center">
                                                <input id="cbRgCpf" type="checkbox" onclick="checkBoxToggleRgCpf()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">MOSTRAR RG/CPF</span>
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

                    <!-- Modal Solicitar exclusao -->
                    <div class="fixed z-50 inset-0 flex items-center justify-center overflow-auto bg-black bg-opacity-50 hidden"
                        id="modal-id-delete">
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
                                        type="button" onclick="closeModal('modal-id-delete')">
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

    @if (auth()->check())
        <div class="hidden">
            <input id="currentLogedInUser" value="{{ auth()->user()->name }}">
        </div>
    @endif
</x-app-layout>

<script type="module" src="{{ asset('javascript/cfTable.js') }}">
    
<script src="{{ asset('javascript/controleDeAcesso1.js') }}"></script>
