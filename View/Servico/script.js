const form = document.getElementById("form-modal-form");

const validators = {
  nome: (val) => val.trim().length >= 2,
  required: (val) => !!val.trim()
};

const campoDescricao = {
  name: "descricao",
  label: "Descrição",
  type: "textarea",
  validate: "nome",
  maxLength: 200,
  isRequired: true,
  placeholder: "Ex.: Cliente afirmou estar ouvindo um barulho estranho ao pressionar o freio.",
  helperText: "Informe uma descrição.",
};

const campoUsuario = {
  name: "id_usuario",
  label: "Cliente",
  type: "select-search",
  validate: "required",
  isRequired: true,
  helperText: "Selecione um cliente.",
  options: [],
};

const campoVeiculo = {
  name: "id_veiculo",
  label: "Veículo",
  type: "select-search",
  validate: "required",
  isRequired: true,
  helperText: "Selecione um veículo.",
  options: [],
};

const campoEspecialidade = {
  name: "id_especialidade",
  label: "Especialidade",
  type: "select-search",
  validate: "required",
  isRequired: true,
  helperText: "Selecione uma especialidade.",
  options: [],
};

async function getUsuarios() {
  const response = await get("/usuario/listar");
  const options = [];

  if (response.status === "success") {
    response.dados.forEach((dado) => {
      options.push({
        value: dado.id,
        label: dado.nome,
      });
    });
  } else {
    showSnackbar("Falha ao carregar usuários.", "erro", 5000);
  }

  return options;
}

async function handleActionClick(id, nome = "") {
  const action = !!id ? "alterar" : "cadastrar";
  const isAlterar = action === "alterar";

  if (isAlterar) {
    campoUsuario.value = nome;
  }

  setFormModalIsLoading(true);

  const usuarioOptions = await getUsuarios();
  campoUsuario.options = usuarioOptions;

  setFormModalIsLoading(false);

  if (usuarioOptions.length > 0) {
    openFormModal({
      title: isAlterar ? `Alterar "${nome}"` : "Novo Serviço",
      onConfirm: (event) => onSubmitForm(event, action, id),
      showCloseButton: true,
      confirmButtonText: isAlterar ? "Salvar Alterações" : undefined,
      campos: [campoUsuario, campoVeiculo, campoEspecialidade, campoDescricao],
    });

    form.querySelectorAll("[data-validate]").forEach((input) => {
      function validate() {
        const tipo = input.dataset.validate;
        const valido = validators[tipo](input.value);
        setError(input, !valido);
      }
      input.removeEventListener("input", validate);
      input.addEventListener("input", validate);
    });
  }
}

function onSubmitForm(event, action, id = null) {
  event.preventDefault();

  let valido = true;

  form.querySelectorAll("[data-validate]").forEach((input) => {
    const tipo = input.dataset.validate;
    const ok = validators[tipo](input.value);
    setError(input, !ok);
    if (!ok) valido = false;
  });

  if (valido) {
    const form = event.target;
    const dados = new FormData(form);

    const nome = dados.get("nome");

    setFormModalIsLoading(true);
    post(
      `/servico/${action}`,
      new URLSearchParams({
        ...(action === "alterar" ? { id } : {}),
        nome: nome,
      })
    ).then((response) => {
      setFormModalIsLoading(false);
      if (response.status === "error") {
        showFormModalError(response.mensagem);
      } else {
        showSnackbar(
          `Serviço ${
            action === "cadastrar" ? "cadastrado" : "alterado"
          } com sucesso!`,
          "success"
        );
        closeFormModal();
        atualizarListagem();
      }
    });
  }
}

function handleDeleteClick(id, label) {
  openDeleteModal({
    title: `Deletar servico "${label}"?`,
    confirmButtonText: "Sim, deletar servico",
    text: `Tem certeza de que deseja deletar o servico "${label}"?\nTodos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.`,
    onConfirm: () => handleDeleteConfirm(id),
  });
}

async function handleDeleteConfirm(id) {
  setDeleteModalIsLoading(true);
  post(
    "/servico/deletar",
    new URLSearchParams({
      id,
    })
  ).then((response) => {
    setDeleteModalIsLoading(false);
    if (response.status === "error") {
      showFormModalError(response.mensagem);
    } else {
      showSnackbar(`Serviço deletado com sucesso!`, "success");
      closeDeleteModal();
      atualizarListagem();
    }
  });
}

async function atualizarListagem() {
  const html = await getText("/servico/listar");
  document.getElementById("view-content").innerHTML = html;
}
