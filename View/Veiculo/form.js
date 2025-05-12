const fabricanteSelect = document.getElementById("select_fabricante_veiculo");
fabricanteSelect?.addEventListener("change", (event) => {
  modeloSelect.value = "";
  
  const idFabricanteVeiculo = event.target.value;
  getModelos(idFabricanteVeiculo);
});

const modeloSelect = document.getElementById("select_modelo_veiculo");

async function getModelos(idFabricanteVeiculo) {
  if(!!idFabricanteVeiculo) {
    get(`/modelo-veiculo?id_fabricante_veiculo=${idFabricanteVeiculo}`).then(response => {
      renderModeloSelectOptions(response.dados);
    })
  }
}

function renderModeloSelectOptions(modelos = []) {
  if(!!modeloSelect) {
    modeloSelect.innerHTML = "";
    modeloSelect.value = "";

    const placeholder = document.createElement("option");
    placeholder.disabled = true;
    placeholder.selected = true;
    placeholder.innerText = "Selecione"
    placeholder.value = "";

    modeloSelect.appendChild(placeholder);

    modelos.forEach(modelo => {
      const option = document.createElement("option");
      option.value = modelo.id;
      option.innerText = modelo.nome;

      modeloSelect.appendChild(option);
    })

    modeloSelect.disabled = false;
  }
}