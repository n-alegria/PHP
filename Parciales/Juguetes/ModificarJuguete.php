<?php

/* ModificarJuguete.php: 
Se recibirán por POST todos los valores (incluida una imagen) para modificar un juguete en la base de datos. Invocar al método Modificar.
Si se pudo modificar en la base de datos, la foto modificada se moverá al subdirectorio “./juguetesModificados/”, 
con el nombre formado por el tipo punto paisOrigen punto 'modificado' punto hora minutos y segundos de la modificación 
(Ejemplo: bolita.taiwan.modificado.105905.jpg). Redirigir hacia Listado.php.
Si no se pudo modificar, se mostrará un mensaje por pantalla. */

require_once('./clases/Juguete.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null; 
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null; 
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null; 
$pathImagen = isset($_FILES["pathImagen"]["name"]) ? $_FILES["pathImagen"]["name"] : null; 

$pathDestino = $tipo . "." . $paisOrigen . "." . "modificado" . "." . date('His') . "." . pathinfo($pathImagen, PATHINFO_EXTENSION);
$juguete = new Juguete($tipo, $precio, $paisOrigen, $pathDestino);
if($juguete->Agregar()){
    
}

?>