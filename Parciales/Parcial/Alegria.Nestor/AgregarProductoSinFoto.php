<?php # -> OK <-

/* AgregarProductoSinFoto.php: 
Se recibe por POST el parámetro producto_json (codigoBarra, nombre, origen y precio), en formato de cadena JSON. 
Se invocará al método Agregar.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/ProductoEnvasado.php');

$producto_json = isset($_POST["producto_json"]) ? json_decode($_POST["producto_json"]) : null;

$producto = new ProductoEnvasado($producto_json->nombre, $producto_json->origen, null, $producto_json->codigoBarra, $producto_json->precio, null);

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo agregar en la base de datos";

if($producto->Agregar()){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se agrego con exito en la base de datos";
}

echo json_encode($retornoJson);

?>