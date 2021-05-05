<?php

/* ModificarProductoEnvadadoFoto.php:
Se recibirán por POST los siguientes valores: producto_json (id,
codigoBarra, nombre, origen y precio, en formato de cadena JSON) y la foto (para modificar un producto
envasado en la base de datos. Invocar al método Modificar.
Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del
producto envasado a ser modificado.
Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
“./productosModificados/”, con el nombre formado por el nombre punto origen punto 'modificado' punto hora,
minutos y segundos de la modificación (Ejemplo: aceite.italia.modificado.105905.jpg).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/ProductoEnvasado.php');
$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : null;
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

$productoAux = json_decode($producto_json);

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo eliminar en la base de datos";
$producto = new ProductoEnvasado($productoAux->nombre, $productoAux->origen, $productoAux->id, $productoAux->codigoBarra, $productoAux->precio, $productoAux->pathFoto);

if($producto->Modificar()){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se modifico con exito de la base de datos";

    $path = "./productosModificados/" . $producto->nombre . "." . $producto->origen . "." . date('His') . "." . pathinfo($producto->pathFoto, PATHINFO_EXTENSION);
    copy($this->pathFoto, $path);
    unlink($this->pathFoto);
}

echo $retornoJson;

?>