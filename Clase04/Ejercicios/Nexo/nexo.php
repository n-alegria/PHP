<?php

// La accion siempre la recibo por $_GET[]
$accion = isset($_GET["accion"]) ? $_GET["accion"] : "Error";

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "Error al transferir datos";
$apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "Error al transferir datos";
$legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : "Error al transferir datos";

// echo $pathInfoImagen['dirname'], "\n"; // nombre
// echo $pathInfoImagen['basename'], "\n"; // nombre con extension
// echo $pathInfoImagen['extension'], "\n"; // extension
// echo $pathInfoImagen['filename'], "\n"; // nombre del archivo

switch($accion){
    case "alta":
        $pathFoto = "foto/".$_FILES["foto"]["name"];
        $cadena = $legajo . " - " . $apellido . " - " . $nombre . " - " . $pathFoto . "\r\n";
        $archivo = fopen("./archivos/alumnos.txt", "a+");
        fwrite($archivo, $cadena);
        fclose($archivo);
        echo $cadena;
        $pathInfoImagen = pathinfo("foto/".$_FILES["foto"]["name"]);
        $_FILES["foto"]["name"] = $legajo . "." . $pathInfoImagen['extension'];
        move_uploaded_file($_FILES["foto"]["tmp_name"], "foto/".$_FILES["foto"]["name"]);
        break;
    case "listado":
        $archivo = fopen("./archivos/alumnos.txt", "r+");
        echo fread($archivo, filesize("./archivos/alumnos.txt"));
        break;
    case "verificar":
        $archivo = fopen("./archivos/alumnos.txt", "r");
        $_POST["legajo"] = 106211;
        $bandera = false;
        while(!feof($archivo)){
            $linea = trim(fgets($archivo));
            $arrayLinea = explode(" - ", $linea); // Separa un string de acuerdo al delimitador, retorna un array
            if($arrayLinea[0] == $_POST["legajo"]){
                $bandera = true;

                session_start();
                $_SESSION["legajo"] = $arrayLinea[0];
                $_SESSION["apellido"] = $arrayLinea[1];
                $_SESSION["nombre"] = $arrayLinea[2];

                header ("location:principal.php");
            }   
        }
        fclose($archivo);
        if(!$bandera)
            echo "El alumno con legajo " . $_POST['legajo'] . " no se encuentra en el listado";
        break;
}

?>