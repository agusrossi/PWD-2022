"use strict";


let arrInputCant = document.querySelectorAll(".inputCantidad");
let arrBtnCambiar = document.querySelectorAll(".botonCambiar");



for(let i = 0; i < arrInputCant.length; i++){
    arrInputCant[i].addEventListener("change", function(e){
        e.currentTarget.setAttribute("value", this.value);
        arrBtnCambiar[i].classList.remove("disabled");
    })
}