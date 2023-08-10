<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table id="myTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>email</th>
                                <th>created_at</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
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
                                    <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="userModalBody">
                                    <form id="updateUserForm">
                                        @csrf
                                        <input type="hidden" name="user_id" id="userId">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                        <!-- Add other fields here -->
                                        
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="updateUserBtn">Save changes</button>
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
        $('#myTable').DataTable();

        $('body').on('click', '#show-user', function () {
            var userURL = $(this).data('url');
            $.get(userURL, function (data) {
                $('#userId').val(data.id);
                $('#name').val(data.name);
                $('#last_name').val(data.last_name);
                $('#email').val(data.email);
                // Set other field values here

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
                    // Handle success here
                    console.log(response);
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
