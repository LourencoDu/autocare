let step = "step-1";

const tipoUsuarioRadioButtons = document.querySelectorAll(".person-type-radio");

const step1SubmitButton = document.getElementById("step1-submit-button");

const form = document.getElementById("form");

tipoUsuarioRadioButtons.forEach((radio) => {
  radio.addEventListener("change", function () {
    step1SubmitButton.removeAttribute("disabled");
  });
});

function getSelectedTipoUsuario() {
  const selectedRadio = document.querySelector('input[name="tipoUsuario"]:checked');
  
  if (selectedRadio) {
    return selectedRadio.value
  } else {
    return null;
  }
}

function nextStep(currentStep) {
  const tipoUsuario = getSelectedTipoUsuario();

  if(currentStep == 1) {
    document.getElementById(`step-${currentStep}`).classList.add("hidden");
  } else {
    document.getElementById(`step-${currentStep}-${tipoUsuario}`).classList.add("hidden");
  }
  document
    .getElementById(`step-${(currentStep + 1)}-${tipoUsuario}`)
    .classList.remove("hidden");
}

function submitForm() {
  form.submit();
}