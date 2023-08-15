<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Encaixe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div id="loadingSpinner" class="text-center my-4 hidden">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    
                    <table id="myTable" class="table table-striped nowrap cell-border hover stripe" style="width:100%">
                        <thead>
                            <tr>
                                <th>ref</th>
                                <th>editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($encaixes as $encaixe)
                            <tr>
                                <td>{{ $encaixe->referencia }}</td>
                                <td>
                                    <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" data-url="" onclick="toggleModal('modal-id', $(this).data('url'))">
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
                            <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                                    <!-- Header -->
                                    <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                                        <h3 class="text-3xl font-semibold">
                                            Editar Encaixe
                                        </h3>
                                    </div>
                                    <!-- Body -->
                                   
                                        <!--Tabs navigation-->
                                        <ul
                                        class="mr-4 flex list-none flex-col flex-wrap pl-0"
                                        role="tablist"
                                        data-te-nav-ref>
                                        <li role="presentation" class="flex-grow text-center">
                                            <a
                                            href="#tabs-home03"
                                            class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                                            data-te-toggle="pill"
                                            data-te-target="#tabs-home03"
                                            data-te-nav-active
                                            role="tab"
                                            aria-controls="tabs-home03"
                                            aria-selected="true"
                                            >Home</a
                                            >
                                        </li>
                                        <li role="presentation" class="flex-grow text-center">
                                            <a
                                            href="#tabs-profile03"
                                            class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                                            data-te-toggle="pill"
                                            data-te-target="#tabs-profile03"
                                            role="tab"
                                            aria-controls="tabs-profile03"
                                            aria-selected="false"
                                            >Profile</a
                                            >
                                        </li>
                                        <li role="presentation" class="flex-grow text-center">
                                            <a
                                            href="#tabs-messages03"
                                            class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                                            data-te-toggle="pill"
                                            data-te-target="#tabs-messages03"
                                            role="tab"
                                            aria-controls="tabs-messages03"
                                            aria-selected="false"
                                            >Messages</a
                                            >
                                        </li>
                                        <li role="presentation" class="flex-grow text-center">
                                            <a
                                            href="#tabs-contact03"
                                            class="disabled pointer-events-none my-2 block border-x-0 border-b-2 border-t-0 border-transparent bg-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-400 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent dark:text-neutral-600"
                                            data-te-toggle="pill"
                                            data-te-target="#tabs-contact03"
                                            role="tab"
                                            aria-controls="tabs-contact03"
                                            aria-selected="false"
                                            >Contact</a
                                            >
                                        </li>
                                        </ul>

                                        <!--Tabs content-->
                                        <div class="my-2">
                                        <div
                                            class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                                            id="tabs-home03"
                                            role="tabpanel"
                                            aria-labelledby="tabs-home-tab03"
                                            data-te-tab-active>
                                            Tab 1 content
                                        </div>
                                        <div
                                            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                                            id="tabs-profile03"
                                            role="tabpanel"
                                            aria-labelledby="tabs-profile-tab03">
                                            Tab 2 content
                                        </div>
                                        <div
                                            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                                            id="tabs-messages03"
                                            role="tabpanel"
                                            aria-labelledby="tabs-profile-tab03">
                                            Tab 3 content
                                        </div>
                                        <div
                                            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                                            id="tabs-contact03"
                                            role="tabpanel"
                                            aria-labelledby="tabs-contact-tab03">
                                            Tab 4 content
                                        </div>
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
        
        $("#" + modalID).toggleClass("hidden flex");
        $("#" + modalID + "-backdrop").toggleClass("hidden flex");

    }

    function closeModal(modalID) {
        $("#" + modalID).toggleClass("hidden flex");
        $("#" + modalID + "-backdrop").toggleClass("hidden flex");
    }
</script>


<script type="module">
    $('document').ready(function () {  
        $('#myTable').DataTable({
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

        });
    });
</script>

<style> 

    .dataTables_wrapper .dataTables_length select {
        padding-right: 2rem
    }

</style>