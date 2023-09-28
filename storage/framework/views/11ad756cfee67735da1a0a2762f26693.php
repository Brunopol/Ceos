<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Usuários')); ?>

        </h2>

        <div id="successMessage" class="hidden mt-4 bg-green-500 text-white p-4 rounded-md shadow-md">
            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Usuário alterado com sucesso</span>
        </div>
        
     <?php $__env->endSlot(); ?>

   


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
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->last_name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->phone); ?></td>
                                <td>
                                    <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" data-url="<?php echo e(route('users.show', $user->id)); ?>" onclick="toggleModal('modal-id', $(this).data('url'))">
                                        editar
                                    </button>                                    
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                    

                    

                    <!-- Model -->
                    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id">
                        <div class="relative w-auto my-6 mx-auto max-w-3xl">
                            <!-- Content -->
                            <form id="updateUserForm">
                                <?php echo csrf_field(); ?> <!-- Laravel CSRF token -->
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
                                        <!-- Checkboxes -->
                                        <div class="col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Permissões</label>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="testCheckbox" name="permissions[]" class="form-checkbox" value="test">
                                                <label for="testCheckbox">Test</label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="usersCheckbox" name="permissions[]" class="form-checkbox" value="users">
                                                <label for="usersCheckbox">Users</label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="encaixeCheckbox" name="permissions[]" class="form-checkbox" value="encaixe">
                                                <label for="encaixeCheckbox">Encaixe</label>
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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

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

<?php /**PATH /home/ufowayco/CeosV4/Ceos/resources/views/users.blade.php ENDPATH**/ ?>