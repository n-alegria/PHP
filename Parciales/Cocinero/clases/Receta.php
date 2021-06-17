<?php
// Receta.php. Crear, en ./clases, la clase Receta con atributos públicos (id, nombre, ingredientes, tipo y pathFoto),
// constructor (con todos sus parámetros opcionales), un método de instancia ToJSON(), que retornará los datos de
// la instancia (en una cadena con formato JSON).

require_once './clases/IParte1.php';
require_once './clases/IParte2.php';
require_once './clases/IParte3.php';
require_once './clases/AccesoDatos.php';
class Receta implements IParte1, IParte2, IParte3
{
    //atributos publicos
    public $id;
    public $nombre;
    public $ingredientes;
    public $tipo;
    public $pathFoto;

    //constructor con todos sus paramtreos opcionales
    public function __construct($id = null, $nombre = null, $ingredientes = null, $tipo = null, $pathFoto = null)
    {
        $this->id = $id != null ? $id : null;
        $this->nombre = $nombre != null ? $nombre : null;
        $this->ingredientes = $ingredientes != null ? $ingredientes : null;
        $this->tipo = $tipo != null ? $tipo : null;
        $this->pathFoto = $pathFoto != null ? $pathFoto : null;
    }

    //método de instancia ToJSON(), que retornará los datos de la instancia (en una cadena con formato JSON).
    public function ToJson()
    {
        $auxJson = new stdClass();
        $auxJson->id = $this->id;
        $auxJson->nombre = $this->nombre;
        $auxJson->ingredientes = $this->ingredientes;
        $auxJson->tipo = $this->tipo;
        $auxJson->pathFoto = $this->pathFoto;
        
        return json_encode($auxJson);
    }

    public function Agregar()
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO recetas (nombre, ingredientes, tipo, path_foto)"
                                                    . "VALUES(:nombre, :ingredientes, :tipo, :path_foto)"); 
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':ingredientes', $this->ingredientes, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':path_foto', $this->pathFoto, PDO::PARAM_STR);
        $consulta->execute();

        if (($consulta->rowCount())>0) {
            $retorno = true;
        }

        return $retorno;        
    }

    public function Traer()
    {
        $array = array();
        $objetoAccesoDato =AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM recetas");
        $consulta->execute();

        while($fila = $consulta->fetch())
        {
          $receta= new Receta($fila[0], $fila[1], $fila[2], $fila[3], $fila[4]);
          array_push($array, $receta);
        }
        return $array;
    }

    //  Existe: retorna true, si la instancia actual está en el array de objetos de tipo Receta que recibe como
    // parámetro (comparar por nombre y tipo). Caso contrario retorna false.
    public function Existe($listado){
        $retorno = false;
        foreach ($listado as $aux) {
            if($aux->nombre == $this->nombre && $aux->tipo == $this->tipo){
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    //  Modificar: Modifica en la base de datos el registro coincidente con la instancia actual (comparar por id).
    // Retorna true, si se pudo modificar, false, caso contrario.
    public function Modificar(){
        $retorno = false;
        $objetoAccesoDato =AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE recetas SET nombre=:nombre, ingredientes=:ingredientes, 
                        tipo=:tipo, path_foto=:pathFoto WHERE id=:id");
                                                     
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':ingredientes', $this->ingredientes, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
        if($consulta->rowCount()){
            $retorno = true;
        }
        return $retorno;
    }
    //  Eliminar: elimina de la base de datos el registro coincidente con la instancia actual (comparar por nombre
    // y tipo). Retorna true, si se pudo eliminar, false, caso contrario.
    public function Eliminar(){
        $retorno = false;
        $objetoAccesoDato =AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM recetas WHERE nombre=:nombre AND tipo=:tipo");

        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->execute();
        if($consulta->rowCount()){
            $retorno = true;
        }
        return $retorno;
    }

    //  GuardarEnArchivo: escribirá en un archivo de texto (recetas_borradas.txt) toda la información de la
    // receta más la nueva ubicación de la foto. La foto se moverá al subdirectorio “./recetasBorradas/”, con el
    // nombre formado por el id punto nombre punto 'borrado' punto hora, minutos y segundos del borrado
    // (Ejemplo: 123.paella.borrado.105905.jpg).
    public function GuardarEnArchivo()
    {
        $retornoJson = new stdClass();
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No se pudo guardar en el archivo";

        $ar=fopen("./recetas_borradas.txt","a"); 

        if($ar != false) {
            if(fwrite($ar, $this->ToJson()."\r\n")) { 
                $ext = pathinfo($this->pathFoto, PATHINFO_EXTENSION); 
                $destino = $this->id.'.'.$this->nombre.'.borrado.'.date('Gis').$ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], "./recetas/imagenes/" . $this->pathFoto, $destino);               
            }
            fclose($ar); 
        }

        return $retornoJson;
    }
}