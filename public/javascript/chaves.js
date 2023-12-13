function toggleModal (modalID, editar) {
    $('#formAddChave')[0].reset()
    $('#' + modalID).toggleClass('hidden flex')
    $('#' + modalID + '-backdrop').toggleClass('hidden flex')

    if (editar) {
        $('#modalTitleRg').text('EDITAR CHAVE')

        var btnRegistrar = $('#btnRegistrar')
        var btnAtualizar = $('#btnAtualizar')
        btnRegistrar.addClass('hidden')
        btnAtualizar.removeClass('hidden')
    } else {
        $('#modalTitleRg').text('REGISTRAR CHAVE')
        $('#btnRegistrar').removeClass('hidden')
        $('#btnAtualizar').addClass('hidden')

        hideHoraSaida()
        hideHoraEntrada()
        setCurrentTime('horaEntrada')
    }
}

// checkbox hora entrada

function checkBoxToggleHoraEntrada () {
    var cbHoraEntrada = $('#cbHoraEntrada')

    if (cbHoraEntrada.prop('checked')) {
        showHoraEntrada()
    } else {
        hideHoraEntrada()
    }
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

// checkbox hora saida

function checkBoxToggleHoraSaida () {
    var cbHoraSaida = $('#cbHoraSaida')

    if (cbHoraSaida.prop('checked')) {
        showHoraSaida()
    } else {
        hideHoraSaida()
    }
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

// Registrar chave

function registrarChave (event, url) {
    event.preventDefault()

    id = $('#idAcesso').val()

    url = url + '/chaves/add'

    var formData = $('#formAddChave').serialize()

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            toggleModal('modal-id-add')
            $('#formAddChave')[0].reset()
            location.reload()
        },
        error: function (error) {
            console.log(error)
        }
    })
}

// registrar hora saida

function registrarHoraSaida (id) {
    $('#formRegistrarSaida')[0].reset()
    toggleModal('modal-id-reg')
    $('#idReg').val(id)
    setCurrentTime('horaSaidaRegistraSaida')
    setCurrentDate('dataSaidaRegistarSaida')
}

function registrarSaidaAcesso (event, url) {
    event.preventDefault()

    var id = document.getElementById('idReg')
    var formData = $('#formRegistrarSaida').serialize()

    url = url + '/chaves/reg/' + id.value

    $.ajax({
        url: url,
        type: 'PUT',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            toggleModal('modal-id-reg')
            $('#formRegistrarSaida')[0].reset()
            location.reload()
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })
}

// horarios

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

// editar chaves

function showChave (event, id) {
    event.preventDefault()

    url = window.location.href

    url = url + '/' + id

    $.ajax({
        url: url,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            toggleModal('modal-id-add', true)

            hideHoraEntrada()
            hideHoraSaida()

            $('#idAcesso').val(response.id)

            $('#nomePessoai').val(response.nomePessoa)
            $('#nomeChavei').val(response.nomeChave)
            $('#horaEntrada').val(response.novaHoraEntrada)
            $('#horaSaida').val(response.novaHoraSaida)
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })
}

function atualizarChave (event, url) {
    event.preventDefault()

    url = url + '/chaves'

    var formData = $('#formAddChave').serialize()

    $.ajax({
        url: url,
        type: 'PUT',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            location.reload()
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })
}

//sugestoes

function mostrarSugestoesChave () {
    url = window.location.href

    input = $('#nomeChavei').val()

    url = url + '/nomeChaveSugestao/' + input

    $.ajax({
        url: url,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            updateDatalistChaves(response)
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })
}

function updateDatalistChaves (suggestions) {
    let datalist = $('#nomeChaveDatalist')
    datalist.empty()

    if (Array.isArray(suggestions)) {
        let uniqueNamesSet = new Set()

        let uniqueSuggestions = suggestions.filter(obj => {
            if (!uniqueNamesSet.has(obj.nomeChave)) {
                uniqueNamesSet.add(obj.nomeChave)
                return true
            }
            return false
        })

        uniqueSuggestions.forEach(function (suggestion) {
            datalist.append(`<option value="${suggestion.nomeChave}">`)
        })
    }
}

//

function buscarPessoas () {
    let query = $('#nomePessoai').val()
    empresa = $('#nomeChavei').val()

    url = window.location.href


    if (query != '' || query != ' ' && empresa != '' || empresa != ' ') {

        fetchSuggestionsPessoas(url, query)
        
    }

}

function fetchSuggestionsPessoas (url, query) {
    chave = $('#nomeChavei').val()


    if (query == null || query == '' || query == ' ') {
        query = '*'
    }

    if (query != null && chave != null) {
        url = `${url}/nomePessoaSugestao/${query}/${chave}`

        console.log(url);

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
    let datalist = $('#nomePessoaDatalist')
    datalist.empty()

    if (Array.isArray(suggestions)) {
        let uniqueNamesSet = new Set()

        let uniqueSuggestions = suggestions.filter(obj => {
            if (!uniqueNamesSet.has(obj.nomePessoa)) {
                uniqueNamesSet.add(obj.nomePessoa)
                return true
            }
            return false
        })

        

        uniqueSuggestions.forEach(function (suggestion) {

            datalist.append(`<option value="${suggestion.nomePessoa}">`)
        })
    }
}
