<?php

/* AltaProductoJSON.php:
Se recibe por POST el nombre y el origen. Invocar al método GuardarJSON y pasarle './archivos/productos.json' cómo parámetro. */

require_once('./clases/Producto.php');

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : null;

if($nombre != null and $origen != null){
    $producto = new Producto($nombre, $origen);
    $exito = $producto->GuardarJSON('./archivos/productos.json');
    $mensaje = json_decode($exito);
    
    if($mensaje->exito){
        echo "Producto guardado correctamente.";
    }
    else{
        echo "Ocurrio un error al guardar el producto.";
    }
}
else{
    echo "No se reconoce uno o ambos parametros pasasdos por 'POST'";
}

?>