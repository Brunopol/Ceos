<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <div id="successMessage" class="alert alert-success" style="display: none;"></div>

                    <table id="myTable" class="table table-striped nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>nome</th>
                                <th>sobrenome</th>
                                <th>email</th>
                                <th>celular</th>
                                <th>action</th>
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
                                    <a href="javascript:void(0)" id="show-user" data-url="{{ route('users.show', $user->id) }}" class="btn btn-info">Show</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    

                    <!-- Modal -->
                    <div class="modal fade" id="userShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Detalhes do Usuário</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar">X</button>
                                </div>
                                <div class="modal-body" id="userModalBody">
                                    <form id="updateUserForm">
                                        @csrf
                                        <input type="hidden" name="user_id" id="userId">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Sobrenome</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Celeular</label>
                                            <input type="number" class="form-control" id="phone" name="phone">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ramal" class="form-label">Ramal</label>
                                            <input type="number" class="form-control" id="ramal" name="ramal">
                                        </div>
                                        <!-- Add other fields here -->
                                        <div class="mb-3">
                                            <label class="form-label">Permissões</label><br>
                                            <input type="checkbox" id="usersCheckbox" name="permissions[]" value="users"> Users<br>
                                            <input type="checkbox" id="encaixeCheckbox" name="permissions[]" value="encaixe"> Encaixe<br>
                                            <input type="checkbox" id="testCheckbox" name="permissions[]" value="test"> Teste<br>
                                        </div>
                                        
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-outline-primary" id="updateUserBtn">Salvar</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script type="module">
    $('document').ready(function () {
        //new DataTable('#myTable');
        
        $('#myTable').DataTable( {
            fixedHeader: true,
            responsive: true
        } );

        $('body').on('click', '#show-user', function () {
            var userURL = $(this).data('url');
            $.get(userURL, function (data) {
                $('#userId').val(data.id);
                $('#name').val(data.name);
                $('#last_name').val(data.last_name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#ramal').val(data.ramal);
        
                // Check fixed checkboxes
                if (data.permissions.some(permission => permission.permission === 'test')) {
                    $('#testCheckbox').prop('checked', true);
                } else {
                    $('#testCheckbox').prop('checked', false);
                }
                if (data.permissions.some(permission => permission.permission === 'users')) {
                    $('#usersCheckbox').prop('checked', true);
                }else {
                    $('#usersCheckbox').prop('checked', false);
                }
                if (data.permissions.some(permission => permission.permission === 'encaixe')) {
                    $('#encaixeCheckbox').prop('checked', true);
                }else {
                    $('#encaixeCheckbox').prop('checked', false);
                }
                
                $('#userShowModal').modal('show');
            });
        });

        $('#updateUserBtn').click(function () {
    var formData = $('#updateUserForm').serialize();
    var userId = $('#userId').val();

    $.ajax({
        url: '/users/' + userId,
        type: 'PUT',
        data: formData,
        success: function (response) {
            // Display success message
            $('#successMessage').text(response.message);
            $('#successMessage').show();

            // Hide the modal
            $('#userShowModal').modal('hide');
            
            // Optional: You can clear the form inputs if needed
            $('#updateUserForm')[0].reset();
        },
        error: function (error) {
            // Handle error here
            console.log(error);
        }
    });
});
    });
</script>


</html>
