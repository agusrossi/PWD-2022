"use strict"

let botonSumarCarrito = document.getElementById("boton-mas");
let botonRestarCarrito = document.getElementById("boton-menos");
let inputCantidad = document.getElementById("cantidad-carrito");
let listaCompra = document.querySelectorAll(".compra");
let precio = document.getElementById("precio-compra");


    botonSumarCarrito.addEventListener("click", function() {
        let cantidadActual = parseInt(inputCantidad.value)
        if(cantidadActual < 10){
            inputCantidad.setAttribute("value", cantidadActual+1);
            inputCantidad.placeholder = cantidadActual+1;
            precio.textContent = 10000 * parseInt(inputCantidad.value) ;
            /* precio.innerText = `${cantidadActual * inputCantidad}`; */

        }
    }); 
    
    botonRestarCarrito.addEventListener("click", function() {
        let cantidadActual = parseInt(inputCantidad.value)
        if(cantidadActual > 1){
            inputCantidad.setAttribute("value", cantidadActual-1);
            inputCantidad.placeholder = cantidadActual-1;
            precio.textContent = 10000 * parseInt(inputCantidad.value) ;
        }
    });

