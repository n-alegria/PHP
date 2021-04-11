<?php
session_start();
if(!isset($_SESSION)){
    header("location:nexo.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Principal</title>
    <style>
        h1, h2{
            text-align: center;
        }
        table{
            width: 50%;
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
        }
        table tr th{
            border: 1px solid black;
            background-color: tomato;
        }
        table tr td{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <?php
    echo "<h1>" . $_SESSION["legajo"] . "</h1>";
    echo "<h2>" . $_SESSION["nombre"] . " " . $_SESSION["apellido"] . "</h2>";
    ?>
    <table align="center">
    <tr>
        <th>Legajo</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Path</th>
    </tr>
    <?php
    $archivo = fopen("./archivos/alumnos.txt", "r");
    while(!feof($archivo)){
        $linea = trim(fgets($archivo));
        $arrayLinea = explode(" - ", $linea); // Separa un string de acuerdo al delimitador, retorna un array
        echo "<tr>";
        echo "<td>" . $arrayLinea[0] . "</td>";
        echo "<td>" . $arrayLinea[1] . "</td>";
        echo "<td>" . $arrayLinea[2] . "</td>";
        echo "<td><img style='width:30%' src='" . $arrayLinea[3] . "'/></td>";
        echo "</tr>";
    }
    fclose($archivo);
    ?>
    </table>
</body>
</html>