<?php

/*
Aplicacion N°16 (Invertir palabra)
Realizar el desarrollo de una funcion que reciba un Array de 
caracteres y que invierta el orden de las letras del Array.

Ejemplo: Se recibe la palabra "hola" y luego queda "aloh"
*/

$cadena = array("h","o","l","a");
$palabra = "Prueba";

// function Invertir($cadena){
//     $cadenaInversa = array_reverse($cadena);
//     foreach ($cadenaInversa as $value) {
//         echo($value);
//     }
// }
// Invertir($cadena);


function InvertirPalabra($palabra){
    for($i = strlen($palabra)-1; $i>=0; $i--){ // Debo restar uno sino me voy del rango
        echo $palabra[$i];
    }
}

InvertirPalabra("Carlos");