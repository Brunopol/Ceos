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

function toggleCarro () {
    var placaDiv = $('#placaDiv')
    placaDiv.addClass('hidden')
}

function showHoraSaida () {
    var horaSaidaDiv = $('#horaSaidaDiv')

    horaSaidaDiv.removeClass('hidden')
}

function hideHoraSaida () {
    var horaSaidaDiv = $('#horaSaidaDiv')

    horaSaidaDiv.addClass('hidden')
}

function showHoraEntrada () {
    var horaEntradaDiv = $('#horaEntradaDiv')

    horaEntradaDiv.removeClass('hidden')
}

function hideHoraEntrada () {
    var horaEntradaDiv = $('#horaEntradaDiv')
    var horaEntradaInput = $('#horaEntrada')

    horaEntradaInput.val('')
    horaEntradaDiv.toggleClass('hidden')
}

function adicionarAcesso (event, url) {
    event.preventDefault()

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
            console.log(response.message)
            closeModal('modal-id-add')
            $('#formAddAcesso')[0].reset()
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })
}

function mostrarAcesso (url) {
    $.ajax({
        url: url,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            console.log(response)
        },
        error: function (error) {
            console.log(error)
        }
    })
}
