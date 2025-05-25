const form = document.getElementById("form-modal-form");

const validators = {
  required: (val) => !!val.trim(),
  datetime: (val) => val.trim().length >= 16,
  "datetime-nullable": (val) => !val.trim() || val.trim().length >= 16
};

const _campoDescricao = {
  name: "descricao",
  label: "Descrição",
  type: "textarea",
  validate: "required",
  maxLength: 200,
  isRequired: true,
  placeholder:
    "Ex.: Cliente afirmou estar ouvindo um barulho estranho ao pressionar o freio.",
  helperText: "Informe uma descrição.",
};

const _campoUsuario = {
  name: "id_usuario",
  label: "Cliente",
  type: "select-search",
  validate: "required",
  isRequired: true,
  helperText: "Selecione um cliente.",
  options: [],
};

const _campoVeiculo = {
  name: "id_veiculo",
  label: "Veículo",
  type: "select-search",
  validate: "required",
  isRequired: true,
  helperText: "Selecione um veículo.",
  disabled: true,
  options: [],
};

const _campoDataInicio = {
  name: "data_inicio",
  label: "Quando o serviço foi ou será iniciado?",
  type: "datetime",
  validate: "datetime",
  isRequired: true,
  helperText: "Selecione a data e a hora do serviço.",
};

const _campoDataFim = {
  name: "data_fim",
  label: "Quando o serviço foi finalizado?",
  type: "datetime",
  validate: "datetime-nullable",
  isRequired: false,
  helperText: "Data inválida.",
};

const _campoEspecialidade = {
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
        label: dado.nome + " " + dado.sobrenome,
        query: `${dado.nome} ${dado.sobrenome} ${dado.email} ${dado.telefone}`
      });
    });
  } else {
    showSnackbar("Falha ao carregar usuários.", "erro", 5000);
  }

  return options;
}

async function getUsuarioVeiculos(id_usuario) {
  if (!id_usuario) return [];

  const response = await get(`/veiculo/listar?id_usuario=${id_usuario}`);
  const options = [];

  if (response.status === "success") {
    response.dados.forEach((dado) => {
      options.push({
        value: dado.id,
        label: `${dado.fabricante} ${dado.modelo} (${dado.ano})`,
      });
    });
  } else {
    showSnackbar("Falha ao carregar veículos do usuário.", "erro", 5000);
  }

  return options;
}

async function getEspecialidades() {
  const response = await get("/especialidade/listar");
  const options = [];

  if (response.status === "success") {
    response.dados.forEach((dado) => {
      options.push({
        value: dado.id,
        label: dado.nome,
      });
    });
  } else {
    showSnackbar("Falha ao carregar especialidades.", "erro", 5000);
  }

  return options;
}

async function handleActionClick(id, id_usuario = "", id_veiculo = "", id_especialidade = "", data_inicio = "", data_fim = "", descricao = "") {
  const action = !!id ? "alterar" : "cadastrar";
  const isAlterar = action === "alterar";

  const campoUsuario = { ..._campoUsuario };
  const campoVeiculo = { ..._campoVeiculo };
  const campoEspecialidade = { ..._campoEspecialidade };
  const campoDataInicio = { ..._campoDataInicio };
  const campoDataFim = { ..._campoDataFim };
  const campoDescricao = { ..._campoDescricao };

  if (isAlterar) {
    campoUsuario.value = id_usuario;

    campoVeiculo.value = id_veiculo;
    campoVeiculo.disabled = false;

    campoEspecialidade.value = id_especialidade;

    campoDataInicio.value = data_inicio;
    campoDataFim.value = data_fim;

    campoDescricao.value = descricao;
  }

  setFormModalIsLoading(true);

  const getUsuariosPromise = getUsuarios();
  const getEspecialidadesPromise = getEspecialidades();

  let [usuarioOptions, especialidadeOptions, veiculosOptions] = await Promise.all([
    getUsuariosPromise,
    getEspecialidadesPromise,
    ...(isAlterar ? [ getUsuarioVeiculos(id_usuario) ] : [])
  ]);

  campoUsuario.options = usuarioOptions || [];
  campoEspecialidade.options = especialidadeOptions || [];
  campoVeiculo.options = veiculosOptions || [];

  campoUsuario.onChange = async (event) => {
    const id_usuario_selecionado = event.target.value || "";
    let options = [];

    if (id_usuario_selecionado) {
      veiculosOptions = await getUsuarioVeiculos(id_usuario_selecionado);
      options = veiculosOptions || [];
      campoVeiculo.disabled = false;
    } else {
      options = [];
      campoVeiculo.disabled = true;
    }

    campoVeiculo.options = options;
    reCreateCampo(campoVeiculo);
  };

  setFormModalIsLoading(false);

  if (usuarioOptions.length > 0 && especialidadeOptions.length > 0) {
    openFormModal({
      title: isAlterar ? `Alterar Serviço "#${id}"` : "Novo Serviço",
      onConfirm: (event) => onSubmitForm(event, action, id),
      showCloseButton: true,
      confirmButtonText: isAlterar ? "Salvar Alterações" : "Confirmar",
      campos: [
        campoUsuario,
        campoVeiculo,
        campoEspecialidade,
        campoDataInicio,
        ...(isAlterar ? [campoDataFim] : []),
        campoDescricao,
      ],
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
    console.log(input.name, ok);
    if (!ok) valido = false;
  });

  if (valido) {
    const form = event.target;
    const dados = new FormData(form);

    const data_fim = dados.get("data_fim");

    const body = {
      id_usuario: dados.get("id_usuario"),
      id_veiculo: dados.get("id_veiculo"),
      id_especialidade: dados.get("id_especialidade"),
      data_inicio: dados.get("data_inicio"),
      ...(!!data_fim?.trim() ? { data_fim } : {}),
      descricao: dados.get("descricao"),
    };

    setFormModalIsLoading(true);
    post(
      `/servico/${action}`,
      new URLSearchParams({
        ...(action === "alterar" ? { id } : {}),
        ...body,
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
    title: `Deletar servico "#${id}"?`,
    confirmButtonText: "Sim, deletar servico",
    text: `Tem certeza de que deseja deletar o servico "#${id}"?\nTodos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.`,
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
