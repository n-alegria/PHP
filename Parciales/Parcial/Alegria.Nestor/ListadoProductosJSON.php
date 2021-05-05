<?php

/* ListadoProductosJSON.php: (GET) 
Se mostrará el listado de todos los productos en formato JSON (TraerJSON). */

require_once('./clases/Producto.php');

$arrayProductos = Producto::TraerJson();
if($arrayProductos !== null && $arrayProductos !== 0){
    foreach($arrayProductos as $producto){
        echo $producto->ToJSON() . "\n";
    }
}
else{
    echo "El listado esta vacio";
}