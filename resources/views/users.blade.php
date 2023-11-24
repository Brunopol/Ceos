<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulo Usuários') }}
        </h2>

        <div id="successMessage" class="hidden mt-4 bg-green-500 text-white p-4 rounded-md shadow-md">
            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Usuário alterado com sucesso</span>
        </div>
        
    </x-slot>

   


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table id="myTable" class="table table-striped nowrap cell-border hover stripe" style="width:100%">
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
                                    <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" data-url="{{ route('users.show', $user->id) }}" onclick="toggleModal('modal-id', $(this).data('url'))">
                                        editar
                                    </button>                                    
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    

                    

                    <!-- Model -->
                    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id">
                        <div class="relative w-auto my-6 mx-auto max-w-3xl">
                            <!-- Content -->
                            <form id="updateUserForm">
                                @csrf <!-- Laravel CSRF token -->
                                <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                                    <!-- Header -->
                                    <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
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
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                                        </div>
                                        <div>
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">Sobrenome</label>
                                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700">Celular</label>
                                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="Phone">
                                        </div>
                                        <div>
                                            <label for="ramal" class="block text-sm font-medium text-gray-700">Ramal</label>
                                            <input type="text" id="ramal" name="ramal" class="form-control" placeholder="Ramal">
                                        </div>
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                                            <input type="text" id="password" name="password" class="form-control">
                                        </div>
                                        <!-- Checkboxes -->
                                        <div class="col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Permissões</label>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="controleDeAcessosCheckbox" name="permissions[]" class="form-checkbox" value="controleDeAcessos">
                                                <label for="controleDeAcessoCheckbox">Controle De Acessos</label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="usersCheckbox" name="permissions[]" class="form-checkbox" value="users">
                                                <label for="usersCheckbox">Users</label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="encaixeCheckbox" name="permissions[]" class="form-checkbox" value="encaixe">
                                                <label for="encaixeCheckbox">Encaixe Editar</label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="encaixeVisualizarCheckbox" name="permissions[]" class="form-checkbox" value="encaixeVisualizar">
                                                <label for="encaixeCheckbox">Encaixe Visualizar</label>
                                            </div>
                                        </div>
                                        <!-- Other form inputs -->
                                    </div>
                                    <!-- Footer -->
                                    <div id="errorMessage" class="hidden mt-1 bg-red-500 text-white p-1 rounded-b shadow-md items-center border-t border-solid border-slate-200">
                                        <span>Error, prencha corretamente todos os campos</span>
                                    </div>
                                    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                                        <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="closeModal('modal-id')">
                                            Fechar
                                        </button>
                                        <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" onclick="updateUser(event)">
                                            Salvar
                                        </button>    
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script type="text/javascript">
    function toggleModal(modalID, userURL) {
        $.get(userURL, function (data) {
            $('#userId').val(data.id);
            $('#name').val(data.name);
            $('#last_name').val(data.last_name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#ramal').val(data.ramal);

            // Check fixed checkboxes
            $('#controleDeAcessosCheckbox').prop('checked', data.permissions.some(permission => permission.permission === 'controleDeAcessos'));
            $('#usersCheckbox').prop('checked', data.permissions.some(permission => permission.permission === 'users'));
            $('#encaixeCheckbox').prop('checked', data.permissions.some(permission => permission.permission === 'encaixe'));
            $('#encaixeVisualizarCheckbox').prop('checked', data.permissions.some(permission => permission.permission === 'encaixeVisualizar'));
            

            
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
            success: function (response) {
        
                // Display success message
                $('#successMessage').removeClass('hidden'); // Show the success div

                // Hide the modal
                closeModal('modal-id');

                // Optional: You can clear the form inputs if needed
                $('#updateUserForm')[0].reset();
            },
            error: function (error) {
                // Handle error here
                console.log(error);
                $('#errorMessage').removeClass('hidden'); // Show the success div
                
            }
        });
    }
</script>


<script type="module">
    $('document').ready(function () {  
        $('#myTable').DataTable( {
            fixedHeader: true,
            responsive: true,
            "lengthChange": true,
            "lengthMenu": [10, 25, 50, 75, 100 ],

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
        } );
    });
</script>

