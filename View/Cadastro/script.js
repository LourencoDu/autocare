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

function submitForm() {
  form.submit();
}