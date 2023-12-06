<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulo Usuários') }}
        </h2>

        <div id="successMessage" class="hidden mt-4 bg-green-500 text-white p-4 rounded-md shadow-md">
            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Usuário alterado com sucesso</span>
        </div>

    </x-slot>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Users Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h1 class="text-2xl font-bold mb-4">Usuários</h1>

                    <table id="myTable" class="table table-striped nowrap cell-border hover stripe"
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
                                            class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-xl">
                <div class="p-6 text-gray-900 flex flex-col items-center">
                    <h1 class="text-2xl font-bold mb-4">Exclusões de Acessos</h1>
                    <div class="">
                        <div class="overflow-hidden max-w-5xl mx-auto">
                            <table id="tableSolicitacoes"
                                class="table table-striped nowrap cell-border hover stripe w-full display compact">
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
            <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
                id="modal-id">
                <div class="relative w-auto my-6 mx-auto max-w-3xl">
                    <!-- Content -->
                    <form id="updateUserForm">
                        @csrf <!-- Laravel CSRF token -->
                        <div
                            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                            <!-- Header -->
                            <div
                                class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                                <h3 class="text-3xl font-semibold">
                                    Editar Usuário
                                </h3>
                            </div>
                            <!-- Body -->
                            <div class="relative p-6 flex-auto grid grid-cols-2 gap-4">
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
                                    <label class="block text-sm font-medium text-gray-700">Permissões</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="controleDeAcessosCheckbox" name="permissions[]"
                                            class="form-checkbox" value="controleDeAcessos">
                                        <label for="controleDeAcessoCheckbox">Controle De Acessos</label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="usersCheckbox" name="permissions[]"
                                            class="form-checkbox" value="users">
                                        <label for="usersCheckbox">Users</label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="encaixeCheckbox" name="permissions[]"
                                            class="form-checkbox" value="encaixe">
                                        <label for="encaixeCheckbox">Encaixe Editar</label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="encaixeVisualizarCheckbox" name="permissions[]"
                                            class="form-checkbox" value="encaixeVisualizar">
                                        <label for="encaixeCheckbox">Encaixe Visualizar</label>
                                    </div>
                                </div>
                                <!-- Other form inputs -->
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
                                    type="button" onclick="closeModal('modal-id')">
                                    Fechar
                                </button>
                                <button
                                    class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    onclick="updateUser(event)">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>


            <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
                id="modal-id">
                <div class="relative w-auto my-6 mx-auto max-w-3xl">
                    <!-- Content -->

                </div>
            </div>
            <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>
        </div>
    </div>
    </div>

    </div>
    </div>

    <!-- Modal Deletagem -->
    <div class="fixed z-50 inset-0 flex items-center justify-center overflow-auto bg-black bg-opacity-50 hidden"
        id="modal-id-delete">
        <div class="relative w-3/5 my-6 mx-auto">
            <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">

                <div class="flex items-start justify-between p-5 border-b border-slate-200 rounded-t">
                    <h2 class="text-xl font-semibold" id="modalTitle">
                        EXCLUIDO PELO O USUÁRIO :
                    </h2>

                    <input type="text" id="nomeAcesso" readonly
                        class="bg-gray-200 border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">


                    <button class="text-slate-600 hover:text-slate-800 focus:outline-none" type="button"
                        onclick="toggleModalDelete('modal-id-delete')">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                </div>

                <h3 class="text-xl font-semibold ml-6 mt-3" id="modalTitle">
                    DADOS DO ACESSO
                </h3>

                <div class="p-6">

                    <form id="restaurarForm">
                        @csrf
                        <input type="text" name="idAcesso" id="idAcesso" class="hidden">
                        <input type="text" name="idSolicitacao" id="idSolicitacao" class="hidden">
                    </form>

                    <div class="grid grid-cols-2 gap-4">


                        <div class="mb-4 " id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                NOME
                            </label>
                            <input type="text" value="" id="formNome" readonly
                                class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4 " id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                RG OU CPF
                            </label>
                            <input type="text" value="" id="formRgCpf" readonly
                                class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4 " id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                EMPRESA
                            </label>
                            <input type="text" value="" id="formEmpresa" readonly
                                class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4 " id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                SETOR RESPONSÁVEL
                            </label>
                            <input type="text" value="" id="formSetorResponsavel" readonly
                                class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4 " id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                PESSOA RESPONSÁVEL
                            </label>
                            <input type="text" value="" id="formPessoaResponsavel" readonly
                                class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4 " id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                PLACA
                            </label>
                            <input type="text" value="" id="formPlaca" readonly
                                class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4 " id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                HORA ENTRADA
                            </label>
                            <input type="time" value="" id="formHoraEntrada" readonly
                                class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>

                        <div class="mb-4 " id="">
                            <label for="placa" class="block text-sm font-medium text-gray-700">
                                HORA SAÍDA
                            </label>
                            <input type="time" value="" id="formHoraSaida" readonly
                                class="bg-gray-200 w-full border rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        </div>


                    </div>


                    <label for="motivo"> MOTIVO: </label>

                    <div class="mb-4">
                        <textarea readonly name="motivo" id="formMotivo" class="w-full px-3 py-2 border rounded-md bg-gray-200"></textarea>
                    </div>



                    <div class="flex justify-end">
                        <div class="mt-3 p-2">
                            <button id=""
                                class="bg-emerald-500 text-white font-bold text-sm py-2 px-4 rounded shadow hover:shadow-md transition duration-300"
                                onclick="restaurarExclusao(event, '{{ url('') }}')">Restaurar</button>
                        </div>

                    </div>


                </div>





            </div>
        </div>
    </div>


    <script type="text/javascript">
        function toggleModal(modalID, userURL) {
            $.get(userURL, function(data) {
                $('#userId').val(data.id);
                $('#name').val(data.name);
                $('#last_name').val(data.last_name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#ramal').val(data.ramal);

                // Check fixed checkboxes
                $('#controleDeAcessosCheckbox').prop('checked', data.permissions.some(permission => permission
                    .permission === 'controleDeAcessos'));
                $('#usersCheckbox').prop('checked', data.permissions.some(permission => permission.permission ===
                    'users'));
                $('#encaixeCheckbox').prop('checked', data.permissions.some(permission => permission.permission ===
                    'encaixe'));
                $('#encaixeVisualizarCheckbox').prop('checked', data.permissions.some(permission => permission
                    .permission === 'encaixeVisualizar'));



                // Show the modal using the toggleModal function
                $("#" + modalID).toggleClass("hidden flex");
                $("#" + modalID + "-backdrop").toggleClass("hidden flex");
            });
        }

        function closeModal(modalID) {
            $("#" + modalID).toggleClass("hidden flex");
            $("#" + modalID + "-backdrop").toggleClass("hidden flex");
        }

        function updateUser(event) {
            // Prevent the default form submission behavior
            event.preventDefault();

            var formData = $('#updateUserForm').serialize();
            var userId = $('#userId').val();

            $.ajax({
                url: '/v4/users/' + userId,
                type: 'PUT',
                data: formData,
                success: function(response) {

                    // Display success message
                    $('#successMessage').removeClass('hidden'); // Show the success div

                    // Hide the modal
                    closeModal('modal-id');

                    // Optional: You can clmostrarSolicitacaoear the form inputs if needed
                    $('#updateUserForm')[0].reset();
                },
                error: function(error) {
                    // Handle error here
                    console.log(error);
                    $('#errorMessage').removeClass('hidden'); // Show the success div

                }
            });
        }

        function mostrarSolicitacao(id, idSolicitacaoNum, userName, motivo) {
            var url = window.location.href;

            var nome = $('#formNome');
            var rgCpf = $('#formRgCpf');
            var empresa = $('#formEmpresa');
            var setorResponsavel = $('#formSetorResponsavel');
            var pessoaResponsavel = $('#formPessoaResponsavel');
            var placa = $('#formPlaca');
            var horaEntrada = $('#formHoraEntrada');
            var horaSaida = $('#formHoraSaida');
            var userNameinput = $('#nomeAcesso');
            var motivoinput = $('#formMotivo');

            var idAcesso = $('#idAcesso');
            var idSolicitacao = $('#idSolicitacao');

            idAcesso.val('');
            idSolicitacao.val('');

            nome.val('');
            rgCpf.val('');
            empresa.val('');
            setorResponsavel.val('');
            pessoaResponsavel.val('');
            placa.val('');
            horaEntrada.val('');
            horaSaida.val('');
            userNameinput.val('');
            motivoinput.val('');

            url = url + '/controleDeAcesso/' + id

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {

                    nome.val(response.nome);
                    rgCpf.val(response.rgCpf);
                    empresa.val(response.transportadora);
                    setorResponsavel.val(response.setorResponsavel);
                    pessoaResponsavel.val(response.pessoaResponsavel);
                    placa.val(response.placa);
                    horaEntrada.val(response.horaEntrada);
                    horaSaida.val(response.horaSaida);
                    userNameinput.val(userName);
                    motivoinput.val(motivo);

                    idAcesso.val(id);
                    idSolicitacao.val(idSolicitacaoNum);

                    toggleModalDelete('modal-id-delete')



                },
                error: function(error) {
                    // Handle error here
                    console.log(error);
                    $('#errorMessage').removeClass('hidden'); // Show the success div

                }
            });

        }

        function restaurarExclusao(event, url) {
            event.preventDefault();

            var formData = $('#restaurarForm').serialize();


            url = url + '/users/restaurarAcesso';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {

                    toggleModalDelete('modal-id-delete')
                    location.reload();
                    showNotification(response.message)
                },
                error: function(error) {
                    console.log(error);


                }
            });


        }

        function toggleModalDelete(modalID) {
            $("#" + modalID).toggleClass("hidden flex");
            $("#" + modalID + "-backdrop").toggleClass("hidden flex");
        }

        //--------------------NOTIFICAÇÕES--------------------\\

        function showNotification(message) {
            var notification = $('<div>', {
                class: 'fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded-md shadow-md z-50',
                text: message
            }).appendTo('body')

            setTimeout(function() {
                notification.fadeOut(300, function() {
                    $(this).remove()
                })
            }, 5000)
        }
    </script>

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

    <script type="module">
        $(document).ready(function() {
            $('#tableSolicitacoes').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "indexForSolicitacoes",
                columnDefs: [{
                        className: "align-left",
                        "width": "20%",
                        "targets": 0,
                        render: function(data) {
                            return new Date(data).toLocaleDateString();
                        }
                    },
                    {
                        "width": "20%",
                        "targets": 1
                    },
                    {
                        "width": "40%",
                        "targets": 2
                    },
                    {
                        "width": "20%",
                        "targets": 3
                    },
                ],
                order: [

                    [0, 'desc']
                ],

                columns: [{
                        data: 'created_at',
                        orderable: true
                    },
                    {
                        data: 'nomeUsuario',
                    },
                    {
                        data: 'motivo',
                        ordable: false,
                        render: function(data, type, row) {

                            if (data == null) {
                                return null
                            }

                            if (data.length > 15) {

                                return data.substring(0, 15) + '...';
                            } else {

                                return data;
                            }
                        }
                    },

                    {
                        data: 'actions',
                        orderable: false,
                        render: function(data, type, row) {

                            console.log(row);

                            return `
                            <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                onclick="mostrarSolicitacao(${row.id},${row.idSolicitacao},'${row.nomeUsuario}','${row.motivo}')">
                               Mostrar
                            </button>
                            
                        `;
                        }
                    },

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


</x-app-layout>
