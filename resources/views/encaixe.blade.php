<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulo Encaixe') }}

        </h2>
    </x-slot>

    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>
    

    <div id="loadingOverlay" class="hidden fixed top-0 left-0 w-full h-full z-50 flex items-center justify-center bg-black bg-opacity-25">
        <div class="bg-white p-4 rounded-lg shadow-lg animate-pulse">
          <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="text-blue-600 text-lg font-semibold">Carregando...</span>
          </div>
        </div>
      </div>
      
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col">
                        <button
                            class="self-start bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 mb-4"
                            type="button"
                            onclick="toggleModal('modal-id-add', $(this).data('url'), $(this).data('referencia'))">
                            Novo
                        </button>


                        <table id="myTable" class="table table-striped nowrap cell-border hover stripe"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>referencia</th>
                                    <th>tecidos</th>
                                    <th>created_at</th>
                                    <th>actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

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

                                <form id="formAddEncaixe" class="bg-white p-4 rounded-lg shadow-md">

                                    <div class="mb-4">
                                        <label for="referencia" class="block text-sm font-medium text-gray-700">
                                            Referencia
                                        </label>
                                        <input type="text" id="referencia" name="referencia"
                                            class="w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                    </div>

                                    <!-- Error Message -->
                                    <div id="errorMessage" class="bg-red-500 text-white p-2 rounded-md mb-4 hidden">
                                        <span>Error, preencha corretamente todos os campos</span>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="flex justify-end space-x-3">
                                        <button
                                            class="text-red-500 font-bold text-sm outline-none hover:text-red-700 transition-colors duration-300"
                                            type="button" onclick="closeModal('modal-id-add')">
                                            Fechar
                                        </button>
                                        <button
                                            class="bg-emerald-500 text-white font-bold text-sm py-2 px-4 rounded shadow hover:shadow-md transition duration-300"
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
                    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-25 hidden"
                        id="modal-id-backdrop"></div>
                    <div class="fixed inset-0 z-50 flex justify-center items-center hidden overflow-x-hidden overflow-y-auto outline-none focus:outline-none"
                        id="modal-id">
                        <div class="w-3/5 h-3/5 my-6 mx-auto relative">
                            <button
                                class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-3xl outline-none focus:outline-none absolute z-10"
                                style="top: -20px; right: -35px;" type="button" onclick="closeModal('modal-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-9 h-9">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                            </button>



                            <div
                                class="bg-white w-full h-full flex flex-col rounded-lg shadow-lg relative outline-none focus:outline-none border-0">
                                <div
                                    class="bg-gray-800 flex items-center justify-between p-4 rounded-t border-b border-solid border-gray-300">
                                    <div class="flex items-center gap-4">
                                        <h3 class="text-1xl font-bold " id="tituloEncaixeRef">
                                            <input id="referenceBox" class="inline-block rounded-md text-center"
                                                readonly>
                                        </h3>
                                        <h3 class="text-1xl font-bold " id="tituloEncaixeUser">
                                            <input id="encaixeUserBox" class="inline-block rounded-md text-center"
                                                readonly>
                                        </h3>
                                    </div>
                                    <div class="flex items-center">
                                        <h3 class="text-2xl font-bold">
                                            <input id="dateBox" class="inline-block rounded-md text-center" readonly>
                                        </h3>
                                    </div>
                                </div>
                                <div class="flex flex-wrap justify-center h-full" id="tabs-id">
                                    <div class="w-full">
                                        <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row bg-slate-400">
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




                </div>
            </div>
        </div>
    </div>

    
        @can('encaixe')
            <input value="1" class="hidden" id="encaixePermission">
        @else
            <input value="0" class="hidden" id="encaixePermission">
        @endcan
    

</x-app-layout>


<script type="module">
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "encaixe",
            columnDefs: [{
                className: "align-left",
                "targets": 2,
                render: function(data) {
                    return new Date(data).toLocaleString();
                }
            }, ],

            columns: [{
                    data: 'referencia',
                    name: 'referencia'
                },
                {
                    data: 'tecidos',
                    orderable: false,

                    render: function(data, type, row) {

                        function isObject(variable) {
                            return typeof variable === 'object' && variable !== null;
                        }

                        if (isObject(data)) {
                            data = Object.values(data);
                        }

                        data = data.map(element => {
                            if (typeof element === 'string') {
                                element = element.replace(/^\s+|\s+$/g,
                                    '');
                            }
                            return element;
                        });

                        return data.join(', ');

                    }

                },
                {
                    data: 'created_at',
                    orderable: true
                },
                {
                    data: 'actions',
                    orderable: false,
                    render: function(data, type, row) {

                        var actionsData = data

                        console.log(data);

                        if (data.canEdit) {
                            return `
                            <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button" data-url="${actionsData.url_show}" data-referencia="${actionsData.referencia}"
                                data-date="${actionsData.date}"
                                onclick="toggleModal('modal-id', '${actionsData.url_show}', '${actionsData.referencia}', '${actionsData.date}')">
                                Mostrar
                            </button>
                            <button class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button" data-url="${actionsData.url_delete}" data-referencia="${actionsData.referencia}"
                                onclick="deletarEncaixeConfirmar('${actionsData.referencia}', '${actionsData.url_delete}')">
                                Deletar
                            </button>
                        `;
                        } else {
                            return `<button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button" data-url="${actionsData.url_show}" data-referencia="${actionsData.referencia}"
                                data-date="${actionsData.date}"
                                onclick="toggleModal('modal-id', '${actionsData.url_show}', '${actionsData.referencia}', '${actionsData.date}')">
                                Mostrar
                            </button>`;
                        }

                        
                    }
                }

            ]
        });

    });
</script>




<script src="http://localhost/javascript/encaixe.js" type="text/javascript"></script>
