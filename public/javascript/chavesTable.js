$(document).ready(function () {
    $('#myTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: 'chaves',
        columnDefs: [
            {
                className: 'align-left',
                width: '10%',
                targets: 0,
                render: function (data) {
                    return new Date(data).toLocaleDateString()
                }
            },
            {
                width: '10%',
                targets: 1
            },
            {
                width: '10%',
                targets: 2
            },
            {
                width: '30%',
                targets: 3
            },
            {
                width: '30%',
                targets: 4
            },
            {
                width: '10%',
                targets: 5
            }
        ],
        columns: [
            {
                data: 'created_at',
                orderable: true
            },
            {
                data: 'horaEntrada',
                orderable: true
            },
            {
                data: 'horaSaida.saida',
                orderable: true,
                render: function (data, type, row) {
                    if (data == null) {
                        return `<button onclick="registrarHoraSaida(${row.horaSaida.id})" class="bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                 Registrar
                                </button>`
                    }

                    var createdDate = new Date(row.created_at)
                    var formattedCreatedDate = `${createdDate.getDate()}/${
                        createdDate.getMonth() + 1
                    }/${createdDate.getFullYear()}`

                    if (
                        row.dataSaida != formattedCreatedDate &&
                        row.dataSaida != null
                    ) {
                        return `${row.dataSaida} às ${data}`
                    }

                    return data
                }
            },
            {
                data: 'nomeChave',
                orderable: true
            },
            {
                data: 'nomePessoa',
                orderable: true
            },
            {
                data: 'actions',
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            onclick="showChave(event, '${row.horaSaida.id}' )">
                           EDITAR
                        </button>
                    `
                }
            }
        ],
        order: [[2, 'asc']],

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
