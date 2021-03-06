<?php # -> OK <-
 
/* VerificarProductoJSON.php: 
Se recibe por POST el nombre y el origen, si coinciden con algún registro del archivo JSON (VerificarProductoJSON), 
crear una COOKIE nombrada con el nombre y el origen del producto, separado con un guión bajo (limon_tucuman) 
que guardará la fecha actual (con horas, minutos y segundos) más el retorno del mensaje del método estático VerificarProductoJSON de la clase Producto.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido (agregar, aquí también, el
mensaje obtenido del método VerificarProductoJSON). */

require_once('./clases/Producto.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : null;

if($nombre != null and $origen != null){
    $producto = new Producto($nombre, $origen);
    # Mensaje desde el metodo 'VerificarProductoJSON()'
    $mensajeDecode = json_decode($producto->VerificarProductoJSON($producto));
    
    $mensajeRetorno = new stdClass();
    $mensajeRetorno->exito = false;
    $mensajeRetorno->mensaje = "No se pudo guardar la cookie ya que no existe registro con coincidencias.";
    
    if($mensajeDecode->exito){
        $datosCookie = date("d-m-Y - G:i:s") . " - " . $mensajeDecode->mensaje;

        if(setcookie($nombre . "_" . $origen, $datosCookie, time()+360)){
            $mensajeRetorno->exito = true;
            $mensajeRetorno->mensaje = "Cookie almacenada correctamente - ";
            $mensajeRetorno->mensaje .= $mensajeDecode->mensaje;
        }
    }
    else{
        $mensajeRetorno->mensaje .= " - " . $mensajeDecode->mensaje;
    }
}
else{
    echo "No se reconoce uno o ambos parametros pasasdos por 'POST'";
}

echo json_encode($mensajeRetorno);

?>