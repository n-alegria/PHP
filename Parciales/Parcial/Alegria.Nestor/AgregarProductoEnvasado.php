<?php # -> OK <-

/* AgregarProductoEnvasado.php:
Se recibirán por POST los valores: codigoBarra, nombre, origen, precio y la foto
para registrar un producto envasado en la base de datos.
Verificar la previa existencia del producto envasado invocando al método Existe. Se le pasará como parámetro el
array que retorna el método Traer.
Si el producto envasado ya existe en la base de datos, se retornará un mensaje que indique lo acontecido.
Si el producto envasado no existe, se invocará al método Agregar. La imagen se guardará en
“./productos/imagenes/”, con el nombre formado por el nombre punto origen punto hora, minutos y segundos
del alta (Ejemplo: tomate.argentina.105905.jpg).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

require_once('./clases/ProductoEnvasado.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$codigoBarra = isset($_POST["codigoBarra"]) ? $_POST["codigoBarra"] : null;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

$listado = ProductoEnvasado::Traer();
if($listado !== null & count($listado) !== 0){
    
    $retornoJson = new stdClass();
    $retornoJson->exito = false;
    $retornoJson->mensaje = "Error al guardar en la base de datos";

    $pathFoto = "./productos/imagenes/$nombre.$origen." . date('His') . ".". pathinfo($foto, PATHINFO_EXTENSION);
    $productoAux = new ProductoEnvasado($nombre, $origen, null, $codigoBarra, $precio, $pathFoto);
    
    if($productoAux->Existe($listado)){
        $retornoJson->mensaje = "El producto existe en el listado";
    }
    else{
        if($productoAux->Agregar()){
            $retornoJson->exito = true;
            $retornoJson->mensaje = "Se agrego a la base de datos";
            if(move_uploaded_file($_FILES["foto"]["tmp_name"], $pathFoto)){
                $retornoJson->mensaje .= ", junto con su foto";
            }
            else{
                $retornoJson->mensaje .= ", ocurrio un error al guardar la foto";
            }
        }
    }

    echo json_encode($retornoJson);
}
?>