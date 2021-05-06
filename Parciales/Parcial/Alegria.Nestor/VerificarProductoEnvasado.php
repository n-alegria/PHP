<?php # -> OK <-

/* VerificarProductoEnvasado.php:
Se recibe por POST el parámetro obj_producto, que será una cadena JSON (nombre y origen), 
si coincide con algún registro de la base de datos (invocar al método Traer) retornará los datos
del objeto (invocar al ToJSON). Caso contrario, un JSON vacío ({}). */

require_once('./clases/ProductoEnvasado.php');

$obj_json = isset($_POST["obj_producto"]) ? json_decode($_POST["obj_producto"]) : null;

$retorno = '{}';

$listado = ProductoEnvasado::Traer();
if($listado !== null && count($listado) !== 0){
    if($obj_json !== null){
        $productoAux = new ProductoEnvasado($obj_json->nombre, $obj_json->origen);
        foreach($listado as $item){
            if($item->nombre == $obj_json->nombre && $item->origen == $obj_json->origen){
                $retorno = $item->ToJSON();
                break;
            }
        }
    }
    echo $retorno;
}
else{
    echo "El listado esta vacio";
}

?>