<?php
/* ListadoUsuariosJSON.php:
(GET) Se mostrará el listado de todos los usuarios en formato JSON.
*/

require_once('./clases/Usuario.php');

$arrayUsuarios = Usuario::TraerTodosJson();
if($arrayUsuarios != null && count($arrayUsuarios) > 0){
    foreach ($arrayUsuarios as $usuarios) {
        echo( $usuarios->ToJSON()."\n");
    }
}
else{
    echo "El listado esta vacio.";
}