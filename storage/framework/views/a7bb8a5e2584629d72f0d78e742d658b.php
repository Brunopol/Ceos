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
            <?php echo e(__('Módulo Encaixe')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <script>
        var csrfToken = '<?php echo e(csrf_token()); ?>';
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div id="loadingSpinner" class="text-center my-4 hidden">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>


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
                                    <th>REF</th>
                                    <th>TECIDOS</th>
                                    <th>DATA</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $encaixes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $encaixe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($encaixe->referencia); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $encaixe->tecidos(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                
                                                <?php echo e($tecido . ', '); ?>


                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td><?php echo e($encaixe->created_at); ?></td>
                                        <td>
                                            <button
                                                class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                                type="button" data-url="<?php echo e(route('encaixe.show', $encaixe->id)); ?>"
                                                data-referencia="<?php echo e($encaixe->referencia); ?>"
                                                data-date="<?php echo e($encaixe->created_at); ?>"
                                                onclick="toggleModal('modal-id', $(this).data('url'), $(this).data('referencia'), $(this).data('date'))">
                                                Mostrar
                                            </button>
                                            <button
                                                class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                                type="button" data-url="<?php echo e(route('encaixe.delete', $encaixe->id)); ?>"
                                                data-referencia="<?php echo e($encaixe->referencia); ?>"
                                                onclick="deletarEncaixeConfirmar($(this).data('referencia'), $(this).data('url'))">
                                                Deletar
                                            </button>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                                            onclick="adicionarEncaixe(event, document.getElementById('referencia').value, '<?php echo e(url('')); ?>')">
                                            Salvar
                                        </button>
                                    </div>

                                </form>



                            </div>
                        </div>
                    </div>
                    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-add-backdrop"></div>


                    <!-- Model Para editar encaixe-->
                    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
                        id="modal-id">
                        <div class="relative w-3/7 h-1/2 my-6 mx-auto">
                            <!-- Content -->
                            <div
                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full h-full bg-white outline-none focus:outline-none">
                                <!-- Header -->
                                <div
                                    class="flex items-center justify-between p-4 border-b border-solid border-gray-300 rounded-t bg-gray-800">
                                    <div class="flex items-center">
                                        <h3 class="text-2xl font-semibold text-white" id="tituloEncaixeRef">
                                            <span id="referenceBox"
                                                class="inline-block px-2 py-1 rounded-md bg-indigo-500 text-white">Reference</span>
                                        </h3>
                                    </div>
                                    <div class="flex items-center">
                                        <h3 class="text-2xl font-semibold text-white">
                                            <span id="dateBox" class="inline-block">
                                                <span
                                                    class="inline-block px-3 py-1 rounded-md bg-green-500 text-white">Date</span>
                                            </span>
                                        </h3>
                                    </div>
                                </div>


                                <!-- Body -->
                                <div class="flex flex-wrap justify-center items-center h-full" id="tabs-id">
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
                    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>


                </div>
            </div>
        </div>
    </div>

    <div class="hidden fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded-md shadow-md">
        <button
            class="hidden bg-red-100 hover:bg-red-600 text-white font-semibold py-1 px-2 rounded transition duration-300 ease-in-out focus:outline-none text-xs"
            type="button" onclick="">
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

<script type="module">
    $('document').ready(function() {
        $('#myTable').DataTable({
            columns: [{
                    data: 'referencia'
                }, // Use the actual name of your reference column
                null,
                {
                    data: 'created_at', // Use the actual name of your date column
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            var date = new Date(data);
                            return date.toLocaleString('pt-BR', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                            });
                        }
                        return data;
                    },
                },

                null,

            ],

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

<script src="https://dev.ufoway.com.br/v4/javascript/encaixe.js" type="text/javascript"></script>
<?php /**PATH /home/ufowayco/CeosV4/Ceos/resources/views/encaixe.blade.php ENDPATH**/ ?>