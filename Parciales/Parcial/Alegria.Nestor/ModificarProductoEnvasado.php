<?php # -> OK <-

/* ModificarProductoEnvadado.php: 
Se recibirán por POST los siguientes valores: producto_json (id, codigoBarra, nombre, origen y precio, en formato de cadena JSON) 
para modificar un producto envasado en la base de datos.
Invocar al método Modificar.
Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del
producto envasado a ser modificado.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/ProductoEnvasado.php');


$producto_json = isset($_POST["producto_json"]) ? json_decode($_POST["producto_json"]) : null;

$producto = new ProductoEnvasado($producto_json->nombre, $producto_json->origen, $producto_json->id, $producto_json->codigoBarra, $producto_json->precio, null);

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo modificar en la base de datos";

if($producto->Modificar()){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se modifico con exito en la base de datos";
}

echo json_encode($retornoJson);

?>