$(document).ready(function() {
    $('#myTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "controleDeAcesso",
        columnDefs: [{
                className: "align-left",
                "targets": 0,
                render: function(data) {
                    return new Date(data).toLocaleDateString();
                }
            },

            {
                "width": "20%",
                "targets": 3
            },
            {
                "width": "20%",
                "targets": 4
            },
            {
                "width": "20%",
                "targets": 5
            },
            {
                "width": "20%",
                "targets": 6
            },

        ],
        columns: [{
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
                render: function(data, type, row) {


                    if (data == null) {
                        return `<button onclick="registrarHoraSaida(${row.horaSaida.id})" class="bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                 Registrar
                                </button>`
                    }

                    var createdDate = new Date(row.created_at);
                    var formattedCreatedDate =
                        `${createdDate.getDate()}/${createdDate.getMonth() + 1}/${createdDate.getFullYear()}`;



                    if (row.dataSaida != formattedCreatedDate && row.dataSaida != null) {
                        return `${row.dataSaida} às ${data}`;
                    }

                    return data
                }
            },

            {
                data: 'nome',
                name: 'nome'
            },
            {
                data: 'rgCpf',
                orderable: false,
                render: function(data, type, row) {

                    if (data.length < 4 || !/^\d+$/.test(data)) {
                        return data;
                    } else {
                        // Assuming data is a string with only numeric characters
                        let prefix = data.substring(0, 3);
                        let suffix = data.substring(data.length - 3);
                        let dataModified = prefix + '*******' + suffix;

                        return dataModified;
                    }

                }
            },
            {
                data: 'empresa',
                orderable: false
            },
            {
                data: 'placa',
                orderable: false
            },
            {
                data: 'actions',
                orderable: false,
                render: function(data, type, row) {

                    var actionsData = data

                    return `
                        <button class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            onclick="mostrarAcesso('${ actionsData.url_show }')">
                           EDITAR
                        </button>

                        <button class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            onclick="solicitarDeletagemButton('${row.nome}', '${row.horaSaida.id}')">
                           DELETAR
                        </button>
                        
                    `;
                }
            },
            {
                data: 'pessoaResponsavel',
                orderable: false
            },
            {
                data: 'setorResponsavel',
                orderable: false
            }

        ],
        order: [

            [2, 'asc']
        ],

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