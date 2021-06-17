<?php

// VerificarCocinero.php: Se recibe por POST el email y la clave, si coinciden con algún registro del archivo JSON
// (VerificarExistencia), crear una COOKIE nombrada con el email y la especialidad del cocinero, separado con un
// guión bajo (maru_botana@gmail.com_pastelero) que guardará la fecha actual (con horas, minutos y segundos)
// más el retorno del mensaje del método VerificarExistencia.
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido (agregar el mensaje
// obtenido del método de clase).
require_once('./clases/Cocinero.php');

$email = isset($_POST["email"]) ? $_POST["email"] : null;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : null;

$retorno = new stdClass();
$retorno->exito = false;
$retorno->mensaje = "No hay cocinero con los paramatros ingresados";

$cocinero = new Cocinero('', $email, $clave);
$json = json_decode(Cocinero::VerificarExistencia($cocinero));
if($json->exito){
    $aux = str_replace(".", "_", $email);
    $cookieMail = $aux.'_'.$json->especialidad;
    setcookie($cookieMail, date("d/m/Y - G:i:s"), time()+20);

    $retorno->exito = true;
    $retorno->mensaje = "Cookie generada con exito. ";
    $retorno->mensaje .= $json->mensaje;
}

echo json_encode($retorno);