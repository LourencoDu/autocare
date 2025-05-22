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

function createLabelEl(campo) {
  const label = campo.label;
  const isRequired = !!campo.isRequired;

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

  return labelEl;
}

function createInputEl(campo) {
  const name = campo.name;
  const value = campo.value || "";

  const type = campo.type || "text";
  const validate = campo.validate;
  const maxLength = campo.maxLength;
  const placeholder = campo.placeholder || "";

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

  return inputEl;
}

function createSelectEl(campo) {
  const name = campo.name;
  const value = campo.value || "";
  const options = campo.options || [];

  const isRequired = !!campo.isRequired;

  const validate = campo.validate;
  const placeholder = campo.placeholder || "";

  const selectEl = document.createElement("select");
  selectEl.name = name;
  selectEl.id = name;
  selectEl.value = value;
  selectEl.className = "col-start-1 row-start-1";

  if (!!validate) {
    selectEl.setAttribute("data-validate", validate);
  }

  selectEl.onchange = event => {
    !!campo.onChange && campo.onChange(event);
    hideFormModalError(event);
  };

  const defaultOptionEl = document.createElement("option");
  defaultOptionEl.textContent = placeholder || "Selecione";
  defaultOptionEl.value = "";
  defaultOptionEl.selected = !!value ? false : true;
  defaultOptionEl.disabled = isRequired;
  selectEl.appendChild(defaultOptionEl);

  options.forEach((option) => {
    const optionEl = document.createElement("option");
    optionEl.textContent = option.label;
    optionEl.value = option.value;
    optionEl.selected = value == option.value;
    selectEl.appendChild(optionEl);
  });

  const arrowEl = document.createElement("i");
  arrowEl.className =
    "fa-solid fa-chevron-down text-gray-400 text-sm pointer-events-none relative right-4 z-10 col-start-1 row-start-1 h-3 w-4 self-center justify-self-end forced-colors:hidden";

  const content = document.createElement("div");
  content.className = "grid w-full";
  content.appendChild(selectEl);
  content.appendChild(arrowEl);

  const container = document.createElement("div");
  container.className = "flex flex-col w-full";
  container.appendChild(content);

  return container;
}

function createHelperTextEl(campo) {
  const helperText = campo.helperText;

  const helperTextEl = document.createElement("span");
  helperTextEl.className = "helper-text danger hidden";
  helperTextEl.textContent = helperText || "";

  return helperTextEl;
}

function renderCampos(campos) {
  const camposEl = document.getElementById("form-modal-campos");
  camposEl.innerHTML = "";

  campos.forEach((campo) => {
    const controlEl = document.createElement("div");
    controlEl.className = "form-control flex-col";

    const labelEl = createLabelEl(campo);
    let inputEl = null;

    if (campo.type === "select") {
      inputEl = createSelectEl(campo);
    } else {
      inputEl = createInputEl(campo);
    }

    const helperTextEl = createHelperTextEl(campo);

    controlEl.appendChild(labelEl);
    controlEl.appendChild(inputEl);
    controlEl.appendChild(helperTextEl);

    camposEl.appendChild(controlEl);
  });
}
