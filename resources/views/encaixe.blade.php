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
                                <th>tecido</th>
                                <th>largura</th>
                                <th>qtd_pecas</th>
                                <th>consumo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($encaixes as $encaixe)
                            <tr>
                                <td>{{ $encaixe->ref }}</td>
                                <td>{{ $encaixe->tecido }}</td>
                                <td>{{ $encaixe->largura }}</td>
                                <td>{{ $encaixe->qtd_pecas }}</td>
                                <td>{{ $encaixe->consumo }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


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