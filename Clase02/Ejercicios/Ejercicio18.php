<?php

/*
Aplicacion N°18 (Par e impar)
Crear una funcion llamada EsPar que reciba un valor entero como parametro
y devuelva TRUE si este numero es par o FALSE si es impar.
Reutilizar el codigo anterior, crear la funcion EsImpar
*/

function EsPar($numero){
    $retorno = false;
    if($numero % 2 == 0){
        $retorno = true;
    }
    return $retorno;
}

function EsImpar($numero){
    return !(EsPar($numero));
}

if(EsPar(2)){
    echo "Es par";
}
else{
    echo "No es par";
}

echo "<br/>";

if(EsPar(3)){
    echo "Es par";
}
else{
    echo "No es par";
}

echo "<br/>";

if(EsImpar(2)){
    echo "Es impar";
}
else{
    echo "No es impar";
}

echo "<br/>";

if(EsImpar(3)){
    echo "Es impar";
}
else{
    echo "No es impar";
}