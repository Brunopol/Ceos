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
        aElements[i].classList.remove('bg-blue-500')
        aElements[i].classList.add('text-pink-600')
        aElements[i].classList.add('bg-white')
        tabContents[i].classList.add('hidden')
        tabContents[i].classList.remove('block')
    }
    element.classList.remove('text-pink-600')
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

        $('#tituloEncaixeRef').text(
            'Ref: ' + referencia + ' Data: ' + formatDate(date)
        )

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

    //LOOP DOS MOVIMENTOS
    $.each(response.movimentos, function (index, movimento) {
        var movimentoId = movimento.id
        var movimentoNome = movimento.nome
        var movimentoLargura = movimento.largura
        var movimentoTecido = movimento.tecido
        var movimentoQuantidade = movimento.quantidade
        var movimentoParImper = movimento.parImper
        var movimentoCreatedAt = formatDate(movimento.created_at)

        //LISTA DO MOVIMENTOS (HEADER)
        var liHtml = `
      <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-pink-600 bg-white"
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
          
              <div class="relative p-6 flex-auto grid grid-cols-2 gap-4" id="conteudo">
              <!-- Form inputs -->
              <input type="hidden" id="encaixeID">
              <div>
                  <label for="nome" class="block text-sm font-medium text-gray-700">Movimento</label>
                  <input type="text" id="nome" name="nome" class="form-control" value="${movimentoNome}">
              </div>
              <div>
                  <label for="largura" class="block text-sm font-medium text-gray-700">Largura</label>
                  <input type="text" id="largura" name="largura" class="form-control" value="${movimentoLargura}">
              </div>
              <div>
                  <label for="tecido" class="block text-sm font-medium text-gray-700">Tecido</label>
                  <input type="text" id="tecido" name="tecido" class="form-control" value="${movimentoTecido}">
              </div>
              <div>
                  <label for="quantidade" class="block text-sm font-medium text-gray-700">Quantidade</label>
                  <input type="number" id="quantidade" name="quantidade" class="form-control" value="${movimentoQuantidade}">
              </div>
              <div>
                  <label for="parImper" class="block text-sm font-medium text-gray-700">ParImpar</label>
                  <input type="text" id="parImper" name="parImper" class="form-control" value="${movimentoParImper}">
              </div>
              <div>
                  <label for="created_at" class="block text-sm font-medium text-gray-700">Data</label>
                  <input type="text" id="created_at" name="created_at" class="form-control" value="${movimentoCreatedAt}" readonly>
              </div>

              
          </div>

      </form>
      
      </div>
    `

        tabContents.append(conHtml)

        var tab2Contents = $('#form' + movimentoId + ' #conteudo')

        //LOOP PARA PEGAR OS CONSUMOS DO MOVIMENTO
        $.each(movimento.consumos, function (index, consumo) {
            var conConsumosHtml = `
            <div>
                <label for="consumo_nome" class="block text-sm font-medium text-gray-700">
                    <span contenteditable="true" oninput="updateInputValue(this, '${movimento.id}${consumo.id}')">${consumo.nome}</span>
                </label>
                <input type="hidden" id="${movimento.id}${consumo.id}" name="consumo_nome[]" value="${consumo.nome}">
                <input type="text" name="consumo_valor[]" class="form-control" value="${consumo.valor}">
                <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-2 rounded transition duration-300 ease-in-out focus:outline-none text-xs" type="button"
                    onclick="deletarConsumo(event, ${consumo.id}, '${window.location.origin}')"
                >
                    x
                </button>
            </div>
      `

            tab2Contents.append(conConsumosHtml)
        })

        //BOTÃO ADD MAIS CONSUMO
        var conConsumosAddHtml = `
        <button class="col-span-2 bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
            onclick="AddMoreConsumos(event, ${movimentoId})"
            id="buttonAddConsumos${movimentoId}"
            style="width: 200px; height: 30px; padding: 6px;">
            ADD + consumos
            </button>
        `

        tab2Contents.append(conConsumosAddHtml)

        //BOTÃO PARA DELETAR MOVIMENTO

        var deleteMovimento = `
        <!-- Footer -->
       
        <div class="flex items-start justify-start p-6 border-t border-solid border-slate-200 rounded-b">
        <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-300 ease-in-out focus:outline-none" type="button" onclick="confirmarDeletar(event, ${movimentoId}, '${movimentoNome}')">
            Deletar Movimento
        </button>
        </div>
    
      
      `
        tab2Contents.append(deleteMovimento)

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

        tab2Contents.append(footer)
    })

    //------------------PARTE PARA ADICIONAR MAIS MOVIMENTOS------------------\\

    //BOTÃO PARA ADD O MOVIMENTO NO (HEADER)
    var listPlusHtml = `
    <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
      <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-pink-600 bg-white"
        onclick="changeAtiveTab(event,'addMovimento')">
        <i class="fas fa-space-shuttle text-base mr-1"></i> Add+
      </a>
    </li>
  `

    tabListHeader.append(listPlusHtml)

    //CONTEUDO DO NOVO MOVIMENTO
    var conPlusHtml = `
      <div class="hidden" id="addMovimento">
       
        <form id="formAddMovimento">
          
              <div class="relative p-6 flex-auto grid grid-cols-2 gap-4" id="conteudoAddMovimento">
              <!-- Form inputs -->
              <input type="hidden" id="encaixeID" name="encaixeID" value="${response.id}">
              <div>
                  <label for="nome" class="block text-sm font-medium text-gray-700">Movimento</label>
                  <input type="text" id="nome" name="nome" class="form-control" value="">
              </div>
              <div>
                  <label for="largura" class="block text-sm font-medium text-gray-700">Largura</label>
                  <input type="text" id="largura" name="largura" class="form-control" value="">
              </div>
              <div>
                  <label for="tecido" class="block text-sm font-medium text-gray-700">Tecido</label>
                  <input type="text" id="tecido" name="tecido" class="form-control" value="">
              </div>
              <div>
                  <label for="quantidade" class="block text-sm font-medium text-gray-700">Quantidade</label>
                  <input type="number" id="quantidade" name="quantidade" class="form-control" value="">
              </div>
              <div>
                  <label for="parImper" class="block text-sm font-medium text-gray-700">ParImpar</label>
                  <input type="text" id="parImper" name="parImper" class="form-control" value="">
              </div>
              <div>
                  <label for="created_at" class="block text-sm font-medium text-gray-700">Data</label>
                  <input type="text" id="created_at" name="created_at" class="form-control" value="">
              </div>
              
          </div>

      </form>
      
      </div>
    `

    tabContents.append(conPlusHtml)

    //ADD MAIS CONSUMOS PARA O MOVIMENTO NOVO
    tabAddContentsForm = $('#conteudoAddMovimento')

    var conConsumosAddHtml = `
        <button class="col-span-2 bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
            onclick="AddMoreConsumosOnTheAddMovimentos(event)"
            id="buttonAddConsumosMovimentoNovo"
            style="width: 200px; height: 30px; padding: 6px;">
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

    var tab2Contents = $('#buttonAddConsumos' + movimentoId)

    randomNumForId = Math.floor(Math.random() * (100 - 1)) + 1
    randomNumForId2 = Math.floor(Math.random() * (100 - 1)) + 1

    var conConsumosAddHtml = `
    
    <div>
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

    tab2Contents.before(conConsumosAddHtml)
}

//--------------------ADD MAIS CONSUMOS NO MOVIEMTNO NOVO (dinamico)--------------------\\

function AddMoreConsumosOnTheAddMovimentos (event) {
    event.preventDefault()

    var tabAddContentsForm = $('#buttonAddConsumosMovimentoNovo')

    randomNumForId = Math.floor(Math.random() * (100 - 1)) + 1
    randomNumForId2 = Math.floor(Math.random() * (100 - 1)) + 1

    var conConsumosAddHtml = `
    
    <div>
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
            
            showNotification(response.message);

            closeModal('modal-id')

            $('#formAddMovimento')[0].reset()
        },
        error: function (error) {
            console.log(error)
            $('#errorMessage').removeClass('hidden')
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
           
            showNotification(response.message);

            closeModal('modal-id')

            $('#form' + movimentoId)[0].reset()
        },
        error: function (error) {
            console.log(error)
            $('#errorMessage').removeClass('hidden')
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
            
            showNotification(response.message);

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
            console.log(error)
            $('#errorMessage').removeClass('hidden')
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

function confirmarDeletar(event, movimentoId, movimentoNome) {
    event.preventDefault();
    if (confirm("Tem certeza que você quer deletar o movimento (" + movimentoNome + ")?")) {

        deletarMovimento(event, movimentoId);
    }
}

function deletarMovimento(event, movimentoId) {
    event.preventDefault();

    $.ajax({
        url: '/encaixeMovimento/' + movimentoId,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message);

            closeModal('modal-id')
        },
        error: function (error) {
            console.log(error)
            $('#errorMessage').removeClass('hidden')
        }
    })

}

//--------------------DELETAR ENCAIXE--------------------\\

function deletarEncaixeConfirmar(encaixeNome, url) {
    if (confirm("Tem certeza que você quer deletar o encaixe (" + encaixeNome + ")?")) {
        deletarEncaixe(url);
    }
}

function deletarEncaixe(url) {

    $.ajax({
        url: url,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message);
        },
        error: function (error) {
            console.log(error)
            $('#errorMessage').removeClass('hidden')
        }
    })

}

//--------------------DELETAR CONSUMO--------------------\\

function deletarConsumo(event, consumoID, url) {
    event.preventDefault();

    url = url + '/encaixeConsumo/' + consumoID;

    $.ajax({
        url: url,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            showNotification(response.message);
        },
        error: function (error) {
            console.log(error)
            $('#errorMessage').removeClass('hidden')
        }
    })
   

}

//--------------------NOTIFICAÇÕES--------------------\\

function showNotification(message) {
    var notification = $('<div>', {
        'class': 'fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded-md shadow-md',
        'text': message
    }).appendTo('body');
    
    setTimeout(function() {
        notification.fadeOut(300, function() {
            $(this).remove();
        });
    }, 5000);
}