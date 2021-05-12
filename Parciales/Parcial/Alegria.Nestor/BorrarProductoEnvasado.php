<?php # -> OK <-

/* BorrarProductoEnvasado.php:
Se recibe el parámetro producto_json (id, codigoBarra, nombre, origen, precio y
pathFoto en formato de cadena JSON), se deberá borrar el producto envasado (invocando al método Eliminar).
Si se pudo borrar en la base de datos, invocar al método GuardarEnArchivo.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
Si se invoca por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todos los productos
envasados borrados y sus respectivas imagenes. */

require_once('./clases/ProductoEnvasado.php');
$producto_json = isset($_POST["producto_json"]) ? json_decode($_POST["producto_json"]) : null;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo eliminar en la base de datos";

if(!isset($_POST["producto_json"])){
    $listadoDeBorrados = array();
    $archivo = fopen('./archivos/productos_envasados_borrados.txt', 'r');
    while(!feof($archivo)){
        $lineaLeida = trim(fgets($archivo));
        if ($lineaLeida > 0) {
            $productoJson = json_decode($lineaLeida);
            $productoAux = new ProductoEnvasado($productoJson->nombre, $productoJson->origen, $productoJson->id, $productoJson->codigoBarra, $productoJson->precio, $productoJson->pathFoto);
            array_push($listadoDeBorrados, $productoAux);
        }
    }
            echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Listado</title>
            <style>
            table,
            tr,
            td{
                border: 1px solid black;
                border-collapse: collapse;
                padding: 10px;
            }
            </style>
        <div>
        <table border=1>
            <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Origen</td> 
                    <td>Codigo de Barra</td>
                    <td>Precio</td>
                    <td>Imagen</td>
                </tr>
            </thead>";
        foreach($listadoDeBorrados as $producto){
            echo "<tr>";
            echo "<td>" . $producto->nombre . "</td>";
            echo "<td>" . $producto->origen . "</td>";
            echo "<td>" . $producto->codigoBarra . "</td>";
            echo "<td>" . $producto->precio . "</td>";
            if($producto->pathFoto !== "" or $producto->pathFoto !== null){
                    echo "<td><img width=50px height=50px src='" . $producto->pathFoto . "'/></td>";
            }
        }
        echo "</tr>";
        echo "</table>
        </div>
        </head>
        <body>";

}
else{
    if(ProductoEnvasado::Eliminar($producto_json->id)){
        $retornoJson->exito = true;
        $retornoJson->mensaje = "Se elimino de la base de datos.";
        $producto = new ProductoEnvasado($producto_json->nombre, $producto_json->origen, $producto_json->id, $producto_json->codigoBarra, $producto_json->precio, $producto_json->pathFoto);
        if($producto->GuardarEnArchivo()){
            $retornoJson->mensaje .= " Y se almaceno en el archivo con exito";
        }
        else{
            $retornoJson->mensaje .= " Ocurrio un error al guardar en el archivo";
        }
    }
    else{
        $retornoJson->mensaje = ". El 'id' ingresado no existe";
    }
      
    echo json_encode($retornoJson);
}

?>