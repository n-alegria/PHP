<?php # -> OK <-

/* MostrarBorradosJSON.php: 
Muestra todo lo registrado en el archivo “productos_eliminados.json”. Para ello,
agregar un método estático (en ProductoEnvasado), llamado MostrarBorradosJSON. */

require_once('./clases/ProductoEnvasado.php');
$listado = ProductoEnvasado::MostrarBorradosJSON();

if($listado !== null && count($listado) !== 0){
    echo json_encode($listado);
}

?>