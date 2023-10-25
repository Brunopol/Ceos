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

    horaEntradaDiv.addClass('hidden')
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

//ajax add acesso

function adicionarAcesso (event, url) {
    event.preventDefault()

    var horaEntradaInput = document.getElementById('horaEntrada')

    if (horaEntradaInput.value == null || horaEntradaInput.value == '') {
        console.log('im here')
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
            console.log(response.message)
            closeModal('modal-id-add')
            $('#formAddAcesso')[0].reset()
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
        console.log('im here')
        setCurrentTime('horaEntrada')
    }

    url = url + '/controleDeAcesso/' + id.value

    console.log(url)

    var formData = $('#formAddAcesso').serialize()

    $.ajax({
        url: url,
        type: 'PUT',
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

            $('#formAddAcesso')[0].reset()
            toggleModal('modal-id-add', true)

            checkBoxes(response)

            $('#nome').val(response.nome)
            $('#rgCpf').val(response.rgCpf)
            $('#transportadora').val(response.transportadora)

            $('#horaEntrada').val(response.horaEntrada)
            $('#horaSaida').val(response.horaSaida)
            $('#placa').val(response.placa)

            $('#id').val(response.id)
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
            console.log(response.message)
            closeModal('modal-id-reg')
            $('#formRegistrarSaida')[0].reset()
        },
        error: function (error) {
            console.log(error.responseJSON.message)
        }
    })

}
