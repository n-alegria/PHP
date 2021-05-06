<?php

class Producto
{
    public $nombre;
    public $origen;

    public function __construct($nombre = null, $origen = null)
    {
        $this->nombre = $nombre != null ? $nombre : "";
        $this->origen = $origen != null ? $origen : "";
    }

    /* método de instancia ToJSON(), que retornará los datos de la instancia (en una cadena
    con formato JSON). */
    public function ToJSON()
    {
        $retornoJson = new stdClass();
        $retornoJson->nombre = $this->nombre;
        $retornoJson->origen = $this->origen;

        return json_encode($retornoJson);
    }

    /* Método de instancia GuardarJSON($path), que agregará al producto en el path recibido por parámetro.
    Retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */
    public function GuardarJSON($path)
    {
        $retornoJson = new stdClass();
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No se pudo guardar en el archivo";
        if (file_exists($path)) {
            $archivo = fopen($path, "a");
            if ($archivo) {
                fwrite($archivo, $this->ToJSON() . "\r\n");
                $retornoJson->exito = true;
                $retornoJson->mensaje = "Producto guardado con exito.";
            }
            fclose($archivo);
        }
        return json_encode($retornoJson);
    }

    /* Método de clase TraerJSON(), que retornará un array de objetos de tipo producto. */
    public static function TraerJson()
    {
        $arrayProductos = array();
        if (file_exists("./archivos/productos.json")) {
            $archivo = fopen("./archivos/productos.json", "r");
            if ($archivo) {
                while (!feof($archivo)) {
                    $lineaLeida = trim(fgets($archivo));
                    if ($lineaLeida > 0) {
                        $productoJson = json_decode($lineaLeida);
                        $productoAux = new Producto($productoJson->nombre, $productoJson->origen);
                        array_push($arrayProductos, $productoAux);
                    }
                }
            }
            fclose($archivo);
        }
        return $arrayProductos;
    }

    /* Método de clase VerificarProductoJSON($producto), que recorrerá el array obtenido del método TraerJSON y
    retornará un JSON que contendrá: existe(bool) y mensaje(string).
    Si el producto está registrado (comparar por nombre y origen), retornará true y el mensaje indicará cuantos
    productos están registrados con el mismo origen del producto recibido por parámetro. 
    Caso contrario, retornará false, y el/los nombres de la/las productos más populares (mayor cantidad de apariciones). */
    public static function VerificarProductoJSON($producto)
    {
        $listado = Producto::TraerJson();

        $retornoJson = new stdClass();
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No hay producto con coincidencias";

        if($listado !== null && $listado !== 0){
            $countOrigen = 0;
            foreach($listado as $item)
            {
                if($item->origen == $producto->origen){
                    $countOrigen++;
                    if($item->nombre == $producto->nombre){
                        $retornoJson->exito = true;
                    }
                }
            }
            # Si coincide 'nombre' y 'origen' entra aca y muestra cantidad de productos por 'origen'
            if($retornoJson->exito == true){
                $retornoJson->mensaje = "Se encontraron '" . $countOrigen . "' productos del mismo origen.";
            }
            # De lo contrario entra aca y muestra cuales son los de mayor cantiadad por 'nombre'
            else{
                $arrayValores = array();
                foreach ($listado as $item) {
                    array_push($arrayValores, $item->nombre);
                }
                $arrayNombres = array_count_values($arrayValores);
                // var_dump($arrayNombres);
                // echo "Maximo: " . max($arrayNombres);
                $retornoJson->mensaje = "Listado de los mas populares: ";
                foreach($arrayNombres as $key => $cantidad){
                    if(max($arrayNombres) == $cantidad){
                        $retornoJson->mensaje .= $key . ", ";
                    }
                }
            }
        }
        else{
            $retornoJson->mensaje = "El listado se encuentra vacio.";
        }
        return json_encode($retornoJson);
    }
}