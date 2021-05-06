<?php # -> OK <-

/* AltaProductoJSON.php:
Se recibe por POST el nombre y el origen. Invocar al método GuardarJSON 
y pasarle './archivos/productos.json' cómo parámetro. */

require_once('./clases/Producto.php');

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : null;

if($nombre != null and $origen != null){
    $producto = new Producto($nombre, $origen);
    $mensaje = $producto->GuardarJSON('./archivos/productos.json');
    echo $mensaje;
}
else{
    echo "No se reconoce uno o ambos parametros pasasdos por 'POST'";
}

?>