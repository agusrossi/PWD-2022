function requerirImagen() {
  let inputImagen = document.querySelectorAll("#imagen")[0];
  inputImagen.setAttribute("required", '');

  let imagenes = document.querySelectorAll("#contenedor-imagenes")[0];
  imagenes.classList.add("d-none");

}