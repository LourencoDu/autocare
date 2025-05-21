const form = document.getElementById("form-modal-form");

const validators = {
  nome: (val) => val.trim().length >= 2,
};

const campoNome = {
  name: "nome",
  label: "Nome",
  type: "text",
  validate: "nome",
  maxLength: 40,
  isRequired: true,
  placeholder: "Ex.: LavaCar, Lava-rápido, etc.",
  helperText: "O nome deve conter pelo menos 2 caracteres.",
};

function handleActionClick(id, nome = "") {
  const action = !!id ? "alterar" : "cadastrar";
  const isAlterar = action === "alterar";

  if (isAlterar) {
    campoNome.value = nome;
  }

  openFormModal({
    title: isAlterar ? `Alterar "${nome}"` : "Nova Especialidade",
    onConfirm: (event) => onSubmitForm(event, action, id),
    showCloseButton: true,
    confirmButtonText: isAlterar ? "Salvar Alterações" : undefined,
    campos: [campoNome],
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
      `/admin/especialidade/${action}`,
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
          `Especialidade ${
            action === "cadastrar" ? "cadastrada" : "alterada"
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
    title: `Deletar especialidade "${label}"?`,
    confirmButtonText: "Sim, deletar especialidade",
    text: `Tem certeza de que deseja deletar a especialidade "${label}"?\nTodos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.`,
    onConfirm: () => handleDeleteConfirm(id),
  });
}

async function handleDeleteConfirm(id) {
  setDeleteModalIsLoading(true);
  post(
    "/admin/especialidade/deletar",
    new URLSearchParams({
      id,
    })
  ).then((response) => {
    setDeleteModalIsLoading(false);
    if (response.status === "error") {
      showFormModalError(response.mensagem);
    } else {
      showSnackbar(`Especialidade deletada com sucesso!`, "success");
      closeDeleteModal();
      atualizarListagem();
    }
  });
}

async function atualizarListagem() {
  const html = await getText("/admin/especialidade/listar");
  document.getElementById("view-content").innerHTML = html;
}
