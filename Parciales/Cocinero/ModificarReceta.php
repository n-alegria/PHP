<?php
// ModificarReceta.php: Se recibirán por POST los siguientes valores: receta_json (id, nombre, ingredientes, tipo y
// pathFoto, en formato de cadena JSON) y foto (para modificar una receta en la base de datos. Invocar al método Modificar.
// Nota: El valor del id, será el id de la receta 'original', mientras que el resto de los valores serán los de la receta modificada.
// Si se pudo modificar en la base de datos, la foto modificada se moverá al subdirectorio “./recetasModificadas/”,
// con el nombre formado por el nombre punto tipo punto 'modificado' punto hora, minutos y segundos de la
// modificación (Ejemplo: puchero.bodegon.modificado.105905.jpg).
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

require_once "./clases/Receta.php";

$receta_json = isset($_POST['receta_json']) ? json_decode($_POST['receta_json']) : null;
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo modificar la receta";

$receta= new Receta($receta_json->id, $receta_json->nombre, $receta_json->ingredientes, $receta_json->tipo, $receta_json->pathFoto);
$recetaAnterior = null;

$listado = $receta->Traer();

foreach ($listado as $auxiliar) {
    if($auxiliar->id == $receta->id){
        $recetaAnterior = $auxiliar;
        break;
    }
}

if($receta->Modificar())
{
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se pudo modidicar la receta";

    // Muevo y elimino la foto anterior
    $pathModificado = "$recetaAnterior->nombre.$recetaAnterior->tipo.modificado." . date('Gis') . '.' . pathinfo($recetaAnterior->pathFoto, PATHINFO_EXTENSION);
    copy("./recetas/imagenes/" . $recetaAnterior->pathFoto, "./recetasModificadas/" . $pathModificado);
    unlink("./recetas/imagenes/" . $recetaAnterior->pathFoto);

    // Agrego la foto nueva
    $nuevaFoto= "$receta->nombre.$receta->tipo." . date("Gis") . "." . pathinfo($foto, PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["foto"]["tmp_name"], "./recetas/imagenes/$nuevaFoto");
}
echo json_encode($retornoJson);
?>