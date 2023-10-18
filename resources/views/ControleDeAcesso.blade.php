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
                        type="button"
                        onclick="toggleModal('modal-id-add', $(this).data('url'), $(this).data('referencia'))">
                        Novo
                    </button>


                    <table id="myTable" class="table table-striped nowrap cell-border hover stripe" style="width:100%">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>RG/CPF</th>
                                <th>HORA ENTRADA</th>
                                <th>HORA SAÍDA</th>
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
                                    <h3 class="text-3xl font-semibold">
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
                                    <div class="grid grid-cols-4 gap-4">
                                        <div class="mb-4">
                                            <label for="nome" class="block text-sm font-medium text-gray-700">
                                                NOME
                                            </label>
                                            <input type="text" id="nome" name="nome"
                                                class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                        <div class="mb-4">
                                            <label for="rgCpf" class="block text-sm font-medium text-gray-700">
                                                RG ou CPF
                                            </label>
                                            <input type="text" id="rgCpf" name="rgCpf"
                                                class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                        <div class="mb-4">
                                            <label for="transportadora" class="block text-sm font-medium text-gray-700">
                                                TRANSPORTADORA
                                            </label>
                                            <input type="text" id="transportadora" name="transportadora"
                                                class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                        <div class="mb-4">
                                            <label for="setorResponsavelPessoa"
                                                class="block text-sm font-medium text-gray-700">
                                                SETOR/PESSOA RESPONSÁVEL
                                            </label>
                                            <input type="text" id="setorResponsavelPessoa"
                                                name="setorResponsavelPessoa"
                                                class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                        <div class="mb-4 hidden" id="placaDiv">
                                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                                PLACA
                                            </label>
                                            <input type="text" id="placa" name="placa"
                                                class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                        <div class="mb-4 hidden" id="horaSaidaDiv">
                                            <label for="horaSaida" class="block text-sm font-medium text-gray-700">
                                                HORA SAÍDA
                                            </label>
                                            <input type="time" id="horaSaida" name="horaSaida"
                                                class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                        <div class="mb-4 hidden" id="horaEntradaDiv">
                                            <label for="horaEntrada" class="block text-sm font-medium text-gray-700">
                                                HORA ENTRADA
                                            </label>
                                            <input type="time" id="horaEntrada" name="horaEntrada"
                                                class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        </div>

                                        <!-- Error Message -->
                                        <div id="errorMessage" class="bg-red-500 text-white p-2 rounded-md mb-4 hidden">
                                            <span>Error, preencha corretamente todos os campos</span>
                                        </div>
                                    </div>

                                    <!-- Buttons -->


                                    <div class="p-5 border-t border-slate-200 rounded-b">
                                        <div class="grid grid-cols-1 md:grid-cols-1 md:grid-rows-3 md:gap-3">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" onclick="toggleCarro()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">CARRO</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" onclick="toggleHoraSaida()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">ALTERAR HORÁRIO SAÍDA</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" onclick="toggleHoraEntrada()"
                                                    class="form-checkbox h-5 w-5 text-emerald-500">
                                                <span class="ml-2 text-gray-800">ALTERAR HORÁRIO ENTRADA</span>
                                            </label>
                                        </div>
                                        <div class="flex justify-end mt-3">
                                            <button
                                                class="text-red-500 font-bold text-sm mr-3 focus:outline-none hover:text-red-700"
                                                type="button" onclick="closeModal('modal-id-add')">Fechar</button>
                                            <button
                                                class="bg-emerald-500 text-white font-bold text-sm py-2 px-4 rounded shadow hover:shadow-md transition duration-300"
                                                onclick="adicionarAcesso(event, '{{ url('') }}')">Salvar</button>
                                        </div>
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
            processing: true,
            serverSide: true,
            ajax: "controleDeAcesso",
            
            columns: [{
                    data: 'nome',
                    name: 'nome'
                },
                {
                    data: 'rgCpf',
                    orderable: true
                },
                {
                    data: 'horaEntrada',
                    orderable: true
                },
                {
                    data: 'horaSaida',
                    orderable: true
                }
            ]
        });

    });
</script>


<script src="http://localhost/javascript/controleDeAcesso.js" type="text/javascript"></script>
