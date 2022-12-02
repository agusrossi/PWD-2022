"use strict";
let notificacion = document.getElementById("toastNotif");
let botonCerrarNotif = document.getElementById("toastNotifClose");

botonCerrarNotif.addEventListener("click", function(e){
    notificacion.target.classList.add("hide");
});