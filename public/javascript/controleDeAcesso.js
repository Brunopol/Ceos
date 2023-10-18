function toggleModal (modalID) {
    $('#' + modalID).toggleClass('hidden flex')
    $('#' + modalID + '-backdrop').toggleClass('hidden flex')
}

function closeModal (modalID) {
    $('#' + modalID).toggleClass('hidden flex')
    $('#' + modalID + '-backdrop').toggleClass('hidden flex')
}

function toggleCarro () {
    var placaDiv = $('#placaDiv')
    var placaInput = $('#placa')

    placaInput.val('')
    placaDiv.toggleClass('hidden')
}

function toggleHoraSaida () {
    var horaSaidaDiv = $('#horaSaidaDiv')
    var horaSaidaInput = $('#horaSaida')

    horaSaidaInput.val('')
    horaSaidaDiv.toggleClass('hidden')
}

function toggleHoraEntrada () {
    var horaEntradaDiv = $('#horaEntradaDiv')
    var horaEntradaInput = $('#horaEntrada')

    horaEntradaInput.val('')
    horaEntradaDiv.toggleClass('hidden')
}

function adicionarAcesso (event, url) {
    event.preventDefault()

    url = url + '/controleDeAcesso/add'

    var formData = $('#formAddAcesso').serialize()

    console.log(formData)
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
