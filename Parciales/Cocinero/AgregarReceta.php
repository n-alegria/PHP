<?php
// AgregarReceta.php: Se recibirán por POST todos los valores: nombre, ingredientes, tipo y foto para registrar una receta en la base de datos.
// Verificar la previa existencia de la receta invocando al método Existe. Se le pasará como parámetro el array que retorna el método Traer.
// Si la receta ya existe en la base de datos, se retornará un mensaje que indique lo acontecido.
// Si la receta no existe, se invocará al método Agregar. La imagen guardarla en “./recetas/imagenes/”, con el
// nombre formado por el nombre punto tipo punto hora, minutos y segundos del alta (Ejemplo:
// chocotorta.pasteleria.105905.jpg).
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

require_once "./clases/Receta.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : null;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

$nombreFoto= "$nombre.$tipo." . date("Gis") . "." . pathinfo($foto, PATHINFO_EXTENSION);
$recetaAux = new Receta('',$nombre, $ingredientes, $tipo, $nombreFoto);

$listado = $recetaAux->Traer();

$retornoJson= new stdClass();

if($recetaAux->Existe($listado)){
    $retornoJson->exito = false;
    $retornoJson->mensaje = "La receta ya existe";
}
else{    
    $destino = "./recetas/imagenes/$nombreFoto";
    if($recetaAux->Agregar())
    {
        $retornoJson->exito = true;
        $retornoJson->mensaje = "Se pudo agregar la receta";
        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino))
        {
            $retornoJson->mensaje .= " y subir la foto";
        }else{
            $retornoJson->mensaje .= " pero no se pudo subir la foto";
        }
    }
}

echo json_encode($retornoJson);
 
?>