<?php # -> OK <-

/* MostrarCookie.php: 
Se recibe por GET el nombre y el origen del producto y se verificará si existe una cookie con el mismo nombre, 
de ser así, retornará un JSON que contendrá: éxito(bool) y mensaje(string), dónde se mostrará el contenido de la cookie.
Caso contrario, false y el mensaje indicando lo acontecido. */

$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
$origen = isset($_GET['origen']) ? $_GET['origen'] : null;


if($nombre != null and $origen != null){
    $retornoJson = new stdClass();
    $retornoJson->exito = false;
    $retornoJson->mensaje = "No existe la cookie";

    $cookie = $nombre . "_" . $origen;

    if(isset($_COOKIE[$cookie])) {
        $retornoJson->exito = true;
        $retornoJson->mensaje = $_COOKIE[$cookie];
    }

    echo json_encode($retornoJson);
}
else{
    echo "No se reconoce uno o ambos parametros pasasdos por 'POST'";
}

?>