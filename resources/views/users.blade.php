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
                                    <button class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" data-url="{{ route('users.show', $user->id) }}" onclick="toggleModal('modal-id', $(this).data('url'))">
                                        edit
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
                                            Edit User
                                        </h3>
                                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id')">
                                            <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                                                ×
                                            </span>
                                        </button>
                                    </div>
                                    <!-- Body -->
                                    <div class="relative p-6 flex-auto grid grid-cols-2 gap-4">
                                        <!-- Form inputs -->
                                        <input type="hidden" id="userId">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" id="name" class="form-control" placeholder="Name">
                                        </div>
                                        <div>
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                            <input type="text" id="last_name" class="form-control" placeholder="Last Name">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" id="email" class="form-control" placeholder="Email">
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                            <input type="tel" id="phone" class="form-control" placeholder="Phone">
                                        </div>
                                        <div>
                                            <label for="ramal" class="block text-sm font-medium text-gray-700">Ramal</label>
                                            <input type="text" id="ramal" class="form-control" placeholder="Ramal">
                                        </div>
                                        <!-- Checkboxes -->
                                        <div class="col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Permissions</label>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="testCheckbox" class="form-checkbox" value="test">
                                                <label for="testCheckbox">Test Permission</label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="usersCheckbox" class="form-checkbox" value="users">
                                                <label for="usersCheckbox">Users Permission</label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="encaixeCheckbox" class="form-checkbox" value="encaixe">
                                                <label for="encaixeCheckbox">Encaixe Permission</label>
                                            </div>
                                        </div>
                                        <!-- Other form inputs -->
                                    </div>
                                    <!-- Footer -->
                                    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                                        <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="closeModal('modal-id')">
                                            Close
                                        </button>
                                        <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" onclick="updateUser(event)">
                                            Save Changes
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
            $('#testCheckbox').prop('checked', data.permissions.some(permission => permission.permission === 'test'));
            $('#usersCheckbox').prop('checked', data.permissions.some(permission => permission.permission === 'users'));
            $('#encaixeCheckbox').prop('checked', data.permissions.some(permission => permission.permission === 'encaixe'));
            
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
        console.log(formData);

        $.ajax({
            url: '/users/' + userId,
            type: 'PUT',
            data: formData,
            success: function (response) {
                // Display success message
                $('#successMessage').text(response.message);
                $('#successMessage').show();

                // Hide the modal
                closeModal('modal-id');

                // Optional: You can clear the form inputs if needed
                $('#updateUserForm')[0].reset();
            },
            error: function (error) {
                // Handle error here
                console.log(error);
            }
        });
    }
</script>


<script type="module">
    $('document').ready(function () {  
        $('#myTable').DataTable( {
            fixedHeader: true,
            responsive: true
        } );
    });
</script>

</html>
