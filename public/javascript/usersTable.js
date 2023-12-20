$('document').ready(function () {
    $('#myTable').DataTable({
        fixedHeader: true,
        responsive: true,
        lengthChange: true,
        lengthMenu: [10, 25, 50, 75, 100],

        language: {
            decimal: '',
            emptyTable: 'Nenhum dado disponível na tabela',
            info: 'Mostrando _START_ até _END_ de _TOTAL_ entradas',
            infoEmpty: 'Mostrando 0 até 0 de 0 entradas',
            infoFiltered: '(filtrado de um total de _MAX_ entradas)',
            infoPostFix: '',
            thousands: ',',
            lengthMenu: 'Mostrar _MENU_ entradas',
            loadingRecords: 'Carregando...',
            processing: '',
            search: 'Buscar:',
            zeroRecords: 'Nenhum registro correspondente encontrado',
            paginate: {
                first: 'Primeira',
                last: 'Última',
                next: 'Próxima',
                previous: 'Anterior'
            },
            aria: {
                sortAscending:
                    ': ativar para ordenar coluna de forma ascendente',
                sortDescending:
                    ': ativar para ordenar coluna de forma descendente'
            }
        }
    })
})

$(document).ready(function () {
    $('#tableSolicitacoes').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: 'indexForSolicitacoes',
        columnDefs: [
            {
                className: 'align-left',
                width: '20%',
                targets: 0,
                render: function (data) {
                    return new Date(data).toLocaleDateString()
                }
            },
            {
                width: '20%',
                targets: 1
            },
            {
                width: '40%',
                targets: 2
            },
            {
                width: '20%',
                targets: 3
            }
        ],
        order: [[0, 'desc']],

        columns: [
            {
                data: 'created_at',
                orderable: true
            },
            {
                data: 'nomeUsuario'
            },
            {
                data: 'motivo',
                ordable: false,
                render: function (data, type, row) {
                    if (data == null) {
                        return null
                    }

                    if (data.length > 15) {
                        return data.substring(0, 15) + '...'
                    } else {
                        return data
                    }
                }
            },

            {
                data: 'actions',
                orderable: false,
                render: function (data, type, row) {
                    console.log(row)

                    return `
                    <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        onclick="mostrarSolicitacao(${row.id},${row.idSolicitacao},'${row.nomeUsuario}','${row.motivo}')">
                       Mostrar
                    </button>
                    
                `
                }
            }
        ],
        language: {
            decimal: '',
            emptyTable: 'Nenhum dado disponível na tabela',
            info: 'Mostrando _START_ até _END_ de _TOTAL_ entradas',
            infoEmpty: 'Mostrando 0 até 0 de 0 entradas',
            infoFiltered: '(filtrado de um total de _MAX_ entradas)',
            infoPostFix: '',
            thousands: ',',
            lengthMenu: 'Mostrar _MENU_ entradas',
            loadingRecords: 'Carregando...',
            processing: '',
            search: 'Buscar:',
            zeroRecords: 'Nenhum registro correspondente encontrado',
            paginate: {
                first: 'Primeira',
                last: 'Última',
                next: 'Próxima',
                previous: 'Anterior'
            },
            aria: {
                sortAscending:
                    ': ativar para ordenar coluna de forma ascendente',
                sortDescending:
                    ': ativar para ordenar coluna de forma descendente'
            }
        }
    })
})
