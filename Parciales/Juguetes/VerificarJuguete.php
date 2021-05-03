<?php
/* VerificarJuguete.php: 
Se recibe por GET el tipo y el paisOrigen, si coincide con algún registro de la base de datos (invocar al método Traer)
retornar los datos del objeto (invocar al ToString) más su precio con Iva incluído. 
Caso contrario informar: si no coincide el tipo o el paisOrigen o ambos. */

require_once('./clases/Juguete.php');

$tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : null;
$paisOrigen = isset($_GET["paisOrigen"]) ? $_GET["paisOrigen"] : null;

$arrayJuguetes = Juguete::Traer();
$flag = false;
foreach ($arrayJuguetes as $juguete) {
    if($juguete->GetTipo() == $tipo && $juguete->GetPais() == $paisOrigen){
        $cadena = $juguete->ToString() . " - " . $juguete->CalcularIVA();
        echo $cadena;
        $flag = true;
        break;
    }
}
if(!$flag){
    $coincidePais = false;
    $coincideTipo = false;
    foreach($arrayJuguetes as $juguete){
        if($juguete->GetTipo() == $tipo){
            $coincideTipo = true;
        }
        else if($juguete->GetPais() == $paisOrigen){
            $coincidePais = $paisOrigen;
        }
    }
    if(!$coincidePais && !$coincideTipo)
        echo "No coinciden el <b>Pais</b> ni el <b>Tipo</b>.";
    else if($coincidePais)
        echo "Coincide el <b>Pais</b> pero no el <b>Tipo</b>.";
    else if($coincideTipo)
        echo "Coincide el <b>Tipo</b> pero no el <b>Pais</b>.";
}
?>