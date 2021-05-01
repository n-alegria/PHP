<?php
/* EliminarEmpleado.php: 
Recibe el parámetro id por POST y se deberá borrar el empleado (invocando al método Eliminar).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/Empleado.php');
$id = isset($_POST['id']) ? $_POST['id'] : null;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "Ocurrio un error al eliminar el empleado.";

if(Empleado::Eliminar($id)){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Empleado eliminado con exito.";
}

echo json_encode($retornoJson);

?>