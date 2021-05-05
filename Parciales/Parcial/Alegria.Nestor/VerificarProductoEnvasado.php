<?php

/* VerificarProductoEnvasado.php:
Se recibe por POST el parámetro obj_producto, que será una cadena JSON
(nombre y origen), si coincide con algún registro de la base de datos (invocar al método Traer) retornará los datos
del objeto (invocar al ToJSON). Caso contrario, un JSON vacío ({}). */

require_once('./clases/ProductoEnvasado.php');

$obj_json = isset($_POST["obj_producto"]) ? $_POST["obj_producto"] : null;
$obj_producto = json_decode($obj_json);

$listado = ProductoEnvasado::Traer();
if($listado !== null && count($listado) !== 0){
    $producto = new ProductoEnvasado($obj_producto->nombre, $obj_producto->origen);
    if($producto->Existe($listado)){
        echo $producto->ToJSON();
    }
    else{
        echo json_encode('{}');
    }
}
else{
    echo "El listado esta vacio";
}

?>