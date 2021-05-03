<?php

/* VerificarUsuario.php: (POST) 
Se recibe el parámetro usuario_json (correo y clave, en formato de cadena
JSON) y se invoca al método TraerUno.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/

require_once("./clases/Usuario.php");

$usuario_json = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : null;

if($usuario_json != null){    
    $retornoJson = new stdClass();
    $retornoJson->exito = false;
    $retornoJson->mensaje = "El usuario NO EXISTE en la base de datos.";
    $usuarioExiste = Usuario::TraerUno($usuario_json);
    if($usuarioExiste != null){
        $retornoJson->exito = true;
        $retornoJson->mensaje = "El usuario EXISTE en la base de datos.";
    }
    var_dump(json_encode($retornoJson)) ;
}
else{
    echo "Se requiere parametro 'usuario_json' enviado por metodo 'POST'";
}

?>