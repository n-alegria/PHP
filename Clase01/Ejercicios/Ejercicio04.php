<?php
/*
Aplicación Nº 4 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.
*/

$acumulador = 1;
$contador = 0;
while($acumulador <= 1000)
{
    print("$acumulador - ");
    $acumulador += 1;
    $contador += 1;
}

print("Se sumaron $contador numeros")

?>