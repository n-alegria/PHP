<?php # -> OK <-

/* ModificarProductoEnvadadoFoto.php:
Se recibirán por POST los siguientes valores: producto_json (id, codigoBarra, nombre, origen y precio, en formato de cadena JSON) 
y la foto (para modificar un producto envasado en la base de datos. Invocar al método Modificar.
Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del
producto envasado a ser modificado.
Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
“./productosModificados/”, con el nombre formado por el nombre punto origen punto 'modificado' punto hora,
minutos y segundos de la modificación (Ejemplo: aceite.italia.modificado.105905.jpg).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/ProductoEnvasado.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$producto_json = isset($_POST["producto_json"]) ? json_decode($_POST["producto_json"]) : null;
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo modificar en la base de datos";

$pathFoto = "./productos/imagenes/$producto_json->nombre.$producto_json->origen." . date('His') . ".". pathinfo($foto, PATHINFO_EXTENSION);
$producto = new ProductoEnvasado($producto_json->nombre, $producto_json->origen, $producto_json->id, $producto_json->codigoBarra, $producto_json->precio, $pathFoto);

$pathOriginal = "";
foreach(ProductoEnvasado::Traer() as $item){
    if($producto_json->id == $item->id){
        $pathOriginal = $item->pathFoto;
        break;
    }
}
if($producto->Modificar()){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se modifico con exito de la base de datos";

    $path = "./productosModificados/$producto->nombre.$producto->origen.modificado." . date('His') . "." . pathinfo($producto->pathFoto, PATHINFO_EXTENSION);
    copy($pathOriginal, $path);
    unlink($pathOriginal);
}

echo json_encode($retornoJson);

?>