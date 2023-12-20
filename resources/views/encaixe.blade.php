<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Módulo Encaixe') }}

        </h2>
    </x-slot>

    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>

    <div id="loadingOverlay"
        class="fixed left-0 top-0 z-50 flex hidden h-full w-full items-center justify-center bg-black bg-opacity-25">
        <div class="animate-pulse rounded-lg bg-white p-4 shadow-lg">
            <div class="flex items-center space-x-2">
                <svg class="h-6 w-6 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="text-lg font-semibold text-blue-600">Carregando...</span>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col">

                        @can('encaixe')
                            <button
                                class="mb-4 self-start rounded-md bg-blue-500 px-4 py-2 font-semibold text-white transition duration-300 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                type="button"
                                onclick="toggleModal('modal-id-add', $(this).data('url'), $(this).data('referencia'))">
                                Novo
                            </button>
                        @endcan

                        <table id="myTable" class="table-striped nowrap cell-border hover stripe table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>REFERENCIA</th>
                                    <th>TECIDOS</th>
                                    <th>CRIADO EM</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <!-- Model Adicionar Encaixe -->
                    <div class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto overflow-x-hidden outline-none focus:outline-none"
                        id="modal-id-add">
                        <div class="relative mx-auto my-6 h-1/3 w-2/5">
                            <div
                                class="relative flex h-full w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">

                                <div
                                    class="flex items-start justify-between rounded-t border-b border-solid border-slate-200 p-5">
                                    <h3 class="text-3xl font-semibold">
                                        Adicionar Encaixe
                                    </h3>
                                </div>

                                <form id="formAddEncaixe" class="rounded-lg bg-white p-4 shadow-md">

                                    <div class="mb-4">
                                        <label for="referencia" class="block text-sm font-medium text-gray-700">
                                            Referencia
                                        </label>
                                        <input type="text" id="referencia" name="referencia"
                                            class="w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                    </div>

                                    <!-- Error Message -->
                                    <div id="errorMessage" class="mb-4 hidden rounded-md bg-red-500 p-2 text-white">
                                        <span>Error, preencha corretamente todos os campos</span>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="flex justify-end space-x-3">
                                        <button
                                            class="text-sm font-bold text-red-500 outline-none transition-colors duration-300 hover:text-red-700"
                                            type="button" onclick="closeModal('modal-id-add')">
                                            Fechar
                                        </button>
                                        <button
                                            class="rounded bg-emerald-500 px-4 py-2 text-sm font-bold text-white shadow transition duration-300 hover:shadow-md"
                                            onclick="adicionarEncaixe(event, document.getElementById('referencia').value, '{{ url('') }}')">
                                            Salvar
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="fixed inset-0 z-40 hidden bg-black opacity-25" id="modal-id-add-backdrop"></div>

                    <!-- Model Para editar encaixe-->
                    <div class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-25"
                        id="modal-id-backdrop"></div>
                    <div class="fixed inset-0 z-50 flex hidden items-center justify-center overflow-y-auto overflow-x-hidden outline-none focus:outline-none"
                        id="modal-id">
                        <div class="relative mx-auto my-6 h-3/5 w-3/5">
                            <button
                                class="background-transparent absolute z-10 px-6 py-2 text-3xl font-bold uppercase text-red-500 outline-none focus:outline-none"
                                style="top: -20px; right: -35px;" type="button" onclick="closeModal('modal-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-9 w-9">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                            </button>

                            <div
                                class="relative flex h-full w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">
                                <div
                                    class="flex items-center justify-between rounded-t border-b border-solid border-gray-300 bg-gray-800 p-4">
                                    <div class="flex items-center gap-4">
                                        <h3 class="text-1xl font-bold" id="tituloEncaixeRef">
                                            <input id="referenceBox" class="inline-block rounded-md text-center"
                                                readonly>
                                        </h3>
                                        <h3 class="text-1xl font-bold" id="tituloEncaixeUser">
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
                                <div class="flex h-full flex-wrap justify-center" id="tabs-id">
                                    <div class="w-full">
                                        <ul class="mb-0 flex list-none flex-row flex-wrap bg-slate-400 pb-4 pt-3">
                                            <!-- Tab items -->
                                        </ul>
                                        <div
                                            class="relative mb-6 flex h-full w-full min-w-0 flex-col break-words rounded bg-white shadow-lg">
                                            <div class="flex flex-auto items-center justify-center px-4 py-5">
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

<script type="module" src="{{ asset('javascript/encaixe1Table.js') }}"></script>

<script src="{{ asset('javascript/encaixe1.js') }}" type="text/javascript"></script>
