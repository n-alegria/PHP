<?php
/*
Aplicación Nº 9 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.
*/

$array;
$suma = 0;
$promedio;

for ($i=0; $i < 5; $i++) { 
    $array[$i] = rand(1, 10);
}

for ($i=0; $i < 5; $i++) { 
    $suma += $array[$i];
}

$promedio = $suma / 5;

print("Suma: $suma<br/>");
print("Promedio: $promedio<br/>");

if($promedio > 6){
    echo "Promedio mayor a 6";
}
elseif($promedio < 6){
    echo "Promedio menor a 6";
}
elseif($promedio == 6){
    echo "El promedio es igual a 6";
}

?>