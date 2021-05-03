<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado</title>
    <style>
    table,
    tr,
    td{
        border: 1px solid black;
        border-collapse: collapse;
        padding: 10px;
    }
    </style>
<?php
/* Listado.php: 
Se mostrará el listado completo de los juguetes (obtenidos de la base de datos) en una tabla (con cabecera). 
Invocar al método Traer. Nota: preparar la tabla para que muestre la imagen de la foto (si es que la tiene). */

require_once('./clases/Juguete.php');

$arrayJuguetes = Juguete::Traer();
if($arrayJuguetes !== null or count($arrayJuguetes) !== 0){
    echo "<div>
    <table border=1>
        <thead>
            <tr>
                <td>Tipo</td>
                <td>Precio</td>
                <td>Precio con IVA</td> 
                <td>Pais</td>
                <td>Imagen</td>
            </tr>
        </thead>";
    foreach($arrayJuguetes as $juguete){
        echo "<tr>";
        echo "<td>" . $juguete->GetTipo() . "</td>";
        echo "<td>" . $juguete->GetPrecio() . "</td>";
        echo "<td>" . $juguete->CalcularIVA() . "</td>";
        echo "<td>" . $juguete->GetPais() . "</td>";
        if($juguete->GetPathImagen() !== ""){
            // if(file_exists("./juguetes/imagenes/".$juguete->GetPathImagen())){
                echo "<td><img width=50px height=50px src='" . $juguete->GetPathImagen() . "'/></td>";
            //}
        }
    }
    echo "</tr>";
    echo "</table>
    </div>";
}

?>

</head>
<body>