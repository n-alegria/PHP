<?php

/*
Aplicación Nº 8 (Números en letras)
Realizar un programa que en base al valor numérico de la variable $num, pueda mostrarse por
pantalla, el nombre del número que tenga dentro escrito con palabras, para los números entre
el 20 y el 60.
*/

$num = rand(20, 60);
$f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
echo $f->format($num);

?>