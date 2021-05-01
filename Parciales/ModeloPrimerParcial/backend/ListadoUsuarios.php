<?php /* ListadoUsuarios.php: (GET) 
Se mostrará el listado completo de los usuarios, exepto la clave (obtenidos de la base de datos). Invocar al método TraerTodos.
Si se recibe el parámetro tabla con el valor mostrar, retornará los datos en una tabla (HTML con cabecera).
Si el parámetro no es pasado, retornará el array de objetos con formato JSON.
*/ 
require_once("./clases/Usuario.php");
$parametro = isset($_GET["tabla"]) ? $_GET["tabla"] : "json";
$arrayUsuarios = Usuario::TraerTodos();
if ($arrayUsuarios !== null && count($arrayUsuarios) !== 0) {
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
            </tr>
        </thead>";
        foreach ($arrayUsuarios as $usuario) {
            echo "<tr>";
            echo "<td>" . $usuario->id . "</td>";
            echo "<td>" . $usuario->nombre . "</td>";
            echo "<td>" . $usuario->correo . "</td>";
            echo "<td>" . $usuario->id_perfil . "</td>";
            echo "<td>" . $usuario->perfil . "</td>";
            echo "</tr>";
        }
        echo "</table>
        </div>    
        </body>
        </html>";
    }
    else{
        $arrayAux = array();
        foreach($arrayUsuarios as $usuario){
            $user = new stdClass();
            $user->id = $usuario->id;
            $user->nombre = $usuario->nombre;
            $user->correo = $usuario->correo;
            $user->id_perfil = $usuario->id_perfil;
            $user->perfil = $usuario->perfil;
            array_push($arrayAux, $user);
        }
        echo json_encode($arrayAux);
    }
    
}

?>
