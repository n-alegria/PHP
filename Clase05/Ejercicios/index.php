<?php
/*
*-UNA VEZ TESTEADO EN EL ENTORNO LOCAL, SUBIR BASE Y PAGINA AL HOST REMOTO.
*-VERIFICAR EL BUEN FUNCIONAMIENTO (RETOCAR DE SER NECESARIO).
*-PUBLICAR LA URL DEL HOST PARA SER TESTEADO POR EL PROFESOR.
*/
$opcion = $_POST['opcion'];
$correo = isset($_POST['correo']) ? $_POST["correo"] : "error" ;
$clave = isset($_POST['clave']) ? $_POST["clave"] : "error";

$host = 'localhost';
$user = 'root';
$pass = '';
$base = 'usuarios_test';


switch ($opcion){
    case 'login':
        $con = @mysqli_connect($host, $user, $pass, $base);
        $sql = "SELECT nombre, perfiles.descripcion FROM `usuarios` 
                INNER JOIN perfiles ON perfiles.id = usuarios.id 
                WHERE correo = '$correo' AND clave = '$clave' ";
        $rs = $con->query($sql);

        if(!mysqli_num_rows($rs)){
            echo "Correo y/o Contraseñas incorrectos.";
        }
        else{
            $usuario = $rs->fetch_object();
            echo($usuario->nombre . " " . $usuario->descripcion);
        }
        mysqli_close($con);
 
        case 'mostrar':
            $con = @mysqli_connect($host, $user, $pass, $base);
            $sql = "SELECT * FROM usuarios
                    INNER JOIN perfiles
                    ON perfiles.id = usuarios.perfil";
            $rs = $con->query($sql);
            if(!mysqli_num_rows($rs)){
                echo "No hay datos que mostrar";
            }
            else{
                while($row = $rs->fetch_object()){
                    $user_arr[] = $row;
                }
                foreach ($user_arr as $user) {
                    echo($user->id . " - " . $user->correo . " - " . $user->clave . " - " . $user->nombre . " - " . $user->perfil . " - " . $user->descripcion) . "<br/>";
                }
            }
            mysqli_close($con);
        
        default:
            echo "Fatal Error";
}

?>