<?php
// AgregarRecetaSinFoto.php: Se recibe por POST el nombre, los ingredientes y el tipo. Se invocará al método
// Agregar.
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

require_once "./clases/Receta.php";

//Se recibe por POST el tipo, el precio y el paisOrigen. 
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
$ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : NULL;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;

$receta = new Receta('', $nombre, $ingredientes, $tipo, '');

$retornoJson= new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo agregar la receta";

if($receta->Agregar())
{
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se pudo agregar la receta";
}
echo json_encode($retornoJson);
