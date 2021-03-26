<?php

/*
Aplicacion N°17 (Invertir palabra)
Crear una funcion que reciba como parametro un string ($palabra) y un
entero ($max). La funcion validara que la cantidad de caracteres que
tiene $palabra no supere a $max y ademas determinara si ese valor
se encuentra dentro del siguiente listado de palabras validas:
"Recuperatorio", "Parcial" y "Programacion". Los valores de retorno seran: 
1 si la palabra pertenece a algun elemento del listado, 0 caso contrario.
*/


function ValidarPalabra($palabra, $max){
    $retorno = 0;
    if(strlen($palabra) > $max){
        echo $palabra . ": supera el maximo permitido.<br/>";
    }
    if($palabra == "Recuperatorio" || $palabra == "Parcial" || $palabra == "Programacion"){
        $retorno = 1;
        echo $palabra . ": pertenece al listado<br/>";
    }
    else{
        echo $palabra . ": no pertenece al listado<br/>";
    }
    return $retorno;
}

ValidarPalabra("Pantufla", 6);
ValidarPalabra("Carta", 6);
ValidarPalabra("Programacion", 15);