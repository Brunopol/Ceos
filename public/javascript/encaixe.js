
//--------------------TROCA TABS--------------------\\

function changeAtiveTab(event,tabID){
  let element = event.target;
  while(element.nodeName !== "A"){
    element = element.parentNode;
  }
  ulElement = element.parentNode.parentNode;
  aElements = ulElement.querySelectorAll("li > a");
  tabContents = document.getElementById("tabs-id").querySelectorAll(".tab-content > div");
  for(let i = 0 ; i < aElements.length; i++){
    aElements[i].classList.remove("text-white");
    aElements[i].classList.remove("bg-blue-500");
    aElements[i].classList.add("text-pink-600");
    aElements[i].classList.add("bg-white");
    tabContents[i].classList.add("hidden");
    tabContents[i].classList.remove("block");
  }
  element.classList.remove("text-pink-600");
  element.classList.remove("bg-white");
  element.classList.add("text-white");
  element.classList.add("bg-blue-500");
  document.getElementById(tabID).classList.remove("hidden");
  document.getElementById(tabID).classList.add("block");
}

//--------------------CHAMA O MODEL--------------------\\

function toggleModal(modalID, userURL, referencia) {
  $.get(userURL, function(response) {
      $("#" + modalID).toggleClass("hidden flex");
      $("#" + modalID + "-backdrop").toggleClass("hidden flex");

      $("#tituloEncaixeRef").text("Ref: " + referencia);
    
      processJSONResponse(response);
  });
}

//--------------------FECHA O MODEL--------------------\\

function closeModal(modalID) {
  $("#" + modalID).toggleClass("hidden flex");
  $("#" + modalID + "-backdrop").toggleClass("hidden flex");
}

//--------------------PROCESSAR A RESPOSTA DO SERVIDOR E MANIPULAR O DOM--------------------\\

function processJSONResponse(response) {

  var tabListHeader = $("#tabs-id ul");
  var tabContents = $("#tabs-id .tab-content");

  //LIMPA O CONTEUDO ANTERIOR
  tabListHeader.empty();
  tabContents.empty();

  //LOOP DOS MOVIMENTOS
  $.each(response.movimentos, function(index, movimento) {
    var movimentoId = movimento.id;
    var movimentoNome = movimento.nome;
    var movimentoLargura = movimento.largura;
    var movimentoTecido = movimento.tecido;
    var movimentoQuantidade = movimento.quantidade;
    var movimentoParImper = movimento.parImper;
    var movimentoCreatedAt = movimento.created_at;    

    //LISTA DO MOVIMENTOS (HEADER)
    var liHtml = 
    `
      <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-pink-600 bg-white"
          onclick="changeAtiveTab(event,'${movimentoId}')">
          <i class="fas fa-space-shuttle text-base mr-1"></i> ${movimentoNome}
        </a>
      </li>
    `;

    tabListHeader.append(liHtml);

    //CONTEUDO DO MOVIMENTO (CONTENT)
    var conHtml = 
    `
      <div class="hidden" id="${movimentoId}">
       
        <form id="form${movimentoId}">
          
              <div class="relative p-6 flex-auto grid grid-cols-2 gap-4">
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
                  <input type="text" id="created_at" name="created_at" class="form-control" value="${movimentoCreatedAt}">
              </div>

              
          </div>

      </form>
      
      </div>
    `

    tabContents.append(conHtml);

    var tab2Contents = $("#form" + movimentoId);

    //LOOP PARA PEGAR OS CONSUMOS DO MOVIMENTO
    $.each(movimento.consumos, function(index, consumo) {

      
      var conConsumosHtml = 
      `
        <div>
          <label for="consumo_nome" class="block text-sm font-medium text-gray-700">consumo_nome</label>
          <input type="text" id="consumo_nome" name="consumo_nome[]" class="form-control" value="${consumo.nome}">
        </div>
        <div>
          <label for="consumo_valor" class="block text-sm font-medium text-gray-700">consumo_valor</label>
          <input type="text" id="consumo_valor" name="consumo_valor[]" class="form-control" value="${consumo.valor}">
        </div>
      
      `

      tab2Contents.append(conConsumosHtml);

    });

    //BOTÃO ADD MAIS CONSUMO
    var conConsumosAddHtml = 
    `
      <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" onclick="AddMoreConsumos(event, ${movimentoId})" id="buttonAddConsumos${movimentoId}">
                  ADD + consumos
      </button> 
    `

    tab2Contents.append(conConsumosAddHtml);

    //BOTÕES SALVAR E FECHAR MODEL
    var footer = 
      `
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

    tab2Contents.append(footer);

    
  });

  //------------------PARTE PARA ADICIONAR MAIS MOVIMENTOS------------------\\

  //BOTÃO PARA ADD O MOVIMENTO NO (HEADER)
  var listPlusHtml = 
  `
    <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
      <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-pink-600 bg-white"
        onclick="changeAtiveTab(event,'addMovimento')">
        <i class="fas fa-space-shuttle text-base mr-1"></i> Add+
      </a>
    </li>
  `;

  tabListHeader.append(listPlusHtml);

  //CONTEUDO DO NOVO MOVIMENTO
  var conPlusHtml = 
    `
      <div class="hidden" id="addMovimento">
       
        <form id="formAddMovimento">
          
              <div class="relative p-6 flex-auto grid grid-cols-2 gap-4">
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

    tabContents.append(conPlusHtml);

    //ADD MAIS CONSUMOS PARA O MOVIMENTO NOVO
    tabAddContentsForm = $("#formAddMovimento");

    var conConsumosAddHtml = 
    `
      <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" onclick="AddMoreConsumosOnTheAddMovimentos(event)">
                  ADD + consumos
      </button> 
    `

    tabAddContentsForm.append(conConsumosAddHtml);

    //SALVAR E FECHAR PARA O MOVIMENTO NOVO
    var footer = 
      `
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

    tabAddContentsForm.append(footer);

}

//--------------------ADD MAIS CONSUMOS (dinamico)--------------------\\

function AddMoreConsumos(event, movimentoId) {
  event.preventDefault();

  var tab2Contents = $("#buttonAddConsumos" + movimentoId);

  var conConsumosHtml = 
      `
        <div>
          <label for="consumo_nome" class="block text-sm font-medium text-gray-700">consumo_nome</label>
          <input type="text" id="consumo_nome" name="consumo_nome[]" class="form-control" >
        </div>
        <div>
          <label for="consumo_valor" class="block text-sm font-medium text-gray-700">consumo_valor</label>
          <input type="text" id="consumo_valor" name="consumo_valor[]" class="form-control" >
        </div>
      
      `

  tab2Contents.before(conConsumosHtml);
}

//--------------------ADD MAIS CONSUMOS NO MOVIEMTNO NOVO (dinamico)--------------------\\

function AddMoreConsumosOnTheAddMovimentos(event) {
  event.preventDefault();

  tabAddContentsForm = $("#formAddMovimento");

  var conConsumosHtml = 
      `
        <div>
          <label for="consumo_nome" class="block text-sm font-medium text-gray-700">consumo_nome</label>
          <input type="text" id="consumo_nome" name="consumo_nome[]" class="form-control" >
        </div>
        <div>
          <label for="consumo_valor" class="block text-sm font-medium text-gray-700">consumo_valor</label>
          <input type="text" id="consumo_valor" name="consumo_valor[]" class="form-control" >
        </div>
      
      `

  tabAddContentsForm.append(conConsumosHtml);

}

//--------------------AJAX PARA MANDAR PARA O SERVIDOR O MOVIMENTO NOVO--------------------\\

function addEncaixeMovimento(event) {

  event.preventDefault();

  var formData = $('#formAddMovimento').serialize();

  $.ajax({
    url: '/encaixeMovimento',
    type: 'POST',
    data: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken 
    },
    success: function (response) {

        $('#successMessage').removeClass('hidden'); 

        closeModal('modal-id');

        $('#formAddMovimento')[0].reset();
    },
    error: function (error) {
        console.log(error);
        $('#errorMessage').removeClass('hidden'); 
        
    }
});

}

//--------------------ATUALIZAR OS MOVIMENTOS EXISTENTES--------------------\\

function updateEncaixeMovimento(event, movimentoId) {

  event.preventDefault();

  var formData = $('#form' + movimentoId).serialize();

  $.ajax({
      url: '/encaixes/' + movimentoId,
      type: 'PUT',
      data: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken 
      },
      success: function (response) {
  
          $('#successMessage').removeClass('hidden'); 
     
          closeModal('modal-id');

          $('#form' + movimentoId)[0].reset();
      },
      error: function (error) {
          console.log(error);
          $('#errorMessage').removeClass('hidden'); 
          
      }
  });
}
