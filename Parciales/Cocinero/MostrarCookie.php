<?php
// MostrarCookie.php: Se recibe por GET la especialidad y el email del cocinero y se verificará si existe una cookie
// con el mismo nombre, de ser así, retornará un JSON que contendrá: éxito(bool) y mensaje(string), dónde se
// mostrará el contenido de la cookie. Caso contrario, false y el mensaje indicando lo acontecido.
// Nota: Reemplazar los puntos por guiones bajos en el email (en caso de ser necesario).

require_once('./clases/Cocinero.php');

$especialidad = isset($_GET["especialidad"]) ? $_GET["especialidad"] : null;
$email = isset($_GET["email"]) ? $_GET["email"] : null;

$aux = str_replace(".", "_", $email);

$retorno = new stdClass();
$retorno->exito = false;
$retorno->mensaje = "No existe la coookie";

$nombreCookie = $aux."_".$especialidad;
    
if(isset($_COOKIE[$nombreCookie])) {
    $retorno->exito = true;
    $retorno->mensaje = $_COOKIE[$nombreCookie];
}
// if(isset($_COOKIE[$nombreCookie])){
//     $retorno->exito = true;
//     $retorno->mensaje = $_COOKIE[$nombreCookie];
// }

echo json_encode($retorno);