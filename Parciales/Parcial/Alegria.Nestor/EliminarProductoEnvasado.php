<?php

require_once('./clases/ProductoEnvasado.php');

$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : null;
$productoAux = json_decode($producto_json);

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo eliminar en la base de datos";

if(ProductoEnvasado::Eliminar($productoAux->id)){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se elimino con exito de la base de datos";
    $producto = new Producto($productoAux->nombre, $productoAux->origen);
    if($producto->GuardarJSON('./archivos/productos_eliminados.json')){
        $retornoJson->mensaje .= " y se guardo en el archivo correspondiente";
    }
    else{
        $retornoJson->mensaje .= " ocurrio un error al guardar en el archivo.";
    }
}
else{
    echo "No existe producto para el id ingresado";
}

echo json_encode($retornoJson);

?>