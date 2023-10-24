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
    var placaDiv = $('#placaDiv')
    placaDiv.removeClass('hidden')
}

function hideCarro () {
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

    horaEntradaDiv.addClass('hidden')
}

function setCurrentTime() {
    var horaEntradaInput = document.getElementById('horaEntrada');
    var currentDate = new Date();
    var currentHour = currentDate.getHours();
    var currentMinute = currentDate.getMinutes();
    var formattedTime = (currentHour < 10 ? '0' : '') + currentHour + ':' + (currentMinute < 10 ? '0' : '') + currentMinute;
    horaEntradaInput.value = formattedTime;
}

//ajax add acesso

function adicionarAcesso (event, url) {
    event.preventDefault()

    var horaEntradaInput = document.getElementById('horaEntrada');

    if (horaEntradaInput.value == null || horaEntradaInput.value == '') {
        console.log('im here');
        setCurrentTime() 
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

    var horaEntradaInput = document.getElementById('horaEntrada');

    var id = document.getElementById('id');

    if (horaEntradaInput.value == null || horaEntradaInput.value == '') {
        console.log('im here');
        setCurrentTime() 
    }

    url = url + '/controleDeAcesso/' + id.value

    console.log(url);

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

function deletarAcesso(url) {
    $.ajax({
        url: url,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            
            location.reload();

        },
        error: function (error) {
            console.log(error)
        }
    })
    
}
