<?php

require_once('IParte1.php');
require_once('AccesoDatos.php');

class Juguete implements IPArte1{
    private $tipo;
    private $precio;
    private $paisOrigen;
    private $pathImagen;

    public function __construct($tipo, $precio, $paisOrigen, $pathImagen = null){
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->paisOrigen = $paisOrigen;
        $this->pathImagen = $pathImagen != null ? $pathImagen : "";
    }

    public function GetTipo(){
        return $this->tipo;
    }

    public function GetPrecio(){
        return $this->precio;
    }
    public function GetPais(){
        return $this->paisOrigen;
    }
    public function GetPathImagen(){
        return $this->pathImagen;
    }


    # Método de instancia ToString(), que retorna los datos de la instancia (separado por un guión medio).
    public function ToString(){
        $cadena = $this->tipo . " - " . $this->precio . " - " . $this->paisOrigen;
        if($this->pathImagen){
            $cadena  .= " - " . $this->pathImagen;
        }
        return $cadena;
    }

    # Agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla juguetes 
    # (id, tipo, precio, pais, foto), de la base de datos juguetes_bd. Retorna true, si se pudo agregar, false, caso contrario.
    public function Agregar()
    {
        $retorno = false; 
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $cursor = $pdo->RetornarConsulta("INSERT INTO juguetes (tipo, precio, pais, foto) 
                                            VALUES (:tipo, :precio, :pais, :foto)");
            $cursor->bindParam(":tipo", $this->tipo, PDO::PARAM_STR);
            $cursor->bindParam(":precio", $this->precio, PDO::PARAM_INT);
            $cursor->bindParam(":pais", $this->paisOrigen, PDO::PARAM_STR);
            $cursor->bindParam(":foto", $this->pathImagen, PDO::PARAM_STR);
            $cursor->execute();
            if($cursor->rowCount() > 0){
                $retorno = true;
            }
        }
        catch(PDOException $e){
            echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
        }
        return $retorno;
    }

    # Traer: retorna un array de objetos de tipo Juguete, recuperados de la base de datos.
    public static function Traer(){
        $arrayJuguetes = array();
        
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $cursor = $pdo->RetornarConsulta("SELECT * FROM juguetes");
            $cursor->execute();
            while($registro = $cursor->fetch(PDO::FETCH_OBJ)){
                $jugueteAux = new Juguete($registro->tipo, $registro->precio, $registro->pais, $registro->foto);
                array_push($arrayJuguetes, $jugueteAux);
            }
        }
        catch(PDOException $e){
            echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
        }
        return $arrayJuguetes;
    }


    # CalcularIVA: retorna el precio del juguete más el 21%.
    public function CalcularIVA(){
        return $this->precio * 1.21;
    }

    # Verificar: retorna true, si la instancia actual no existe en el array de objetos de tipo Juguete
    # que recibe como parámetro. Caso contrario retorna false.
    public function Verificar($arrayJuguetes){
        $retorno = true;
        foreach ($arrayJuguetes as $juguete) {
            if($this->ToString() == $juguete->ToString()){
                $retorno = false;
                break;
            }
        }
        return $retorno;
    }

    public static function MostrarLog(){
        $arrayDatos = array();
        $path = "./archivos/juguetes_sin_foto.txt";
        if(file_exists($path)){
            $archivo = fopen($path, "r");
            if($archivo){
                while(!feof($archivo)){
                    $linea = trim(fgets($archivo));
                    if($linea > 0){
                        array_push($arrayDatos, $linea);
                    }
                }
            }
            fclose($archivo);
        }
        return $arrayDatos;
    }
}

?>