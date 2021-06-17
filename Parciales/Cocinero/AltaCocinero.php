<?php

require_once('./clases/Cocinero.php');

$especialidad = isset($_POST["especialidad"]) ? $_POST["especialidad"] : null;
$email = isset($_POST["email"]) ? $_POST["email"] : null;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : null;

if($especialidad != null && $email != null && $clave != null){
    $cocinero = new Cocinero($especialidad, $email, $clave);
    $mensaje = $cocinero->GuardarEnArchivo();
    echo $mensaje;
}
else{
    echo 'No se reconoce uno o todos los parametros';
}

