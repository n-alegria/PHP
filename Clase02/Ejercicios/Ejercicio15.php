<?php

/*
Aplicacion N°15 (Potencias de numeros)
Mostrar por pantalla las primeras 4 potencias de los numeros 
del 1 al 4 (hacer una funcion que calcule invocando la funcion pow).
*/

$numeros = array(1,2,3,4);

function Potencia($numeros)
{
    for ($i=1; $i < 5; $i++) { //Recorro el array de numeros
        echo "<b>" . $i . ":</b> ";
        for ($j=0; $j < 4; $j++) { // Realizo las potencias del numero
            echo pow($i, $j), " ";
        }
        echo "<br/>";
    }
}

Potencia($numeros);