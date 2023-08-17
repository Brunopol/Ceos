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

function toggleModal(modalID, userURL, referencia) {
  $.get(userURL, function(response) {
      $("#" + modalID).toggleClass("hidden flex");
      $("#" + modalID + "-backdrop").toggleClass("hidden flex");
      tituloEncaixeRef

      processJSONResponse(response);
  });
}

function processJSONResponse(response) {

  var tabListHeader = $("#tabs-id ul");
  var tabContents = $("#tabs-id .tab-content");

  tabListHeader.empty();
  tabContents.empty();

  
  $.each(response.movimentos, function(index, movimento) {
    var movimentoId = movimento.id;
    var movimentoNome = movimento.nome;

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

    var conHtml = 
    `
      <div class="hidden" id="${movimentoId}">
       


                  <div class="relative p-6 flex-auto grid grid-cols-2 gap-4">
                  <!-- Form inputs -->
                  <input type="hidden" id="encaixeID">
                  <div>
                      <label for="movimento" class="block text-sm font-medium text-gray-700">Movimento</label>
                      <input type="text" id="movimento" name="movimento" class="form-control" value="${movimentoNome}">
                  </div>
                  <div>
                      <label for="last_name" class="block text-sm font-medium text-gray-700">Sobrenome</label>
                      <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name">
                  </div>
                  <div>
                      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                      <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                  </div>
                  <div>
                      <label for="phone" class="block text-sm font-medium text-gray-700">Celular</label>
                      <input type="tel" id="phone" name="phone" class="form-control" placeholder="Phone">
                  </div>
                  <div>
                      <label for="ramal" class="block text-sm font-medium text-gray-700">Ramal</label>
                      <input type="text" id="ramal" name="ramal" class="form-control" placeholder="Ramal">
                  </div>

                  <!-- Footer -->
                  <div id="errorMessage" class="hidden mt-1 bg-red-500 text-white p-1 rounded-b shadow-md items-center border-t border-solid border-slate-200">
                      <span>Error, prencha corretamente todos os campos</span>
                  </div>
                  <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                      <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="closeModal('modal-id')">
                          Fechar
                      </button>
                      <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" onclick="updateUser(event)">
                          Salvar
                      </button>    
                  </div>
              </div>



      </div>
    `

    tabContents.append(conHtml);
        
  });
}

function closeModal(modalID) {
  $("#" + modalID).toggleClass("hidden flex");
  $("#" + modalID + "-backdrop").toggleClass("hidden flex");
}
