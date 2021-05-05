<?php

require_once('./clases/ProductoEnvasado.php');


$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : null;
$registro = json_decode($producto_json);

$producto = new ProductoEnvasado($registro->nombre, $registro->origen, null, $registro->codigoBarra, $registro->precio, null);

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo agregar en la base de datos";

if($producto->Agregar()){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se agrego con exito en la base de datos";
}

echo json_encode($retornoJson);

?>