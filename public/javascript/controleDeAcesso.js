// functions for toggle modal of add and edit acessos

function toggleModal (modalID, type) {
    var adicionarButton = $('#adicionarButton')

    var atualizarButton = $('#atualizarButton')

    if (type) {
        $('#modalTitle').text('Atualizar Acesso')
        atualizarButton.removeClass('hidden')
        adicionarButton.addClass('hidden')
    } else {
        $('#formAddAcesso')[0].reset()
        hideCarro()
        hideHoraSaida()
        hideHoraEntrada()
        $('#modalTitle').text('Adicionar Acesso')
        atualizarButton.addClass('hidden')
        adicionarButton.removeClass('hidden')
    }

    $('#' + modalID).toggleClass('hidden flex')
    $('#' + modalID + '-backdrop').toggleClass('hidden flex')
}

function closeModal (modalID) {
    $('#' + modalID).toggleClass('hidden flex')
    $('#' + modalID + '-backdrop').toggleClass('hidden flex')
}

//checkboxes

function checkBoxes (response) {
    var placaInput = $('#placa')
    var cbCarro = $('#cbCarro')

    var horaSaidaInput = $('#horaSaida')
    var cbHoraSaida = $('#cbHoraSaida')

    var horaEntradaInput = $('#horaEntrada')
    var cbHoraEntrada = $('#cbHoraEntrada')

    if (response.placa) {
        showCarro()
        cbCarro.prop('checked', true)
    } else {
        hideCarro()
        cbCarro.prop('checked', false)
    }
    if (response.horaSaida) {
        showHoraSaida()
        cbHoraSaida.prop('checked', true)
    } else {
        hideHoraSaida()
        cbHoraSaida.prop('checked', false)
    }
    if (response.horaEntrada) {
        showHoraEntrada()
        cbHoraEntrada.prop('checked', true)
    } else {
        hideHoraEntrada()
        cbHoraEntrada.prop('checked', false)
    }
}

function checkBoxToggleCarro () {
    var cbCarro = $('#cbCarro')

    if (cbCarro.prop('checked')) {
        showCarro()
    } else {
        hideCarro()
    }
}

function checkBoxToggleHoraSaida () {
    var cbHoraSaida = $('#cbHoraSaida')

    if (cbHoraSaida.prop('checked')) {
        showHoraSaida()
    } else {
        hideHoraSaida()
    }
}

function checkBoxToggleHoraEntrada () {
    var cbHoraEntrada = $('#cbHoraEntrada')

    if (cbHoraEntrada.prop('checked')) {
        showHoraEntrada()
    } else {
        hideHoraEntrada()
    }
}

// Functions for the checkboxes

function showCarro () {
    var placaDiv = $('#placa')
    placaDiv.prop('readonly', false)
    placaDiv.removeClass('bg-gray-200')
}

function hideCarro () {
    var placaDiv = $('#placa')
    placaDiv.prop('readonly', true)
    placaDiv.addClass('bg-gray-200')
}

function showHoraSaida () {
    var horaSaidaDiv = $('#horaSaida')
    horaSaidaDiv.prop('readonly', false)
    horaSaidaDiv.removeClass('bg-gray-200')
}

function hideHoraSaida () {
    var horaSaidaDiv = $('#horaSaida')
    horaSaidaDiv.prop('readonly', true)
    horaSaidaDiv.addClass('bg-gray-200')
}

function showHoraEntrada () {
    var horaEntradaDiv = $('#horaEntrada')
    horaEntradaDiv.prop('readonly', false)
    horaEntradaDiv.removeClass('bg-gray-200')
}

function hideHoraEntrada () {
    var horaEntradaDiv = $('#horaEntrada')
    horaEntradaDiv.prop('readonly', true)
    horaEntradaDiv.addClass('bg-gray-200')
}

function setCurrentTime (id) {
    var horaEntradaInput = document.getElementById(id)
    var currentDate = new Date()
    var currentHour = currentDate.getHours()
    var currentMinute = currentDate.getMinutes()
    var formattedTime =
        (currentHour < 10 ? '0' : '') +
        currentHour +
        ':' +
        (currentMinute < 10 ? '0' : '') +
        currentMinute
    horaEntradaInput.value = formattedTime
}

function setCurrentDate (id) {
    var dataEntradaInput = document.getElementById(id)
    var currentDate = new Date()

    // Format the date as "yyyy-MM-dd"
    var formattedDate = currentDate.toISOString().split('T')[0]

    dataEntradaInput.value = formattedDate
}

//ajax add acesso

function adicionarAcesso (event, url) {
    event.preventDefault()

    var horaEntradaInput = document.getElementById('horaEntrada')

    if (horaEntradaInput.value == null || horaEntradaInput.value == '') {
        setCurrentTime('horaEntrada')
    }

    url = url + '/controleDeAcesso/add'

    var formData = $('#formAddAcesso').serialize()

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            closeModal('modal-id-add')
            $('#formAddAcesso')[0].reset()
            location.reload()
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })
}

function atualizarAcesso (event, url) {
    event.preventDefault()

    var horaEntradaInput = document.getElementById('horaEntrada')

    var id = document.getElementById('id')

    if (horaEntradaInput.value == null || horaEntradaInput.value == '') {
        setCurrentTime('horaEntrada')
    }

    url = url + '/controleDeAcesso/' + id.value


    var formData = $('#formAddAcesso').serialize()

    $.ajax({
        url: url,
        type: 'PUT',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            closeModal('modal-id-add')
            $('#formAddAcesso')[0].reset()
            location.reload()
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })
}

function mostrarAcesso (url, list) {
    let datalist = $('#divNomeAcessos')
    datalist.empty()

    $.ajax({
        url: url,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {

            if (!list) {
                $('#formAddAcesso')[0].reset()
                toggleModal('modal-id-add', true)

                $('#id').val(response.id)
                $('#horaEntrada').val(response.horaEntrada)
                $('#horaSaida').val(response.horaSaida)
                checkBoxes(response)
            }

            var cbCarro = $('#cbCarro')
            if (response.placa) {
                showCarro()
                cbCarro.prop('checked', true)
            } else {
                hideCarro()
                cbCarro.prop('checked', false)
            }

            $('#nome').val(response.nome)
            $('#rgCpf').val(response.rgCpf)
            $('#transportadora').val(response.transportadora)
            $('#setorResponsavel').val(response.setorResponsavel)
            $('#pessoaResponsavel').val(response.pessoaResponsavel)

            $('#placa').val(response.placa)
        },
        error: function (error) {
            console.log(error)
        }
    })
}

function deletarAcesso (url) {
    $.ajax({
        url: url,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            location.reload()
        },
        error: function (error) {
            console.log(error)
        }
    })
}

function registrarHoraSaida (id) {
    $('#formRegistrarSaida')[0].reset()
    toggleModal('modal-id-reg')
    $('#idReg').val(id)
    setCurrentTime('horaSaidaReg')
    setCurrentDate('dataSaidaReg')
}

function registrarSaidaAcesso (event, url) {
    event.preventDefault()

    var id = document.getElementById('idReg')
    var formData = $('#formRegistrarSaida').serialize()

    url = url + '/controleDeAcesso/reg/' + id.value

    $.ajax({
        url: url,
        type: 'PUT',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            closeModal('modal-id-reg')
            $('#formRegistrarSaida')[0].reset()
            location.reload()
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })
}


function buscarpessoas(url) {
    let query = $('#pessoaResponsavel').val()
    setor = $('#setorResponsavel').val()


    if (query != '' || query != ' ' && setor != '' || setor != ' ') {

        fetchSuggestionsPessoas(url, query)
        
    }
}

function fetchSuggestionsPessoas(url, query) {


    setor = $('#setorResponsavel').val()


    if (query == null || query == '' || query == ' ') {
        query = '*'
    }

    if (query != null && setor != null) {
        url = `${url}/controleDeAcesso/getPessoasAcessos/${query}/${setor}`

        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                updateDatalistPessoas(data)
            },
            error: function (error) {
                console.error('Error fetching data:', error)
            }
        })
    }

}

function updateDatalistPessoas (suggestions) {
    let datalist = $('#PessoaResponsavelDataList')
    datalist.empty()


    if (Array.isArray(suggestions)) {
        let uniqueNamesSet = new Set()

        let uniqueSuggestions = suggestions.filter(obj => {
            if (!uniqueNamesSet.has(obj.pessoaResponsavel)) {
                uniqueNamesSet.add(obj.pessoaResponsavel)
                return true
            }
            return false
        })

        

        uniqueSuggestions.forEach(function (suggestion) {

            datalist.append(`<option value="${suggestion.pessoaResponsavel}">`)
        })
    }
}



//buscar setores

function buscarsetores (url) {
    let query = $('#setorResponsavel').val()
    empresa = $('#transportadora').val()


    if (query != '' || query != ' ' && empresa != '' || empresa != ' ') {

        fetchSuggestionsSetores(url, query)
        
    }

}

function fetchSuggestionsSetores (url, query) {
    empresa = $('#transportadora').val()


    if (query == null || query == '' || query == ' ') {
        query = '*'
    }

    if (query != null && empresa != null) {
        url = `${url}/controleDeAcesso/getSetoresAcessos/${query}/${empresa}`

        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                updateDatalistSetores(data)
            },
            error: function (error) {
                console.error('Error fetching data:', error)
            }
        })
    }
}

function updateDatalistSetores (suggestions) {
    let datalist = $('#SetorResponsavelDataList')
    datalist.empty()

    if (Array.isArray(suggestions)) {
        let uniqueNamesSet = new Set()

        let uniqueSuggestions = suggestions.filter(obj => {
            if (!uniqueNamesSet.has(obj.setorResponsavel)) {
                uniqueNamesSet.add(obj.setorResponsavel)
                return true
            }
            return false
        })

        

        uniqueSuggestions.forEach(function (suggestion) {

            datalist.append(`<option value="${suggestion.setorResponsavel}">`)
        })
    }
}

//buscar empresas

function buscarempresas (url) {
    let query = $('#transportadora').val()
    fetchSuggestionsEmpresas(url, query)
}

function fetchSuggestionsEmpresas (url, query) {
    url = url + '/controleDeAcesso/getEmpresasAcessos/' + query

    $.ajax({
        url: url,
        method: 'GET',
        success: function (data) {
            updateDatalistEmpresas(data)
        },
        error: function (error) {
            console.error('Error fetching data:', error)
        }
    })
}

function updateDatalistEmpresas (suggestions) {
    let datalist = $('#empresasDatalist')
    datalist.empty()

    if (Array.isArray(suggestions)) {
        let uniqueNamesSet = new Set()

        // Use filter to create a new array with unique objects based on 'nome'
        let uniqueSuggestions = suggestions.filter(obj => {
            if (!uniqueNamesSet.has(obj.transportadora)) {
                uniqueNamesSet.add(obj.transportadora)
                return true
            }
            return false
        })

        uniqueSuggestions.forEach(function (suggestion) {

            datalist.append(`<option value="${suggestion.transportadora}">`)
        })
    }
}

//get nomes

function pegarAcessoNomes (url) {
    let query = $('#nome').val()
    fetchSuggestions(url, query)
}

function fetchSuggestions (url, query) {
    url = url + '/controleDeAcesso/getNomeAcessos/' + query

    $.ajax({
        url: url,
        method: 'GET',
        success: function (data) {
            updateDatalist(data)
        },
        error: function (error) {
            console.error('Error fetching data:', error)
        }
    })
}

function updateDatalist (suggestions) {
    let datalist = $('#divNomeAcessos')

    // Remove existing child elements
    datalist.empty()

    // Check if suggestions is an array
    if (Array.isArray(suggestions)) {
        let uniqueNamesSet = new Set()

        // Use filter to create a new array with unique objects based on 'nome'
        let uniqueSuggestions = suggestions.filter(obj => {
            if (!uniqueNamesSet.has(obj.nome)) {
                uniqueNamesSet.add(obj.nome)
                return true
            }
            return false
        })

        datalist.append(
            '<ul id="suggestionsList" class="border rounded-md overflow-hidden shadow-md">'
        )

        uniqueSuggestions.forEach(function (suggestion) {
            datalist
                .find('#suggestionsList')
                .append(
                    `<li onclick="preencherDados(${suggestion.id})" class="py-2 px-4 cursor-pointer hover:bg-gray-100">${suggestion.nome}</li>`
                )
        })

        datalist.append('</ul>')

        // Append the new <ul> to the div
    } else {
        console.error('Invalid suggestions data:', suggestions)
    }
}

function preencherDados (id) {
    let currentURL = window.location.href

    let url = currentURL + '/' + id

    mostrarAcesso(url, true)
}
