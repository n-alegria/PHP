<?php
/* ListadoEmpleados.php: (GET) 
Se mostrará el listado completo de los empleados (obtenidos de la base de datos). Invocar al método TraerTodos.
Si se recibe el parámetro tabla con el valor mostrar, retornará los datos en una tabla (HTML con cabecera). 
Si el parámetro no es pasado, retornará el array de objetos con formato JSON.
Nota: preparar la tabla (HTML) con una columna extra para que muestre la imagen de la foto (50px X 50px). */

require_once('./clases/Empleado.php');

$parametro = isset($_GET["tabla"]) ? $_GET["tabla"] : "json";
$arrayEmpleados = Empleado::TraerTodos();
if ($arrayEmpleados !== null && count($arrayEmpleados) !== 0) {
    if(isset($_GET["tabla"])) {
        echo "<!DOCTYPE html>
        <html lang='es'>
        
        <head>
            <meta charset='UTF-8'>
            <title>Listado</title>
            <style>
                table,
                th,
                tr,
                td {
                    border: 1px solid black;
                    border-collapse: collapse;
                    padding: 15px;
                }
            </style>
        </head>
        
        <body>
        <div>
        <table style=''>
        <thead>
            <tr>
                <TH>ID</TH>
                <TH>NOMBRE</TH>
                <TH>CORREO</TH>
                <TH>ID_PERFIL</TH>
                <TH>PERFIL</TH>
                <TH>SUELDO</TH>
                <TH>FOTO</TH>
            </tr>
        </thead>";
        foreach ($arrayEmpleados as $empleado) {
            echo "<tr>";
            echo "<td>" . $empleado->id . "</td>";
            echo "<td>" . $empleado->nombre . "</td>";
            echo "<td>" . $empleado->correo . "</td>";
            echo "<td>" . $empleado->id_perfil . "</td>";
            echo "<td>" . $empleado->perfil . "</td>";
            echo "<td>" . $empleado->sueldo . "</td>";
            echo "<td><img width=50px height=50px src='" . $empleado->foto . "'/></td>";
            echo "</tr>";
        }
        echo "</table>
        </div>    
        </body>
        </html>";
    }
    else{
        echo json_encode($arrayEmpleados);
    }
    
}