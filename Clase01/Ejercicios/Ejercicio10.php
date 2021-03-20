<?php
/*
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach.
*/

$array = array();
$iterador = 0;
$ciclo_while = 0;

while(count($array) < 10){
    if($iterador % 2 != 0){
        array_push($array, $iterador);
    }
    $iterador++;
}

print("For: <br/>");
for ($i=0; $i < 10; $i++) { 
    print("$array[$i] <br/>"); 
}

echo("<br/>");

print("While: <br/>");
while($ciclo_while < 10){
    print("$array[$ciclo_while] <br/>");
    $ciclo_while ++;
}

echo "<br/>";

print("Foreach: <br/>");
foreach ($array as $val) {
    print("$val <br/>");
}

?>