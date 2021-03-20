<?php

/*
Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.
*/

date_default_timezone_set('America/Buenos_Aires');

//https://www.php.net/manual/es/function.date.php
$hoy = date("F j, Y, g:i a");                 // March 10, 2001, 5:16 pm
echo $hoy, "<br>";
$hoy = date("m.d.y");                         // 03.10.01
echo $hoy, "<br>";
$hoy = date("j, n, Y");                       // 10, 3, 2001
echo $hoy, "<br>";
$hoy = date("Ymd");                           // 20010310
echo $hoy, "<br>";
$hoy = date('h-i-s, j-m-y, it is w Day');     // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
echo $hoy, "<br>";
$hoy = date('\i\t \i\s \t\h\e jS \d\a\y.');   // it is the 10th day.
echo $hoy, "<br>";
$hoy = date("D M j G:i:s T Y");               // Sat Mar 10 17:16:18 MST 2001
echo $hoy, "<br>";
$hoy = date('H:m:s \m \i\s\ \m\o\n\t\h');     // 17:03:18 m is month
echo $hoy, "<br>";
$hoy = date("H:i:s");                         // 17:16:18
echo $hoy, "<br>";
$hoy = date("Y-m-d H:i:s");                   // 2001-03-
echo $hoy, "<br>";

echo date('l \t\h\e jS');
//me da fiaca pero con un switch y fijandose los dias podes determinar la estacion

?>