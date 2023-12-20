<x-app-layout>

    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Módulo Chaves') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <button
                        class="mb-4 self-start rounded-md bg-blue-500 px-4 py-2 font-semibold text-white transition duration-300 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        type="button" onclick="toggleModal('modal-id-add')">
                        Novo
                    </button>

                    <table id="myTable" class="table-striped nowrap cell-border hover stripe table" style="width:100%">
                        <thead>
                            <tr>
                                <th>DATA</th>
                                <th>ENTRADA</th>
                                <th>SAÍDA</th>
                                <th>CHAVE</th>
                                <th>PESSOA</th>
                                <th>ACOES</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <!-- Modal Add chave -->
                    <div class="fixed inset-0 z-50 flex hidden items-center justify-center overflow-auto bg-black bg-opacity-50"
                        id="modal-id-add">
                        <div class="relative mx-auto my-6 w-3/5">
                            <div
                                class="relative flex w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">

                                <div class="flex items-start justify-between rounded-t border-b border-slate-200 p-5">
                                    <h3 class="text-3xl font-semibold" id="modalTitleRg">
                                        REGISTRAR CHAVE
                                    </h3>

                                    <button class="text-slate-600 hover:text-slate-800 focus:outline-none"
                                        type="button" onclick="toggleModal('modal-id-add')">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                </div>

                                <form id="formAddChave" class="p-4">

                                    <input type="text" name="id" id="idAcesso" class="hidden">

                                    <div class="grid grid-cols-2 gap-4">

                                        <div class="mb-4">
                                            <label for="motivo">CHAVE</label>
                                            <input type="text" id="nomeChavei" name="nomeChave" autocomplete="off"
                                                list="nomeChaveDatalist" oninput="mostrarSugestoesChave()"
                                                class="w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">

                                            <datalist id="nomeChaveDatalist">

                                            </datalist>
                                        </div>

                                        <div class="mb-4">
                                            <label for="motivo">NOME</label>
                                            <input type="text" id="nomePessoai" name="nomePessoa" autocomplete="off"
                                                onclick="buscarPessoas()" oninput="buscarPessoas()"
                                                list="nomePessoaDatalist"
                                                class="w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">

                                            <datalist id="nomePessoaDatalist">

                                            </datalist>
                                        </div>

                                        <div class="mb-4" id="horaEntradaDiv">
                                            <label for="horaEntrada" class="block text-sm font-medium text-gray-700">
                                                HORA ENTRADA
                                            </label>
                                            <input type="time" id="horaEntrada" name="horaEntrada"
                                                class="w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                        <div class="mb-4" id="horaSaidaDiv">
                                            <label for="horaSaida" class="block text-sm font-medium text-gray-700">
                                                HORA SAÍDA
                                            </label>
                                            <input type="time" id="horaSaida" name="horaSaida"
                                                class="w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                    </div>

                                    <div class="grid grid-cols-1">

                                        <label class="inline-flex items-center p-1">
                                            <input id="cbHoraEntrada" type="checkbox"
                                                onclick="checkBoxToggleHoraEntrada()"
                                                class="form-checkbox h-5 w-5 text-emerald-500">
                                            <span class="ml-2 text-gray-800">HORÁRIO ENTRADA</span>
                                        </label>

                                        <label class="inline-flex items-center p-1">
                                            <input id="cbHoraSaida" type="checkbox" onclick="checkBoxToggleHoraSaida()"
                                                class="form-checkbox h-5 w-5 text-emerald-500">
                                            <span class="ml-2 text-gray-800">HORÁRIO SAÍDA</span>
                                        </label>

                                        <div class="mt-3 flex justify-end">
                                            <button id="btnRegistrar"
                                                class="hidden rounded bg-green-500 px-4 py-2 text-sm font-bold text-white shadow transition duration-300 hover:shadow-md"
                                                onclick="registrarChave(event, '{{ url('') }}')">REGISTRAR</button>

                                            <button id="btnAtualizar"
                                                class="hidden rounded bg-green-500 px-4 py-2 text-sm font-bold text-white shadow transition duration-300 hover:shadow-md"
                                                onclick="atualizarChave(event, '{{ url('') }}')">ATUALIZAR</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- Modal Registrar Saida -->
                    <div class="fixed inset-0 z-50 flex hidden items-center justify-center overflow-auto bg-black bg-opacity-50"
                        id="modal-id-reg">
                        <div class="relative mx-auto my-6 w-3/5">
                            <div
                                class="relative flex w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">

                                <div class="flex items-start justify-between rounded-t border-b border-slate-200 p-5">
                                    <h3 class="text-3xl font-semibold" id="modalTitle">
                                        Registrar Saída Chave
                                    </h3>
                                    <button class="text-slate-600 hover:text-slate-800 focus:outline-none"
                                        type="button" onclick="toggleModal('modal-id-reg')">
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
                                        <input type="date" id="dataSaidaRegistarSaida" name="dataSaida"
                                            class="w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                    </div>

                                    <div class="mb-4" id="">
                                        <label for="horaSaida" class="block text-sm font-medium text-gray-700">
                                            HORA SAÍDA
                                        </label>
                                        <input type="time" id="horaSaidaRegistraSaida" name="horaSaida"
                                            class="w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                    </div>

                                    <div class="mt-3 flex justify-end">
                                        <button id=""
                                            class="rounded bg-emerald-500 px-4 py-2 text-sm font-bold text-white shadow transition duration-300 hover:shadow-md"
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

<script type="module" src="{{ asset('javascript/chavesTable.js') }}"></script>

<script src="{{ asset('javascript/chaves.js') }}"></script>
