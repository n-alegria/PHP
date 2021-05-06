<?php # -> OK <-

/* ListadoProductosEnvasados.php: (GET) 
Se mostrará el listado completo de los productos envasados (obtenidos de la base de datos) en una tabla (HTML con cabecera). 
Invocar al método Traer.
Nota: Si se recibe el parámetro tabla con el valor mostrar, retornará los datos en una tabla (HTML con cabecera),
preparar la tabla para que muestre la imagen, si es que la tiene.
Si el parámetro no es pasado o no contiene el valor mostrar, retornará el array de objetos con formato JSON. */

require_once('./clases/ProductoEnvasado.php');
$tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : null;
$listado = ProductoEnvasado::Traer();
if($listado !== null or count($listado) !== 0){
    if($tabla == "mostrar"){

        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
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
        <div>
        <table border=1>
            <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Origen</td> 
                    <td>Codigo de Barra</td>
                    <td>Precio</td>
                    <td>Imagen</td>
                </tr>
            </thead>";
        foreach($listado as $producto){
            echo "<tr>";
            echo "<td>" . $producto->nombre . "</td>";
            echo "<td>" . $producto->origen . "</td>";
            echo "<td>" . $producto->codigoBarra . "</td>";
            echo "<td>" . $producto->precio . "</td>";
            if($producto->pathFoto !== "" or $producto->pathFoto !== null){
                    echo "<td><img width=50px height=50px src='" . $producto->pathFoto . "'/></td>";
            }
        }
        echo "</tr>";
        echo "</table>
        </div>
        </head>
<body>";
    }
    else{
        echo json_encode($listado);
    }
}
else{
    echo "El listado esta vacio";
}

?>
