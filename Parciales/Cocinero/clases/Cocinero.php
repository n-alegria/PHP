<?php
class Cocinero
{
    private $especialidad;
    private $email;
    private $clave;

    public function __construct($especialidad = null, $email = null, $clave = null)
    {
        $this->especialidad = $especialidad != null ? $especialidad : "";
        $this->email = $email != null ? $email : "";
        $this->clave = $clave != null ? $clave : "";
    }

    public function ToJSON()
    {
        $retornoJson = new stdClass();
        $retornoJson->especialidad = $this->especialidad;
        $retornoJson->email = $this->email;
        $retornoJson->clave = $this->clave;
        return json_encode($retornoJson);
    }

    // Método de instancia GuardarEnArchivo(), que agregará al cocinero en ./archivos/cocinero.json. Retornará un
    // JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
    public function GuardarEnArchivo()
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Error al guardar en archivo";
        $path = './archivos/cocinero.json';
        if(file_exists($path)){
            $archivo = fopen($path, 'a');
            if($archivo){
                fwrite($archivo, $this->ToJSON() . "\r\n");
                $retorno->exito = true;
                $retorno->mensaje = "Cocinero guardado con exito";
            }
            fclose(($archivo));
        }
        return json_encode($retorno);
    }

    // Método de clase TraerTodos(), que retornará un array de objetos de tipo Cocinero.
    public static function TraerTodos()
    {   
        $listado = array();
        $path = './archivos/cocinero.json';
        if(file_exists($path)){
            $archivo = fopen($path, 'r');
            if($archivo){
                while(!feof($archivo)){
                    $linea = trim(fgets($archivo));
                    if($linea){
                        $json = json_decode($linea);
                        $cocinero = new Cocinero($json->especialidad, $json->email, $json->clave);
                        array_push($listado, $cocinero);
                    }
                }
            }
            fclose($archivo);
        }
        return $listado;
    }

    // Método de clase VerificarExistencia($cocinero), que recorrerá el array (invocar a TraerTodos) y retornará un JSON
// que contendrá: existe(bool) y mensaje(string).
// Si el cocinero está registrado (email y clave), retornará true y el mensaje indicará cuantos cocineros están
// registrados con la misma especialidad del cocinero recibido por parámetro. Caso contrario, retornará false, y
// el/los nombres de la/las especialidades más populares (mayor cantidad de apariciones).

    public static function VerificarExistencia($cocinero)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "No existe el cocinero";
        $listado = Cocinero::TraerTodos();
        foreach ($listado as $auxiliar) {
            if($auxiliar->email == $cocinero->email && $auxiliar->clave == $cocinero->clave){
                $retorno->exito = true;
                $retorno->mensaje = "Existe el cocinero";
                $retorno->especialidad = $auxiliar->especialidad;
            }
        }
        return json_encode($retorno);
    }
}