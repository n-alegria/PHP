<?php # -> OK <-

/* ListadoProductosJSON.php: (GET) 
Se mostrará el listado de todos los productos en formato JSON (TraerJSON). */

require_once('./clases/Producto.php');

$listado = Producto::TraerJson();
if($listado !== null && $listado !== 0){
    echo json_encode($listado);
}
else{
    echo "El listado esta vacio";
}