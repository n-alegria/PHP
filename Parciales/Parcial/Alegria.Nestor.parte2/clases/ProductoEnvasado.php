<?php

/* ProductoEnvasado.php.
Crear, en ./clases, la clase ProductoEnvasado (hereda de producto) con atributos
públicos (id, codigoBarra, precio y pathFoto), constructor (con todos sus parámetros opcionales), un método de
instancia ToJSON(), que retornará los datos de la instancia (en una cadena con formato JSON). */

require_once('./clases/Producto.php');
require_once('./clases/IParte1.php');
require_once('./clases/IParte2.php');
require_once('./clases/AccesoDatos.php');

class ProductoEnvasado extends Producto implements IParte1, IParte2, IParte3{
    public $id;
    public $codigoBarra;
    public $precio;
    public $pathFoto;


    public function __construct($nombre = null, $origen = null, $id = null, $codigoBarra = null, $precio = null, $pathFoto = null)
    {
        parent::__construct($nombre, $origen);
        $this->id = $id != null ? $id : "";
        $this->codigoBarra = $codigoBarra != null ? $codigoBarra : "";
        $this->precio = $precio != null ? $precio : "";
        $this->pathFoto = $pathFoto != null ? $pathFoto : "";
    }

    public function ToJSON()
    {
        $mensaje = json_decode(parent::ToJSON());
        $mensaje->id = $this->id;
        $mensaje->codigoBarra = $this->codigoBarra;
        $mensaje->precio = $this->precio;
        $mensaje->pathFoto = $this->pathFoto;

        return json_encode($mensaje);
    }

    public function Agregar()
    {
        $retorno = false; 
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $cursor = $pdo->RetornarConsulta("INSERT INTO productos (codigo_barra, nombre, origen, precio, foto) 
                                            :codigo_barra, :nombre, :origen, :precio, :foto)");
            $cursor->bindParam(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
            $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $cursor->bindParam(":origen", $this->origen, PDO::PARAM_STR);
            $cursor->bindParam(":foto", $this->pathFoto, PDO::PARAM_STR);
            $cursor->bindParam(":precio", $this->precio, PDO::PARAM_INT);
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

    public static function Traer(){
        $arrayProductos = array();
        
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $cursor = $pdo->RetornarConsulta("SELECT * FROM productos");
            $cursor->execute();
            while($registro = $cursor->fetch(PDO::FETCH_OBJ)){
                $productoAux = new ProductoEnvasado($registro->nombre, $registro->origen, $registro->id, $registro->codigo_barra, $registro->precio, $registro->foto);
                array_push($arrayProductos, $productoAux);
            }
        }
        catch(PDOException $e){
            echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
        }
        return $arrayProductos;
    }

    public static function Eliminar($id)
    {
        try{
            $retorno = false;
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $cursor = $pdo->RetornarConsulta("DELETE FROM productos WHERE id = :id");
            $cursor->bindParam(":id", $id, PDO::PARAM_INT);
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

    public function Modificar()
    {
        try{
            $retorno = false;
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $cursor = $pdo->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, codigo_barra = :codigo_barra, precio = :precio, foto = :foto WHERE id = :id");
            $cursor->bindParam(":codigo_barra", $this->codigoBarra, PDO::PARAM_STR);
            $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $cursor->bindParam(":origen", $this->origen, PDO::PARAM_STR);
            $cursor->bindParam(":foto", $this->pathFoto, PDO::PARAM_STR);
            $cursor->bindParam(":precio", $this->precio, PDO::PARAM_STR);
            $cursor->bindParam(":id", $this->id, PDO::PARAM_INT);
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

    public function Existe()
    {
        $retorno = false;
        $listado = ProductoEnvasado::Traer();
        foreach($listado as $item){
            if($item->nombre == $this->nombre && $item->origen == $this->origen){
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    public function GuardarEnArchivo()
    {
        $path = "./archivos/productos_envasados_borrados.txt";
        if (file_exists($path)) {
            $archivo = fopen($path, "a");
            if ($archivo) {
                $cadena = $this->ToJSON() . " - " . ".productosBorrados/" . $this->id . $this->nombre . "borrado" . date('His') . pathinfo($this->pathFoto, PATHINFO_EXTENSION);
                if(fwrite($archivo, $cadena . "\r\n")){
                    move_uploaded_file($this->pathFoto, ".productosBorrados/" . $this->id . $this->nombre . "borrado" . date('His') . pathinfo($this->pathFoto, PATHINFO_EXTENSION));
                }
            }
            fclose($archivo);
        }
    }
}