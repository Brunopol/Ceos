<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Módulo Usuários') }}
        </h2>

        <div id="successMessage" class="mt-4 hidden rounded-md bg-green-500 p-4 text-white shadow-md">
            <svg class="mr-2 inline-block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Usuário alterado com sucesso</span>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Users Table -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h1 class="mb-4 text-2xl font-bold">Usuários</h1>

                    <table id="myTable" class="table-striped nowrap cell-border hover stripe table"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>nome</th>
                                <th>sobrenome</th>
                                <th>email</th>
                                <th>celular</th>
                                <th>editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <button
                                            class="mb-1 mr-1 rounded bg-blue-500 px-4 py-2 text-xs font-bold uppercase text-white shadow outline-none transition-all duration-150 ease-linear hover:shadow-lg focus:outline-none active:bg-pink-600"
                                            type="button" data-url="{{ route('users.show', $user->id) }}"
                                            onclick="toggleModal('modal-id', $(this).data('url'))">
                                            editar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="p-4"></div>

            <!-- Solicitacoes Table -->
            <div class="max-w-xl overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="flex flex-col items-center p-6 text-gray-900">
                    <h1 class="mb-4 text-2xl font-bold">Exclusões de Acessos</h1>
                    <div class="">
                        <div class="mx-auto max-w-5xl overflow-hidden">
                            <table id="tableSolicitacoes"
                                class="table-striped nowrap cell-border hover stripe display compact table w-full">
                                <thead>
                                    <tr>
                                        <th>Criado em</th>
                                        <th>Usuário</th>
                                        <th>Motivo</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Model -->
            <div class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto overflow-x-hidden outline-none focus:outline-none"
                id="modal-id">
                <div class="relative mx-auto my-6 w-auto max-w-3xl">
                    <!-- Content -->
                    <form id="updateUserForm">
                        @csrf <!-- Laravel CSRF token -->
                        <div
                            class="relative flex w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">
                            <!-- Header -->
                            <div
                                class="flex items-start justify-between rounded-t border-b border-solid border-slate-200 p-5">
                                <h3 class="text-3xl font-semibold">
                                    Editar Usuário
                                </h3>
                            </div>
                            <!-- Body -->
                            <div class="relative grid flex-auto grid-cols-2 gap-4 p-6">
                                <!-- Form inputs -->
                                <input type="hidden" id="userId">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Name">
                                </div>
                                <div>
                                    <label for="last_name"
                                        class="block text-sm font-medium text-gray-700">Sobrenome</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control"
                                        placeholder="Last Name">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Email">
                                </div>
                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700">Celular</label>
                                    <input type="tel" id="phone" name="phone" class="form-control"
                                        placeholder="Phone">
                                </div>
                                <div>
                                    <label for="ramal" class="block text-sm font-medium text-gray-700">Ramal</label>
                                    <input type="text" id="ramal" name="ramal" class="form-control"
                                        placeholder="Ramal">
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Nova
                                        Senha</label>
                                    <input type="text" id="password" name="password" class="form-control">
                                </div>
                                <!-- Checkboxes -->
                                <div class="col-span-2">
                                    <label class="block pb-4 text-sm font-medium text-gray-700">Permissões</label>

                                    <div class="flex items-center space-x-2 border-b-2 pb-1">
                                        <input type="checkbox" id="usersCheckbox" name="permissions[]"
                                            class="form-checkbox" value="users">
                                        <label for="usersCheckbox">Users (Administrador)</label>
                                    </div>
                                    <div class="flex items-center space-x-2 border-b-2 pb-1">
                                        <input type="checkbox" id="controleDeAcessosCheckbox" name="permissions[]"
                                            class="form-checkbox" value="controleDeAcessos">
                                        <label for="controleDeAcessoCheckbox">Controle De Acessos</label>
                                    </div>

                                    <div class="flex items-center space-x-2 border-b-2 pb-1">
                                        <input type="checkbox" id="encaixeVisualizarCheckbox" name="permissions[]"
                                            class="form-checkbox" value="encaixeVisualizar">
                                        <label for="encaixeCheckbox">Encaixe Visualizar</label>

                                        <input type="checkbox" id="encaixeCheckbox" name="permissions[]"
                                            class="form-checkbox" value="encaixe">
                                        <label for="encaixeCheckbox">Encaixe Editar</label>
                                    </div>
                                    <div class="flex items-center space-x-2 border-b-2 pb-1">
                                        <input type="checkbox" id="chavesCheckbox" name="permissions[]"
                                            class="form-checkbox" value="chaves">
                                        <label for="chavesCheckbox">Chaves</label>
                                    </div>
                                    <div class="flex items-center space-x-2 border-b-2 pb-1">
                                        <input type="checkbox" id="controleDeFrotasCheckbox" name="permissions[]"
                                            class="form-checkbox" value="controleDeFrotas">
                                        <label for="controleDeFrotasCheckbox">Controle De Frotas</label>
                                    </div>
                                </div>
                                <!-- Other form inputs -->
                            </div>
                            <!-- Footer -->
                            <div id="errorMessage"
                                class="mt-1 hidden items-center rounded-b border-t border-solid border-slate-200 bg-red-500 p-1 text-white shadow-md">
                                <span>Error, prencha corretamente todos os campos</span>
                            </div>
                            <div
                                class="flex items-center justify-end rounded-b border-t border-solid border-slate-200 p-6">
                                <button
                                    class="background-transparent mb-1 mr-1 px-6 py-2 text-sm font-bold uppercase text-red-500 outline-none transition-all duration-150 ease-linear focus:outline-none"
                                    type="button" onclick="closeModal('modal-id')">
                                    Fechar
                                </button>
                                <button
                                    class="mb-1 mr-1 rounded bg-emerald-500 px-6 py-3 text-sm font-bold uppercase text-white shadow outline-none transition-all duration-150 ease-linear hover:shadow-lg focus:outline-none active:bg-emerald-600"
                                    onclick="updateUser(event)">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 z-40 hidden bg-black opacity-25" id="modal-id-backdrop"></div>

            <div class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto overflow-x-hidden outline-none focus:outline-none"
                id="modal-id">
                <div class="relative mx-auto my-6 w-auto max-w-3xl">
                    <!-- Content -->

                </div>
            </div>
            <div class="fixed inset-0 z-40 hidden bg-black opacity-25" id="modal-id-backdrop"></div>
        </div>
    </div>
    </div>

    </div>
    </div>

    <!-- Modal Deletagem -->
    <div class="fixed inset-0 z-50 flex hidden items-center justify-center overflow-auto bg-black bg-opacity-50"
        id="modal-id-delete">
        <div class="relative mx-auto my-6 w-3/5">
            <div
                class="relative flex w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">

                <div class="flex items-start justify-between rounded-t border-b border-slate-200 p-5">
                    <h2 class="text-xl font-semibold" id="modalTitle">
                        EXCLUIDO PELO O USUÁRIO :
                    </h2>

                    <input type="text" id="nomeAcesso" readonly
                        class="rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">

                    <button class="text-slate-600 hover:text-slate-800 focus:outline-none" type="button"
                        onclick="toggleModalDelete('modal-id-delete')">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                </div>

                <h3 class="ml-6 mt-3 text-xl font-semibold" id="modalTitle">
                    DADOS DO ACESSO
                </h3>

                <div class="p-6">

                    <form id="restaurarForm">
                        @csrf
                        <input type="text" name="idAcesso" id="idAcesso" class="hidden">
                        <input type="text" name="idSolicitacao" id="idSolicitacao" class="hidden">
                    </form>

                    <div class="grid grid-cols-2 gap-4">

                        <div class="mb-4" id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                NOME
                            </label>
                            <input type="text" value="" id="formNome" readonly
                                class="w-full rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4" id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                RG OU CPF
                            </label>
                            <input type="text" value="" id="formRgCpf" readonly
                                class="w-full rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4" id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                EMPRESA
                            </label>
                            <input type="text" value="" id="formEmpresa" readonly
                                class="w-full rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4" id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                SETOR RESPONSÁVEL
                            </label>
                            <input type="text" value="" id="formSetorResponsavel" readonly
                                class="w-full rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4" id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                PESSOA RESPONSÁVEL
                            </label>
                            <input type="text" value="" id="formPessoaResponsavel" readonly
                                class="w-full rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4" id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                PLACA
                            </label>
                            <input type="text" value="" id="formPlaca" readonly
                                class="w-full rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4" id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                HORA ENTRADA
                            </label>
                            <input type="time" value="" id="formHoraEntrada" readonly
                                class="w-full rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4" id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                HORA SAÍDA
                            </label>
                            <input type="time" value="" id="formHoraSaida" readonly
                                class="w-full rounded-md border bg-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                    </div>

                    <label for="motivo"> MOTIVO: </label>

                    <div class="mb-4">
                        <textarea readonly name="motivo" id="formMotivo" class="w-full rounded-md border bg-gray-200 px-3 py-2"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <div class="mt-3 p-2">
                            <button id=""
                                class="rounded bg-emerald-500 px-4 py-2 text-sm font-bold text-white shadow transition duration-300 hover:shadow-md"
                                onclick="restaurarExclusao(event, '{{ url('') }}')">Restaurar</button>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('javascript/users.js') }}"></script>

    <script type="module" src="{{ asset('javascript/usersTable.js') }}"></script>

</x-app-layout>
