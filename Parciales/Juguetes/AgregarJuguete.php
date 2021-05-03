<?php

/* AgregarJuguete.php: 
Se recibirán por POST todos los valores (incluida una imagen) para registrar un juguete en la base de datos.
Verificar la previa existencia del juguete invocando al método Verificar. Se le pasará como parámetro el array que retorna el método Traer.
Si el juguete ya existe en la base de datos, se retornará un mensaje por pantalla que indica lo acontecido.
Si el juguete no existe, se invocará al método Agregar. 
La imagen guardarla en “./juguetes/imagenes/”, con el nombre formado por el tipo punto paisOrigen punto hora minutos y segundos del borrado (Ejemplo: auto.china.105905.jpg).
Si se pudo agregar se redirigirá hacia Listado.php. Caso contrario, se mostrará un mensaje de error. */

require_once('./clases/Juguete.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null;
$pathFoto = isset($_FILES["pathFoto"]["name"]) ? $_FILES["pathFoto"]["name"] : null;

$pathDestino = "juguetes/imagenes/" . $tipo . "." . $paisOrigen . "." . date('His') . "." . pathinfo($pathFoto, PATHINFO_EXTENSION);
$juguete = new Juguete($tipo, $precio, $paisOrigen, $pathDestino);

if(!$juguete->Verificar(Juguete::Traer())){
    echo "<b>El juguete ya existe en la base de datos.</b>";
}
else{
    if($juguete->Agregar()){
        if(move_uploaded_file($_FILES["pathFoto"]["tmp_name"], $pathDestino)){
            header("Location: Listado.php");
        }
        else{
            echo "No fue posible guardar la foto.";
        }
    }
    else{
        echo "No fue posible agregar el juguete.";
    }
}

?>