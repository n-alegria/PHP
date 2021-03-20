<?php

/*
Aplicación Nº 1 (Mostrar variables)
Realizar un programa que guarde su nombre en $nombre y su apellido en $apellido. Luego
mostrar el contenido de las variables con el siguiente formato: Pérez, Juan. Utilizar el operador
de concatenación.
*/

$nombre = 'lautaro';
$apellido = 'Alegria';

// ucfirst() -> metodo que capitaliza el string
echo ucfirst($nombre) . ', ' . ucfirst($apellido);

?>