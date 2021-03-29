<?php

// La accion siempre la recibo por $_GET[]
$accion = isset($_GET["accion"]) ? $_GET["accion"] : "Error";

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "Error al transferir datos";
$apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "Error al transferir datos";
$legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : "Error al transferir datos";

$cadena = $legajo . " - " . $nombre . " - " .$apellido . "\r\n";

switch($accion){
    case "alta":
        $archivo = fopen("./archivos/alumnos.txt", "a+");
        fwrite($archivo, $cadena);
        fclose($archivo);
        echo $cadena;
        break;
    case "listado":
        $archivo = fopen("./archivos/alumnos.txt", "r+");
        echo fread($archivo, filesize("./archivos/alumnos.txt"));
        break;
    case "verificar":
        $archivo = fopen("./archivos/alumnos.txt", "r");
        $bandera = false;
        while(!feof($archivo)){
            $linea = fgets($archivo);
            $arrayLinea = explode(" - ", $linea); // Separa un string de acuerdo al delimitador, retorna un array
            if($arrayLinea[0] == $_POST["legajo"]){
                echo $arrayLinea[0] . ' - ' . $arrayLinea[1] . ' - ' . $arrayLinea[2];
                $bandera = true;
            }   
        }
        fclose($archivo);
        if(!$bandera)
            echo "El alumno con legajo " . $_POST['legajo'] . " no se encuentra en el listado";
        break;
    case "Error":
        echo "aca";
        break;
}

?>