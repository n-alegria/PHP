<?php
/* AltaUsuarioJSON.php: 
Se recibe por POST el correo, la clave y el nombre.
Invocar al método GuardarEnArchivo. */

require_once("./clases/Usuario.php");

$correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : null;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;

$usuario = new Usuario(null, $nombre, $correo, $clave, null, null);
$respuesta = $usuario->GuardarEnArchivo();

echo $respuesta;

?>