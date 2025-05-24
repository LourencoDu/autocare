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
  formModal.classList.toggle("hidden", false);

  renderCampos(campos);
}

function closeFormModal() {
  formModal.classList.toggle("hidden", true);
}

function showFormModalError(texto) {
  showSnackbar(texto, "erro", 5000);
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
  const type = campo.type;

  const labelEl = document.createElement("label");
  labelEl.className = "";
  labelEl.textContent = label;

  if (type === "select-search") {
    labelEl.setAttribute("for", `${campo.name}${"-search-input"}`);
  } else if (type === "datetime") {
    labelEl.setAttribute("for", `${campo.name}${"-date"}`);
  } else {
    labelEl.setAttribute("for", `${campo.name}`);
  }

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

  return inputEl;
}

function createTextareaEl(campo) {
  const name = campo.name;
  const value = campo.value || "";

  const type = "text";
  const validate = campo.validate;
  const maxLength = campo.maxLength;
  const placeholder = campo.placeholder || "";

  const rows = campo.rows || 5;
  const cols = campo.cols || 20;

  const textareaEl = document.createElement("textarea");
  textareaEl.name = name;
  textareaEl.id = name;
  textareaEl.type = type;
  textareaEl.innerHTML = value;
  textareaEl.rows = rows;
  textareaEl.cols = cols;

  if (!!validate) {
    textareaEl.setAttribute("data-validate", validate);
  }

  if (!!maxLength) {
    textareaEl.maxLength = maxLength;
  }

  if (!!placeholder) {
    textareaEl.placeholder = placeholder;
  }

  return textareaEl;
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

  selectEl.onchange = (event) => {
    !!campo.onChange && campo.onChange(event);
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
    "fa-solid fa-chevron-down text-gray-400 text-sm pointer-events-none relative right-4 col-start-1 row-start-1 h-3 w-4 self-center justify-self-end forced-colors:hidden";

  const content = document.createElement("div");
  content.className = "grid w-full";
  content.appendChild(selectEl);
  content.appendChild(arrowEl);

  const containerEl = document.createElement("div");
  containerEl.className = "flex flex-col w-full";
  containerEl.appendChild(content);

  return containerEl;
}

function createSelectSearchableEl(campo) {
  const {
    name,
    value = "",
    options = [],
    isRequired,
    validate,
    placeholder = "Selecione",
    disabled,
  } = campo;

  let lastSetValue = value;

  const searchInputEl = document.createElement("input");
  Object.assign(searchInputEl, {
    id: `${name}-search-input`,
    name: `${name}-search-input`,
    placeholder,
    autocomplete: "off",
    className: "col-start-1 row-start-1 disabled:opacity-40",
    disabled,
  });

  const optionsUlEl = document.createElement("ul");
  optionsUlEl.className =
    "absolute top-14 bg-white border border-gray-300 w-full rounded shadow hidden z-10 overflow-y-auto max-h-[160px]";

  const valueInputEl = document.createElement("input");
  Object.assign(valueInputEl, {
    type: "hidden",
    name,
    id: name,
    value,
  });

  if (!!validate) {
    valueInputEl.setAttribute("data-validate", validate);
  }

  const arrowEl = document.createElement("i");
  arrowEl.className = `fa-solid fa-chevron-down text-gray-400 text-sm pointer-events-none relative right-4 col-start-1 row-start-1 h-3 w-4 self-center justify-self-end forced-colors:hidden ${
    disabled ? "opacity-40" : ""
  }`;

  const content = document.createElement("div");
  content.className = "select-content grid w-full";
  [searchInputEl, optionsUlEl, arrowEl].forEach((el) =>
    content.appendChild(el)
  );

  const containerEl = document.createElement("div");
  containerEl.className = "relative flex flex-col w-full disabled:opacity-40";
  containerEl.appendChild(content);

  const setValueInput = (valor) => {
    if (lastSetValue === valor) return; // 🔁 impede chamadas duplicadas
    lastSetValue = valor;
    valueInputEl.value = valor;
    !!campo.onChange && campo.onChange({ target: { value: valor } });
  };

  // 🔍 Função para encontrar uma opção exata (sem acento/símbolos)
  const encontrarOpcaoPorTexto = (texto) => {
    const busca = limparTextoBusca(texto.trim());
    return options.find((opt) => limparTextoBusca(opt.label) === busca);
  };

  // ✅ Seleciona uma opção (preenche input e hidden)
  const selecionarOpcao = (option) => {
    searchInputEl.value = option.label;
    setValueInput(option.value);
    optionsUlEl.classList.add("hidden");
  };

  if (value) {
    const option = options.find((o) => o.value == value);
    selecionarOpcao(option);
  }

  const atualizarListaOpcoes = (filtro = "") => {
    const textoBusca = limparTextoBusca(filtro);
    const filtradas = options.filter((opt) =>
      limparTextoBusca(opt.query || opt.label).includes(textoBusca)
    );

    optionsUlEl.innerHTML = "";

    if (filtradas.length > 0) {
      filtradas.forEach((opt) => {
        const li = document.createElement("li");
        li.textContent = opt.label;
        li.className = "p-2 hover:bg-blue-100 cursor-pointer";
        li.onclick = () => selecionarOpcao(opt);
        optionsUlEl.appendChild(li);
      });
    } else {
      const li = document.createElement("li");
      li.className = "p-2 text-gray-500 italic";
      li.textContent = `Sem resultados para "${filtro.trim()}"`;
      li.style.pointerEvents = "none";
      optionsUlEl.appendChild(li);
    }

    optionsUlEl.classList.remove("hidden");
  };

  // 📦 Eventos
  searchInputEl.addEventListener("input", (e) =>
    atualizarListaOpcoes(e.target.value)
  );

  searchInputEl.addEventListener("focus", () => {
    if (searchInputEl.value.trim() === "") {
      atualizarListaOpcoes();
    }
    if (optionsUlEl.childNodes.length > 0) {
      optionsUlEl.classList.remove("hidden");
    }
  });

  searchInputEl.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      const opcao = encontrarOpcaoPorTexto(searchInputEl.value);
      if (opcao) {
        selecionarOpcao(opcao);
      } else {
        searchInputEl.value = "";
        setValueInput("");
      }
      optionsUlEl.classList.add("hidden");
    }
  });

  document.addEventListener("click", (e) => {
    if (!containerEl.contains(e.target)) {
      optionsUlEl.classList.add("hidden");

      const opcao = encontrarOpcaoPorTexto(searchInputEl.value);
      if (!opcao) {
        searchInputEl.value = "";
        setValueInput("");
      }
    }
  });

  const fragment = document.createDocumentFragment();
  [containerEl, valueInputEl].forEach((el) => fragment.appendChild(el));

  return fragment;
}

function createDatetimeInputEl(campo) {
  const validate = campo.validate;

  const value = campo.value || "";
  let dateValue = "";
  let timeValue = "";

  if(value) {
    dateValue = value.substring(0, 10);
    timeValue = value.substring(11, 16);
  }

  const container = document.createElement("div");
  container.className = "flex items-center justify-between gap-4";

  const campoDate = { ...campo };
  campoDate.id = `${campo.name}-date`;
  campoDate.name = `${campo.name}-date`;
  campoDate.placeholder = "";
  campoDate.type = "date";
  campoDate.value = dateValue;
  campoDate.validate = "";
  const dateInputEl = createInputEl(campoDate);

  const campoTime = { ...campo };
  campoTime.id = `${campo.name}-time`;
  campoTime.name = `${campo.name}-time`;
  campoTime.placeholder = "";
  campoTime.type = "time";
  campoTime.value = timeValue;
  campoTime.validate = "";
  const timeInputEl = createInputEl(campoTime);

  const datetimeInputEl = document.createElement("input");
  datetimeInputEl.hidden = true;
  datetimeInputEl.id = campo.name;
  datetimeInputEl.name = campo.name;
  datetimeInputEl.value = value;

  if (!!validate) {
    datetimeInputEl.setAttribute("data-validate", validate);
  }

  dateInputEl.onchange = (event) => {
    const dateValue = event.target.value;

    datetimeInputEl.value = `${dateValue} ${timeInputEl.value}`;
  };

  timeInputEl.onchange = (event) => {
    const timeValue = event.target.value;

    datetimeInputEl.value = `${dateInputEl.value} ${timeValue}`;
  };

  container.appendChild(dateInputEl);
  container.appendChild(timeInputEl);

  const fragment = document.createDocumentFragment();
  fragment.appendChild(container);
  fragment.appendChild(datetimeInputEl);

  return fragment;
}

function createHelperTextEl(campo) {
  const helperText = campo.helperText;

  const helperTextEl = document.createElement("span");
  helperTextEl.className = "helper-text danger hidden";
  helperTextEl.textContent = helperText || "";

  return helperTextEl;
}

function reCreateCampo(campo) {
  const controlId = `form-control-${campo.name}`;

  document.getElementById(controlId)?.replaceWith(createCampoEl(campo));
}

function createCampoEl(campo, index = 0) {
  const controlId = `form-control-${campo.name || "campo-" + index}`;
  let controlEl = document.getElementById(controlId);

  if (!controlEl) {
    controlEl = document.createElement("div");
    controlEl.id = controlId;
  } else {
    controlEl.innerHTML = "";
  }

  controlEl.className = "form-control flex-col";

  const labelEl = createLabelEl(campo);
  let inputEl = null;

  if (campo.type === "select-search") {
    inputEl = createSelectSearchableEl(campo);
  } else if (campo.type === "select") {
    inputEl = createSelectEl(campo);
  } else if (campo.type === "textarea") {
    inputEl = createTextareaEl(campo);
  } else if (campo.type === "datetime") {
    inputEl = createDatetimeInputEl(campo);
  } else {
    inputEl = createInputEl(campo);
  }

  const helperTextEl = createHelperTextEl(campo);

  controlEl.appendChild(labelEl);
  controlEl.appendChild(inputEl);
  controlEl.appendChild(helperTextEl);

  return controlEl;
}

function renderCampos(campos) {
  const camposEl = document.getElementById("form-modal-campos");
  camposEl.innerHTML = "";

  campos.forEach((campo, index) => {
    let campoEl = null;
    if (campo instanceof HTMLElement) {
      campoEl = campo;
    } else {
      campoEl = createCampoEl(campo, index);
    }

    camposEl.appendChild(campoEl);
  });
}
