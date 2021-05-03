<?php
 /* MostrarLog.php: 
 Muestra por pantalla todo lo registrado en el archivo de texto “juguetes_sin_foto.txt”. 
 Para ello, agregar un método estático (en Juguete), llamado MostrarLog. */

require_once('./clases/Juguete.php');

$arrayJuguetes = Juguete::MostrarLog();
if($arrayJuguetes !== null or $arrayJuguetes !== 0){
    foreach($arrayJuguetes as $juguete){
        echo $juguete . "\n";
    }
}

?>