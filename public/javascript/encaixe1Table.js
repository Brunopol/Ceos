$(document).ready(function () {
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'encaixe',
        columnDefs: [
            {
                className: 'align-left',
                targets: 2,
                render: function (data) {
                    return new Date(data).toLocaleString()
                }
            }
        ],
        order: [[2, 'desc']],

        columns: [
            {
                data: 'referencia',
                name: 'referencia'
            },
            {
                data: 'tecidos',
                orderable: false,

                render: function (data, type, row) {
                    function isObject (variable) {
                        return typeof variable === 'object' && variable !== null
                    }

                    if (isObject(data)) {
                        data = Object.values(data)
                    }

                    data = data.map(element => {
                        if (typeof element === 'string') {
                            element = element.replace(/^\s+|\s+$/g, '')
                        }
                        return element
                    })

                    return data.join(', ')
                }
            },
            {
                data: 'created_at',
                orderable: true
            },
            {
                data: 'actions',
                orderable: false,
                render: function (data, type, row) {
                    var actionsData = data

                    if (data.canEdit) {
                        return `
                        <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" data-url="${actionsData.url_show}" data-referencia="${actionsData.referencia}"
                            data-date="${actionsData.date}"
                            onclick="toggleModal('modal-id', '${actionsData.url_show}', '${actionsData.referencia}', '${actionsData.date}')">
                            Mostrar
                        </button>
                        <button class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" data-url="${actionsData.url_delete}" data-referencia="${actionsData.referencia}"
                            onclick="deletarEncaixeConfirmar('${actionsData.referencia}', '${actionsData.url_delete}')">
                            Deletar
                        </button>
                    `
                    } else {
                        return `<button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" data-url="${actionsData.url_show}" data-referencia="${actionsData.referencia}"
                            data-date="${actionsData.date}"
                            onclick="toggleModal('modal-id', '${actionsData.url_show}', '${actionsData.referencia}', '${actionsData.date}')">
                            Mostrar
                        </button>`
                    }
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
