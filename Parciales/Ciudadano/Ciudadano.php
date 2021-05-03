<?php

class Ciudadano{
    private $ciudad;
    private $email;
    private $clave;

    public function __construct($ciudad, $email, $clave)
    {
        $this->ciudad = $ciudad;
        $this->email = $email;
        $this->clave = $clave;
    }

    /* Método de instancia ToJSON(), que retornará los datos de la instancia (en una
    cadena con formato JSON). */
    public function ToJSON(){
        $retornoJson = $this->ciudad . " - " . $this->email . " - " . $this->clave;
        return json_encode($retornoJson);
    }

    /* Método de instancia GuardarEnArchivo(), que agregará al ciudadano en ./archivos/ciudadano.json. Retornará un
    JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */
    public function GuardarEnArchivo()
    {
        $path = "./archivos/ciudadanos.json";
        $retornoJson = new stdClass();
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No se pudo guardar en el archivo.";
        if (file_exists($path)) {
            $archivo = fopen($path, "a");
            if ($archivo) {
                fwrite($archivo, $this->ToJSON() . "\r\n");
                $retornoJson->exito = true;
                $retornoJson->mensaje = "Ciudadano guardado con exito.";
            }
            fclose($archivo);
        }
        return json_encode($retornoJson);
    }

    /* Método de clase TraerTodos(), que retornará un array de objetos de tipo Ciudadano. */
    public static function TraerTodosJson()
    {
        $arrayCiudadanos = array();
        $path = "./archivos/ciudadanos.json";
        if (file_exists($path)) {
            $archivo = fopen($path, "r");
            if ($archivo) {
                while (!feof($archivo)) {
                    $lineaLeida = trim(fgets($archivo));
                    if ($lineaLeida > 0) {
                        $cudadanoJson = json_decode($lineaLeida);
                        $ciudadanoAux = new Ciudadano($cudadanoJson->ciudad, $cudadanoJson->email, $cudadanoJson->clave);
                        array_push($arrayCiudadanos, $ciudadanoAux);
                    }
                }
            }
            fclose($archivo);
        }
        return $arrayCiudadanos;
    }

    /* Método de clase VerificarExistencia($ciudadano), que recorrerá el array (invocar a TraerTodos) y retornará un
    JSON que contendrá: existe(bool) y mensaje(string). */
    /* Si el ciudadano está registrado (email y clave), retornará true y el mensaje indicará cuantos cuidadanos están
    registrados con la misma ciudad del ciudadano recibido por parámetro. Caso contrario, retornará false, y el/los
    nombres de la/las ciudades más populares (mayor cantidad de apariciones). */
    public static function VerificarExistencia($ciudadano)
    {
        $retornoJson = new stdClass();
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No existe registro con los datos suministrados.";
        $arrayCiudadanos = Ciudadano::TraerTodosJson();
        foreach($arrayCiudadanos as $ciudadanoAux){
            if($ciudadano->email == $ciudadanoAux->email && $ciudadano->clave == $ciudadanoAux->clave){
                $retornoJson->exito = true;
                $retornoJson->mensaje = "El ciudadano existe.";
            }
        }
        return json_encode($retornoJson);
    }
}


?>