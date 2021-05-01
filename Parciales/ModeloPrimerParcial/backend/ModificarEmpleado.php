<?php
/* ModificarEmpleado.php: 
Se recibirán por POST los siguientes valores: empleado_json (id, nombre, correo,
clave, id_perfil, sueldo y pathFoto, en formato de cadena JSON) y foto (para modificar un empleado en la base
de datos. Invocar al método Modificar.
-> Nota: El valor del id, será el id del empleado 'original', mientras que el resto de los valores serán los del
empleado modificado.
-> Nota: Si la foto es pasada, guardarla en “./backend/empleados/fotos/”, con el nombre formado por el nombre
punto tipo punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg). Caso contrario, sólo actualizar
el campo de la base.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/Empleado.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$empleado_json = isset($_POST['empleado_json']) ? json_decode($_POST['empleado_json']) : null;
$foto = isset($_FILES['foto']["name"]) ? $_FILES['foto']["name"] : null;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "Ocurrio un error al modificar el empleado.";

if(isset($_FILES['foto']["name"])){
    $pathFoto = "../backend/empleados/fotos/" . $empleado_json->nombre . "." . date('His') . "." . pathinfo($foto, PATHINFO_EXTENSION);
}
else{
    $pathFoto = $empleado_json->pathFoto;
}

$empleadoAux = new Empleado($empleado_json->id, $empleado_json->nombre, $empleado_json->correo, $empleado_json->clave, $empleado_json->id_perfil, null, $pathFoto, $empleado_json->sueldo);
if($empleadoAux->Modificar()){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Empleado modificado con exito.";
    if(isset($_FILES['foto']["name"])){
        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $pathFoto)){
            $retornoJson->mensaje .= " Junto con su foto";
        }
        else{
            $retornoJson->mensaje .= "Ocurrio un error al guardar la foto.";
        }
    }
}

echo json_encode($retornoJson);

?>


