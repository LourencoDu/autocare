const formModal = document.getElementById("form-modal");

function openFormModal({
  title,
  text,
  cancelButtonText,
  confirmButtonText,
  onConfirm,
  showCloseButton = true,
  campos = [],
}) {
  const titleEl = document.getElementById("form-modal-title");
  const textEl = document.getElementById("form-modal-text");
  const cancelButtonEl = document.getElementById("form-modal-cancel-button");
  const confirmButtonTextEl = document.getElementById(
    "form-modal-confirm-button-text"
  );

  const closeButtonEl = document.getElementById("form-modal-close-button");

  if (title) {
    titleEl.innerText = title;
  }

  if (text) {
    textEl.innerText = text;
  }

  if (cancelButtonText) {
    cancelButtonEl.innerText = cancelButtonText;
  }

  if (confirmButtonText) {
    confirmButtonTextEl.innerText = confirmButtonText;
  }

  if (!!onConfirm) {
    formModal.onsubmit = onConfirm;
  }

  if (showCloseButton) {
    closeButtonEl.classList.toggle("hidden", false);
  }
  renderCampos(campos);
  formModal.classList.toggle("hidden", false);
}

function closeFormModal() {
  formModal.classList.toggle("hidden", true);
}

function showFormModalError(texto) {
    const errorEl = document.getElementById("form-modal-error");
    const errorTextEl = document.getElementById("form-modal-error-text");
    errorTextEl.textContent = texto;

    errorEl.classList.toggle("hidden", false);
}

function hideFormModalError() {
    const errorEl = document.getElementById("form-modal-error");

    errorEl.classList.toggle("hidden", true);
}

function setFormModalIsLoading(isLoading = false) {
  const cancelButtonEl = document.getElementById("form-modal-cancel-button");
  const confirmButtonEl = document.getElementById("form-modal-confirm-button");
  const closeButtonEl = document.getElementById("form-modal-close-button");

  cancelButtonEl.disabled = isLoading;
  confirmButtonEl.disabled = isLoading;
  closeButtonEl.disabled = isLoading;

  toggleLoading(isLoading);
}

function renderCampos(campos) {
  const camposEl = document.getElementById("form-modal-campos");
  camposEl.innerHTML = "";

  campos.forEach((campo) => {
    const name = campo.name;
    const label = campo.label;
    const value = campo.value || "";

    const type = campo.type || "text";
    const validate = campo.validate;
    const maxLength = campo.maxLength;
    const placeholder = campo.placeholder || "";
    const isRequired = !!campo.isRequired;
    const helperText = campo.helperText;

    const controlEl = document.createElement("div");
    controlEl.className = "form-control flex-col";

    const labelEl = document.createElement("label");
    labelEl.className = "";
    labelEl.textContent = label;
    labelEl.for = name;

    if (isRequired) {
      const isRequiredEl = document.createElement("span");
      isRequiredEl.textContent = " *";
      isRequiredEl.className = "text-red-500";
      labelEl.appendChild(isRequiredEl);
    }

    const inputEl = document.createElement("input");
    inputEl.name = name;
    inputEl.id = name;
    inputEl.type = type;
    inputEl.value = value;
    if (!!validate) {
      inputEl.setAttribute("data-validate", validate);
    }

    if (!!maxLength) {
      inputEl.maxLength = maxLength;
    }

    if (!!placeholder) {
      inputEl.placeholder = placeholder;
    }

    inputEl.onkeyup = hideFormModalError;

    const helperTextEl = document.createElement("span");
    helperTextEl.className = "helper-text danger hidden";
    helperTextEl.textContent = helperText || "";

    controlEl.appendChild(labelEl);
    controlEl.appendChild(inputEl);
    controlEl.appendChild(helperTextEl);

    camposEl.appendChild(controlEl);
  });
}
