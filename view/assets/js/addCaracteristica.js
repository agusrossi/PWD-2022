function agregarCaracteristica() {
  console.log('a');

  var car = `
    <div class="input-group mb-3">
      <input type="text" name="prodetalleC[]" class="form-control" placeholder="Caracteristica" aria-label="Username" required>
      <input type="text" name="prodetalleD[]" class="form-control" placeholder="Detalle" aria-label="Server" required>
    </div>
  `;

  document.getElementById("masCaracteristicas").innerHTML += car;

}