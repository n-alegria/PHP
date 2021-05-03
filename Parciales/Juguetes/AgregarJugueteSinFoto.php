<?php

/* AgregarJugueteSinFoto.php: 
Se recibe por POST el tipo, el precio y el paisOrigen. Se invocará al método Agregar.
Si retorna true, se debe de escribir en un archivo de texto la fecha (con horas y minutos) 
más la información del juguete (guardarlo en ./archivos/juguetes_sin_foto.txt). Mostrar por pantalla un mensaje de éxito.
Si retorna false, se mostrará por pantalla la información del juguete.*/
require_once('./clases/Juguete.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null;

$jueguete = new Juguete($tipo, $precio, $paisOrigen);
if($jueguete->Agregar()){
    $path = "./archivos/juguetes_sin_foto.txt";
    if(file_exists($path)){
        $archivo = fopen($path, 'a');
        if($archivo){
            $cadena = $jueguete->ToString() . " - " . date("d/n/Y - G:i:s") . "\r\n";
            if(fwrite($archivo, $cadena)){
                echo "Informacion guardada con exito";
            }
        }
        fclose($archivo);
    }
}
else{
    echo $jueguete->ToString();
}

?>