<?php # -> OK <-

/* EliminarProductoEnvasado.php: 
Recibe el parámetro producto_json (id, nombre y origen, en formato de cadena JSON) por POST 
y se deberá borrar el producto envasado (invocando al método Eliminar).
Si se pudo borrar en la base de datos, invocar al método GuardarJSON y pasarle './archivos/productos_eliminados.json' cómo parámetro.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/ProductoEnvasado.php');

$producto_json = isset($_POST["producto_json"]) ? json_decode($_POST["producto_json"]) : null;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo eliminar de la base de datos";

if(ProductoEnvasado::Eliminar($producto_json->id)){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se elimino con exito de la base de datos";
    $producto = new Producto($producto_json->nombre, $producto_json->origen);
    if($producto->GuardarJSON('./archivos/productos_eliminados.json')){
        $retornoJson->mensaje .= " y se guardo en el archivo correspondiente";
    }
    else{
        $retornoJson->mensaje .= ", pero ocurrio un error al guardar en el archivo.";
    }
}
else{
    echo "No existe el id ingresado en la base de datos";
}

echo json_encode($retornoJson);

?>