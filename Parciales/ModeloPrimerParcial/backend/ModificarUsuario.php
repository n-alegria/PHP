<?php
/* ModificarUsuario.php:
Se recibirán por POST los siguientes valores: usuario_json (id, nombre, correo, clave y
id_perfil, en formato de cadena JSON), para modificar un usuario en la base de datos. Invocar al método
Modificar.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.  */

require_once('./clases/Usuario.php');
$usuario_json = isset($_POST["usuario_json"]) ? json_decode($_POST["usuario_json"]) : null;
$usuarioAux = new Usuario($usuario_json->id, $usuario_json->nombre, $usuario_json->correo, $usuario_json->clave, $usuario_json->id_perfil, null);
$retornoJson = new stdClass();
$retornoJson->bool = false;
$retornoJson->mensaje = "Ocurrio un error al intentar modificar el usuario";

if($usuarioAux->Modificar()){
    $retornoJson->bool = true;
    $retornoJson->mensaje = "Usuario modificado con exito.";
   
}

echo json_encode($retornoJson);

?>