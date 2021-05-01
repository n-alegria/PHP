<?php
/* EliminarUsuario.php: 
Si recibe el parámetro id por POST, más el parámetro accion con valor "borrar", se
deberá borrar el usuario (invocando al método Eliminar).
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once('./clases/Usuario.php');
$id = isset($_POST["id"]) ? $_POST["id"] : null;
$accion = isset($_POST["accion"]) ? $_POST["accion"] : null;
$retorno_json = new stdClass();
$retorno_json->exito = false;
$retorno_json->mensaje = "Ocurrio un error al intentar eliminar el usuario.";

if($accion == null or $accion != 'borrar'){
    $retorno_json->mensaje = "Se omitio la variable 'accion' o existe un error con ella. ";
}
if($accion == 'borrar'){
    if(Usuario::Eliminar($id)){
        $retorno_json->exito = true;
        $retorno_json->mensaje = "Usuario eliminado con exito.";
    }
}
echo json_encode($retorno_json);

?>