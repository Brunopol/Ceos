//--------------------TROCA TABS--------------------\\

function changeAtiveTab (event, tabID) {
    let element = event.target
    while (element.nodeName !== 'A') {
        element = element.parentNode
    }
    ulElement = element.parentNode.parentNode
    aElements = ulElement.querySelectorAll('li > a')
    tabContents = document
        .getElementById('tabs-id')
        .querySelectorAll('.tab-content > div')
    for (let i = 0; i < aElements.length; i++) {
        aElements[i].classList.remove('text-white')
        aElements[i].classList.remove('text-black')
        aElements[i].classList.remove('bg-blue-500')
        aElements[i].classList.add('bg-black')
        aElements[i].classList.add('bg-white')
        tabContents[i].classList.add('hidden')
        tabContents[i].classList.remove('block')
    }
    element.classList.remove('bg-black')
    element.classList.remove('bg-white')
    element.classList.add('text-white')
    element.classList.add('bg-blue-500')
    document.getElementById(tabID).classList.remove('hidden')
    document.getElementById(tabID).classList.add('block')
}

//--------------------CHAMA O MODEL--------------------\\

function toggleModal (modalID, userURL, referencia, date) {
    $.get(userURL, function (response) {
        $('#' + modalID).toggleClass('hidden flex')
        $('#' + modalID + '-backdrop').toggleClass('hidden flex')

        const referenceBox = document.getElementById('referenceBox')
        const dateBox = document.getElementById('dateBox')

        referenceBox.textContent = 'Ref: ' + referencia
        dateBox.textContent = formatDate(date)

        processJSONResponse(response)
    })
}

//--------------------FECHA O MODEL--------------------\\

function closeModal (modalID) {
    $('#' + modalID).toggleClass('hidden flex')
    $('#' + modalID + '-backdrop').toggleClass('hidden flex')
}

//--------------------PROCESSAR A RESPOSTA DO SERVIDOR E MANIPULAR O DOM--------------------\\

function processJSONResponse (response) {
    var tabListHeader = $('#tabs-id ul')
    var tabContents = $('#tabs-id .tab-content')

    //LIMPA O CONTEUDO ANTERIOR
    tabListHeader.empty()
    tabContents.empty()

    // MODELAGEM ABBA

    var liHtml = `
    <li class="-mb-px last:mr-0 flex-auto text-center p-1">
      <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-black bg-white"
        onclick="changeAtiveTab(event,'modelagem')">
        <i class="fas fa-space-shuttle text-base mr-1"></i> Modelagem
      </a>
    </li>
  `

    tabListHeader.append(liHtml)

    var conHtml = `
      <div class="hidden" id="modelagem">

      

        <table id="modelagemTable" class="w-full sm:max-w-xs mx-auto table-auto text-sm">
        <thead>
            <tr>
                <th class="border px-4 py-2">#ID</th>
                <th class="border px-4 py-2">REF</th>
                <th class="border px-4 py-2">CLIENTE</th>
                <th class="border px-4 py-2">DATA</th>
                <th class="border px-4 py-2">DESEN</th>
                <th class="border px-4 py-2">TIPO PEÇA</th>
                <th class="border px-4 py-2">QTD</th>
                <th class="border px-4 py-2">MODELISTA</th>
                <th class="border px-4 py-2">TECIDO</th>
                <th class="border px-4 py-2">LAVANDERIA</th>
                <th class="border px-4 py-2">OBS</th>
            </tr>
        </thead>
        

        </table>

        
      
      </div>
    `

    tabContents.append(conHtml)

    $.each(response.modelagemData, function (index, mod) {
        var conteudoModelagem = `

            <tr>
                <td class="border px-4 py-2"> ${mod.id} </td>
                <td class="border px-4 py-2"> ${mod.referencia} </td>
                <td class="border px-4 py-2"> ${mod.cliente} </td>
                <td class="border px-4 py-2"> ${mod.datacad} </td>
                <td class="border px-4 py-2"> ${mod.desen} </td>
                <td class="border px-4 py-2"> ${mod.tipopeca} </td>
                <td class="border px-4 py-2"> ${mod.quantidade} </td>
                <td class="border px-4 py-2"> ${mod.modelista} </td>
                <td class="border px-4 py-2"> ${mod.tecido} </td>
                <td class="border px-4 py-2"> ${mod.lavanderia} </td>
                <td class="border px-4 py-2"> ${mod.observacoes} </td>
            </tr>
        
        `

        $('#modelagemTable').append(conteudoModelagem)
    })

    //LOOP DOS MOVIMENTOS
    $.each(response.movimentos, function (index, movimento) {
        var movimentoId = movimento.id
        var movimentoNome = movimento.nome
        var movimentoLargura = movimento.largura
        var movimentoTecido = movimento.tecido
        var movimentoParImper = movimento.parImper
        var movimentoCreatedAt = formatDate(movimento.created_at)
        var movimentoNotas = movimento.notas

        //LISTA DO MOVIMENTOS (HEADER)
        var liHtml = `
      <li class="-mb-px last:mr-0 flex-auto text-center p-1">
        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-black bg-white"
          onclick="changeAtiveTab(event,'${movimentoId}')">
          <i class="fas fa-space-shuttle text-base mr-1"></i> ${movimentoNome}
        </a>
      </li>
    `

        tabListHeader.append(liHtml)

        //CONTEUDO DO MOVIMENTO (CONTENT)
        var conHtml = `
        <div class="hidden" id="${movimentoId}">
            <form id="form${movimentoId}">
                <!-- Form inputs -->
                <input type="hidden" id="encaixeID">

                <div class="p-6 flex-auto grid grid-cols-2 gap-4">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Movimento</label>
                            <input type="text" id="nome" name="nome" class="form-control" value="${movimentoNome}">
                        </div>

                        <div class="flex flex-col">
                            <label for="largura" class="block text-sm font-medium text-gray-700">Largura</label>
                            <input type="text" id="largura" name="largura" class="form-control" value="${movimentoLargura}">
                        </div>

                        <div class="flex flex-col">
                            <label for="tecido" class="block text-sm font-medium text-gray-700">Tecido</label>
                            <input type="text" id="tecido" name="tecido" class="form-control" value="${movimentoTecido}">
                        </div>

                        <div class="flex flex-col">
                            <label for="parImper" class="block text-sm font-medium text-gray-700">ParImpar</label>
                            <input type="text" id="parImper" name="parImper" class="form-control" value="${movimentoParImper}">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col col-span-2">
                            <label for="notas" class="block text-sm font-medium text-gray-700">Notas</label>
                            <textarea id="notas" name="notas" class="form-control" rows="4">${movimentoNotas}</textarea>
                        </div>
                    </div>
                
                </div>

                <div class="p-6 flex-auto grid grid-cols-4 gap-4" id="conteudo${movimentoId}">
                
                </div>

                <div class="p-6 flex-auto grid grid-cols-2 gap-4" id="conteudoFooter">
                
                </div>
            </form>
        </div>

    
    `

        tabContents.append(conHtml)

        var tab2Contents = $('#form' + movimentoId + ' #conteudo' + movimentoId)
        var tab2ContentsFooter = $('#form' + movimentoId + ' #conteudoFooter')


        //LOOP PARA PEGAR OS CONSUMOS DO MOVIMENTO
        $.each(movimento.consumos, function (index, consumo) {
            var conConsumosHtml = `
            <div class="flex flex-col">
                <label for="consumo_nome" class="block text-sm font-medium text-gray-700">
                    <span contenteditable="true" oninput="updateInputValue(this, '${movimento.id}${consumo.id}')">${consumo.nome}</span>
                </label>
                <input type="hidden" id="${movimento.id}${consumo.id}" name="consumo_nome[]" value="${consumo.nome}">
                <input type="text" name="consumo_valor[]" class="form-control" value="${consumo.valor}">
                <button class="bg-red-100 hover:bg-red-600 text-white font-semibold py-1 px-2 rounded transition duration-300 ease-in-out focus:outline-none text-xs" type="button"
                    onclick="deletarConsumo(event, ${consumo.id}, '${window.location.origin}')"
                >
                    deletar
                </button>
            </div>
      `

            tab2Contents.append(conConsumosHtml)
        })

        //BOTÃO ADD MAIS CONSUMO
        var conConsumosAddHtml = `
            
        <div class="flex flex-col justify-center items-center">
            <button class="bg-emerald-200 text-white font-bold uppercase text-xs rounded-md shadow-sm outline-none focus:outline-none mb-1 transition-all duration-150 hover:bg-emerald-500 hover:shadow-md hover:text-white"
                onclick="AddMoreConsumos(event, ${movimentoId})"
                id="buttonAddConsumos${movimentoId}"
                style="width: 120px; height: 30px;">
                ADD + Consumos
            </button>
            <div class="flex items-center justify-center p-6 border-t border-solid border-slate-200 rounded-b">
            <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-300 ease-in-out focus:outline-none" type="button" onclick="confirmarDeletar(event, ${movimentoId}, '${movimentoNome}')">
                Deletar Movimento
            </button>
             </div>
        </div>


        `
            
        tab2ContentsFooter.append(conConsumosAddHtml)

        //BOTÃO PARA DELETAR MOVIMENTO

        var deleteMovimento = `
        <!-- Footer -->
       
        <div class="flex items-center justify-center p-6 border-t border-solid border-slate-200 rounded-b">
        <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-300 ease-in-out focus:outline-none" type="button" onclick="confirmarDeletar(event, ${movimentoId}, '${movimentoNome}')">
            Deletar Movimento
        </button>
        </div>
    
      
      `
      //tab2ContentsFooter.append(deleteMovimento)

        //BOTÕES SALVAR E FECHAR MODEL
        var footer = `
        <!-- Footer -->
        <div id="errorMessage" class="hidden mt-1 bg-red-500 text-white p-1 rounded-b shadow-md items-center border-t border-solid border-slate-200">
            <span>Error, prencha corretamente todos os campos</span>
        </div>
        <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
            <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="closeModal('modal-id')">
                Fechar
            </button>
            <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" onclick="updateEncaixeMovimento(event, ${movimentoId})">
                Salvar
            </button>    
        </div>
      
      `

      tab2ContentsFooter.append(footer)
    })

    //------------------PARTE PARA ADICIONAR MAIS MOVIMENTOS------------------\\

    //BOTÃO PARA ADD O MOVIMENTO NO (HEADER)
    var listPlusHtml = `
    <li class="-mb-px last:mr-0 flex-auto text-center p-1">
        <a class="text-xs font-semibold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-white bg-blue-500 hover:shadow-lg"
            onclick="changeAtiveTab(event,'addMovimento')">
            <i class="fas fa-space-shuttle text-base mr-1"></i> ADD+
        </a>
    </li>
  `

    tabListHeader.prepend(listPlusHtml)

    //CONTEUDO DO NOVO MOVIMENTO
    var conPlusHtml = `
      <div class="" id="addMovimento">
       
        <form id="formAddMovimento">
          
              <div class="relative p-6 flex-auto grid grid-cols-2 gap-4" id="conteudoAddMovimento">
              <!-- Form inputs -->
              <input type="hidden" id="encaixeID" name="encaixeID" value="${response.id}">
              <div class="flex flex-col">
                  <label for="nome" class="block text-sm font-medium text-gray-700">Movimento</label>
                  <input type="text" id="nome" name="nome" class="form-control" value="">
              </div>
              <div class="flex flex-col">
                  <label for="largura" class="block text-sm font-medium text-gray-700">Largura</label>
                  <input type="text" id="largura" name="largura" class="form-control" value="">
              </div>
              <div class="flex flex-col">
                  <label for="tecido" class="block text-sm font-medium text-gray-700">Tecido</label>
                  <input type="text" id="tecido" name="tecido" class="form-control" value="">
              </div>
              <div class="flex flex-col">
                  <label for="parImper" class="block text-sm font-medium text-gray-700">Par/Impar</label>
                  <input type="text" id="parImper" name="parImper" class="form-control" value="">
              </div>

              <div class="flex flex-col col-span-2">
              <label for="notas" class="block text-sm font-medium text-gray-700">Notas</label>
              <textarea id="notas" name="notas" class="form-control" rows="4"></textarea>
             </div>
              
          </div>

      </form>
      
      </div>
    `

    tabContents.append(conPlusHtml)

    //ADD MAIS CONSUMOS PARA O MOVIMENTO NOVO
    tabAddContentsForm = $('#conteudoAddMovimento')

    var conConsumosAddHtml = `
            <button class="items-center col-span-2 bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                onclick="AddMoreConsumosOnTheAddMovimentos(event)"
                id="buttonAddConsumosMovimentoNovo"
                style="width: 263px; height: 30px;">
                ADD + consumos
            </button>
        `

    tabAddContentsForm.append(conConsumosAddHtml)

    //SÓ PARA ARRUMAR O FRONTEND COLOCAR PARA ESQUERDA
    var blankSpace = `
       
        <div  class="hidden mt-1 bg-red-500 text-white p-1 rounded-b shadow-md items-center border-t border-solid border-slate-200">
        </div>
        <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
        </div>
        
      `

    tabAddContentsForm.append(blankSpace)

    //SALVAR E FECHAR PARA O MOVIMENTO NOVO
    var footer = `
        <!-- Footer -->
        <div id="errorMessage" class="hidden mt-1 bg-red-500 text-white p-1 rounded-b shadow-md items-center border-t border-solid border-slate-200">
            <span>Error, prencha corretamente todos os campos</span>
        </div>
        <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
            <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="closeModal('modal-id')">
                Fechar
            </button>
            <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" onclick="addEncaixeMovimento(event)">
                Salvar
            </button>    
        </div>
      
      `

    tabAddContentsForm.append(footer)
}

//--------------------ADD MAIS CONSUMOS (dinamico)--------------------\\

function AddMoreConsumos (event, movimentoId) {
    event.preventDefault()

    var tab2Contents = $('#conteudo' + movimentoId)


    randomNumForId = Math.floor(Math.random() * (100 - 1)) + 1
    randomNumForId2 = Math.floor(Math.random() * (100 - 1)) + 1

    var conConsumosAddHtml = `
    
    <div class="flex flex-col">
        <label for="consumo_nome" class="block text-sm font-medium text-gray-700">
            <span contenteditable="true" oninput="updateInputValue(this, '${
                randomNumForId + randomNumForId2
            }')">Consumo</span>
        </label>
        <input type="hidden" id="${
            randomNumForId + randomNumForId2
        }" name="consumo_nome[]" value="Consumo">
        <input type="text" name="consumo_valor[]" class="form-control" value="">
    </div>
    
    `

    tab2Contents.append(conConsumosAddHtml)
}

//--------------------ADD MAIS CONSUMOS NO MOVIEMTNO NOVO (dinamico)--------------------\\

function AddMoreConsumosOnTheAddMovimentos (event) {
    event.preventDefault()

    var tabAddContentsForm = $('#buttonAddConsumosMovimentoNovo')

    randomNumForId = Math.floor(Math.random() * (100 - 1)) + 1
    randomNumForId2 = Math.floor(Math.random() * (100 - 1)) + 1

    var conConsumosAddHtml = `
    
    <div class="flex flex-col">
        <label for="consumo_nome" class="block text-sm font-medium text-gray-700">
            <span contenteditable="true" oninput="updateInputValue(this, '${
                randomNumForId + randomNumForId2
            }')">Consumo</span>
        </label>
        <input type="hidden" id="${
            randomNumForId + randomNumForId2
        }" name="consumo_nome[]" value="Consumo">
        <input type="text" name="consumo_valor[]" class="form-control" value="">
    </div>
    
    `

    tabAddContentsForm.before(conConsumosAddHtml)
}

//--------------------AJAX PARA MANDAR PARA O SERVIDOR O MOVIMENTO NOVO--------------------\\

function addEncaixeMovimento (event) {
    event.preventDefault()

    var formData = $('#formAddMovimento').serialize()

    $.ajax({
        url: '/encaixeMovimento',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message)

            closeModal('modal-id')

            $('#formAddMovimento')[0].reset()

            toggleModal(
                'modal-id',
                response.url,
                response.referencia,
                response.created_at
            )
        },
        error: function (error) {
            showNotification(error.responseJSON.message)
        }
    })
}

//--------------------ATUALIZAR OS MOVIMENTOS EXISTENTES--------------------\\

function updateEncaixeMovimento (event, movimentoId) {
    event.preventDefault()

    var formData = $('#form' + movimentoId).serialize()

    $.ajax({
        url: '/encaixes/' + movimentoId,
        type: 'PUT',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message)

            closeModal('modal-id')

            $('#form' + movimentoId)[0].reset()

            toggleModal(
                'modal-id',
                response.url,
                response.referencia,
                response.created_at
            )
        },
        error: function (error) {
            showNotification(error.responseJSON.message)
        }
    })
}

//--------------------NÃO DEIXA QUE O LABEL DO CONSUMOS FICA EM BRANCO--------------------\\

function updateInputValue (editableSpan, hiddenInputId) {
    var inputValue = editableSpan.textContent

    // PARA NÃO REMOVER TODO O LABEL
    if (inputValue.trim() === '') {
        editableSpan.textContent = 'Consumo'
    }

    var hiddenInput = $('#' + hiddenInputId)
    hiddenInput.val(inputValue)
}

//--------------------ADICIONAR ENCAIXE NOVO--------------------\\

function adicionarEncaixe (event, referencia, urlId) {
    urlId = urlId + '/encaixes/'
    event.preventDefault()
    formData = $('#formAddEncaixe').serialize()

    $.ajax({
        url: '/encaixe/',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message)

            closeModal('modal-id-add')
            toggleModal(
                'modal-id',
                urlId + response.id,
                referencia,
                response.created_at
            )

            $('#formAddEncaixe')[0].reset()
        },
        error: function (error) {
            showNotification(error.responseJSON.message)
        }
    })
}

//--------------------FORMATAR AS DATAS--------------------\\

function formatDate (inputDate) {
    const date = new Date(inputDate)

    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')
    const year = date.getFullYear()

    const hours = String(date.getHours()).padStart(2, '0')
    const minutes = String(date.getMinutes()).padStart(2, '0')
    const seconds = String(date.getSeconds()).padStart(2, '0')

    const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`
    return formattedDate
}

//--------------------DELETAR MOVIMENTO--------------------\\

function confirmarDeletar (event, movimentoId, movimentoNome) {
    event.preventDefault()
    if (
        confirm(
            'Tem certeza que você quer deletar o movimento (' +
                movimentoNome +
                ')?'
        )
    ) {
        deletarMovimento(event, movimentoId)
    }
}

function deletarMovimento (event, movimentoId) {
    event.preventDefault()

    $.ajax({
        url: '/encaixeMovimento/' + movimentoId,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message)

            closeModal('modal-id')
            toggleModal(
                'modal-id',
                response.url,
                response.referencia,
                response.created_at
            )
        },
        error: function (error) {
            showNotification(error.responseJSON.message)
        }
    })
}

//--------------------DELETAR ENCAIXE--------------------\\

function deletarEncaixeConfirmar (encaixeNome, url) {
    if (
        confirm(
            'Tem certeza que você quer deletar o encaixe (' + encaixeNome + ')?'
        )
    ) {
        deletarEncaixe(url)
    }
}

function deletarEncaixe (url) {
    $.ajax({
        url: url,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message)
        },
        error: function (error) {
            showNotification(error.responseJSON.message)
        }
    })
}

//--------------------DELETAR CONSUMO--------------------\\

function deletarConsumo (event, consumoID, url) {
    event.preventDefault()

    url = url + '/encaixeConsumo/' + consumoID

    $.ajax({
        url: url,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message)
            closeModal('modal-id')
            toggleModal(
                'modal-id',
                response.url,
                response.referencia,
                response.created_at
            )
        },
        error: function (error) {
            showNotification(error.responseJSON.message)
        }
    })
}

//--------------------NOTIFICAÇÕES--------------------\\

function showNotification (message) {
    var notification = $('<div>', {
        class: 'fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded-md shadow-md',
        text: message
    }).appendTo('body')

    setTimeout(function () {
        notification.fadeOut(300, function () {
            $(this).remove()
        })
    }, 5000)
}
