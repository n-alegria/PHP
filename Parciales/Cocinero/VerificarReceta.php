<?php
// VerificarReceta.php: Se recibe por POST el parámetro receta, que será una cadena JSON (nombre y tipo), si
// coincide con algún registro de la base de datos (invocar al método Traer) retornar los datos del objeto (invocar al
// ToJSON). Caso contrario informar: si no coincide el nombre o el tipo o ambos.
require_once "./clases/Receta.php";

//Se recibe por POST el email y la clave
$receta = isset($_POST['receta']) ? json_decode($_POST['receta']) : NULL;

$nombre = false;
$tipo = false;

$recetaAux = new Receta('', $receta->nombre, '', $receta->tipo, '');
$retorno = '';

$listado = $recetaAux->Traer();
if(count($listado) > 0){
    foreach ($listado as $auxiliar) {
        if($receta->nombre == $auxiliar->nombre && $receta->tipo == $auxiliar->tipo){
            $retorno = $auxiliar->ToJson();
            break;
        }
        else if($auxiliar->nombre == $receta->nombre){
            $nombre = true;
        }
        else if($auxiliar->tipo == $receta->tipo){
            $tipo = true;
        }
    }
    if($retorno == ''){
        if(!$nombre && $tipo){
            $retorno = "El nombre no coincide";
        }
        else if($nombre &&!$tipo){
            $retorno = "El tipo no coincide";
        }
        else if(!$nombre && !$tipo){
            $retorno = 'No coinciden el tipo ni el nombre';
        }
    }
}
else{
    $retorno = 'La lista esta vacia';
}

echo $retorno;