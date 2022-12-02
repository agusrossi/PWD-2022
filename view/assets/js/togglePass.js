function togglePass() {
  var elements = document.getElementsByClassName("pass-input");

  for (let i = 0; i < elements.length; i++) {
    const element = elements[i];
    element.classList.toggle("d-none");
  }

  var buttonPri = document.getElementById("pass-button-principal");
  var buttonSec = document.getElementById("pass-button-secundario");
  buttonPri.classList.toggle("d-none");
  buttonSec.classList.toggle("d-none");

}