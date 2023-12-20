function toggleModal (modalID, userURL) {
    $.get(userURL, function (data) {
        $('#userId').val(data.id)
        $('#name').val(data.name)
        $('#last_name').val(data.last_name)
        $('#email').val(data.email)
        $('#phone').val(data.phone)
        $('#ramal').val(data.ramal)

        // Check fixed checkboxes
        $('#controleDeAcessosCheckbox').prop(
            'checked',
            data.permissions.some(
                permission => permission.permission === 'controleDeAcessos'
            )
        )
        $('#usersCheckbox').prop(
            'checked',
            data.permissions.some(
                permission => permission.permission === 'users'
            )
        )
        $('#encaixeCheckbox').prop(
            'checked',
            data.permissions.some(
                permission => permission.permission === 'encaixe'
            )
        )
        $('#encaixeVisualizarCheckbox').prop(
            'checked',
            data.permissions.some(
                permission => permission.permission === 'encaixeVisualizar'
            )
        )
        $('#chavesCheckbox').prop(
            'checked',
            data.permissions.some(
                permission => permission.permission === 'chaves'
            )
        )
        $('#controleDeFrotasCheckbox').prop(
            'checked',
            data.permissions.some(
                permission => permission.permission === 'controleDeFrotas'
            )
        )

        // Show the modal using the toggleModal function
        $('#' + modalID).toggleClass('hidden flex')
        $('#' + modalID + '-backdrop').toggleClass('hidden flex')
    })
}

function closeModal (modalID) {
    $('#' + modalID).toggleClass('hidden flex')
    $('#' + modalID + '-backdrop').toggleClass('hidden flex')
}

function updateUser (event) {
    // Prevent the default form submission behavior
    event.preventDefault()

    var formData = $('#updateUserForm').serialize()
    var userId = $('#userId').val()

    $.ajax({
        url: '/v4/users/' + userId,
        type: 'PUT',
        data: formData,
        success: function (response) {
            // Display success message
            $('#successMessage').removeClass('hidden') // Show the success div

            // Hide the modal
            closeModal('modal-id')

            // Optional: You can clmostrarSolicitacaoear the form inputs if needed
            $('#updateUserForm')[0].reset()
        },
        error: function (error) {
            // Handle error here
            console.log(error)
            $('#errorMessage').removeClass('hidden') // Show the success div
        }
    })
}

function mostrarSolicitacao (id, idSolicitacaoNum, userName, motivo) {
    var url = window.location.href

    var nome = $('#formNome')
    var rgCpf = $('#formRgCpf')
    var empresa = $('#formEmpresa')
    var setorResponsavel = $('#formSetorResponsavel')
    var pessoaResponsavel = $('#formPessoaResponsavel')
    var placa = $('#formPlaca')
    var horaEntrada = $('#formHoraEntrada')
    var horaSaida = $('#formHoraSaida')
    var userNameinput = $('#nomeAcesso')
    var motivoinput = $('#formMotivo')

    var idAcesso = $('#idAcesso')
    var idSolicitacao = $('#idSolicitacao')

    idAcesso.val('')
    idSolicitacao.val('')

    nome.val('')
    rgCpf.val('')
    empresa.val('')
    setorResponsavel.val('')
    pessoaResponsavel.val('')
    placa.val('')
    horaEntrada.val('')
    horaSaida.val('')
    userNameinput.val('')
    motivoinput.val('')

    url = url + '/controleDeAcesso/' + id

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            nome.val(response.nome)
            rgCpf.val(response.rgCpf)
            empresa.val(response.transportadora)
            setorResponsavel.val(response.setorResponsavel)
            pessoaResponsavel.val(response.pessoaResponsavel)
            placa.val(response.placa)
            horaEntrada.val(response.horaEntrada)
            horaSaida.val(response.horaSaida)
            userNameinput.val(userName)
            motivoinput.val(motivo)

            idAcesso.val(id)
            idSolicitacao.val(idSolicitacaoNum)

            toggleModalDelete('modal-id-delete')
        },
        error: function (error) {
            // Handle error here
            console.log(error)
            $('#errorMessage').removeClass('hidden') // Show the success div
        }
    })
}

function restaurarExclusao (event, url) {
    event.preventDefault()

    var formData = $('#restaurarForm').serialize()

    url = url + '/users/restaurarAcesso'

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (response) {
            toggleModalDelete('modal-id-delete')
            location.reload()
            showNotification(response.message)
        },
        error: function (error) {
            console.log(error)
        }
    })
}

function toggleModalDelete (modalID) {
    $('#' + modalID).toggleClass('hidden flex')
    $('#' + modalID + '-backdrop').toggleClass('hidden flex')
}

//--------------------NOTIFICAÇÕES--------------------\\

function showNotification (message) {
    var notification = $('<div>', {
        class: 'fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded-md shadow-md z-50',
        text: message
    }).appendTo('body')

    setTimeout(function () {
        notification.fadeOut(300, function () {
            $(this).remove()
        })
    }, 5000)
}
