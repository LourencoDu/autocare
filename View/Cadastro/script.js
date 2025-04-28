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
  console.log(tipoUsuario, currentStep);
  if(currentStep === 2 && tipoUsuario === "usuario") {
    form.submit();
  } else {
    document.getElementById("step-" + currentStep).classList.add("hidden");
    document
      .getElementById("step-" + (currentStep + 1))
      .classList.remove("hidden");
    step = "step-" + (currentStep + 1);
  }
}
