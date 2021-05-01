<?php
/* AltaUsuario.php: 
Se recibe por POST el correo, la clave, el nombre y el id_perfil. Se invocará al método Agregar.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("./clases/Usuario.php");

$correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : null;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : null;

$retornoJson = new stdClass();

$usuarioExiste = Usuario::TraerUno($correo, $clave);
if($usuarioExiste != null){
    $retornoJson->exito = false;
    $retornoJson->mensaje = "El usuario ya existe en la base de datos.";
}
else{
    $usuario = new Usuario(null, $nombre, $correo, $clave, $id_perfil, null);
    if($usuario->Agregar()){
        $retornoJson->exito = true;
        $retornoJson->mensaje = "Usuario agregado con exito.";
    }
    else{
        $retornoJson->exito = false;
        $retornoJson->mensaje = "Ocurrio un error al agregar el usuario.";
    }
}
var_dump(json_encode($retornoJson));

?>