<?php
/* AltaEmpleado.php: 
Se recibirán por POST todos los valores: nombre, correo, clave, id_perfil, sueldo y foto
para registrar un empleado en la base de datos.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/Empleado.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : null;
$id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : null;
$sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : null;
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "Ocurrio un error al agregar el empleado.";

$pathFoto = "../backend/empleados/fotos/" . $nombre . "." . date('His') . "." . pathinfo($foto, PATHINFO_EXTENSION);
$empleadoAux = new Empleado(null, $nombre, $correo, $clave, $id_perfil, null, $pathFoto, $sueldo);
if($empleadoAux->Agregar()){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Empleado agregado con exito.";
    if(move_uploaded_file($_FILES["foto"]["tmp_name"], $pathFoto)){
        $retornoJson->mensaje .= " Junto con su foto";
    }
    else{
        $retornoJson->mensaje .= "Ocurrio un error al guardar la foto.";
    }

}

echo json_encode($retornoJson); 

?>