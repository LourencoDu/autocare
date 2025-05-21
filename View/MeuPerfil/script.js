const form = document.getElementById("form-modal-form");

const validators = {
  senha: (val) => /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(val),
  required: (val) => !!val.trim(),
};

document
  .getElementById("button-alterar-senha")
  .addEventListener("click", () => {
    openFormModal({
      title: "Alterar Senha",
      onConfirm: (event) => onSubmitForm(event),
      showCloseButton: true,
      campos: [
        {
          name: "senha-atual",
          label: "Senha Atual",
          type: "password",
          validate: "required",
          maxLength: 50,
          isRequired: true,
          helperText: "Digite a sua senha atual.",
        },
        {
          name: "senha-nova",
          label: "Nova Senha",
          type: "password",
          validate: "senha",
          maxLength: 50,
          isRequired: true,
          helperText:
            "A senha deve conter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e símbolos.",
        },
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
  });

function onSubmitForm(event) {
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

    const senhaAtual = dados.get("senha-atual");
    const senhaNova = dados.get("senha-nova");

    setFormModalIsLoading(true);
    post(
      "/usuario/alterar-senha",
      new URLSearchParams({
        "senha-atual": senhaAtual,
        "senha-nova": senhaNova,
      })
    ).then((response) => {
      setFormModalIsLoading(false);
      if (response.status === "error") {
        showFormModalError(response.mensagem);
      } else {
        showSnackbar("Senha alterada com sucesso!", "success");
        closeFormModal();
      }
    });
  }
}
