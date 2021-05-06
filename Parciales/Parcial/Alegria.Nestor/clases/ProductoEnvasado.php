<?php # -> OK <-

/* ProductoEnvasado.php.
Crear, en ./clases, la clase ProductoEnvasado (hereda de producto) con atributos
públicos (id, codigoBarra, precio y pathFoto), constructor (con todos sus parámetros opcionales), un método de
instancia ToJSON(), que retornará los datos de la instancia (en una cadena con formato JSON). */

require_once('./clases/Producto.php');
require_once('./clases/IParte1.php');
require_once('./clases/IParte2.php');
require_once('./clases/IParte3.php');
require_once('./clases/AccesoDatos.php');

class ProductoEnvasado extends Producto implements IParte1, IParte2, IParte3{
    public $id;
    public $codigoBarra;
    public $precio;
    public $pathFoto;


    public function __construct($nombre = null, $origen = null, $id = null, $codigoBarra = null, $precio = null, $pathFoto = null)
    {
        parent::__construct($nombre, $origen);
        $this->id = $id;
        $this->codigoBarra = $codigoBarra;
        $this->precio = $precio;
        $this->pathFoto = $pathFoto;
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
                                            VALUES (:codigo_barra, :nombre, :origen, :precio, :foto)");
            $cursor->bindParam(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
            $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $cursor->bindParam(":origen", $this->origen, PDO::PARAM_STR);
            $cursor->bindParam(":precio", $this->precio, PDO::PARAM_INT);
            $cursor->bindParam(":foto", $this->pathFoto, PDO::PARAM_STR);
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
        $retorno = false;
        try{
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
        $retorno = false;
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $cursor = $pdo->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, codigo_barra = :codigo_barra, precio = :precio, foto = :foto WHERE id = :id");
            $cursor->bindParam(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
            $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $cursor->bindParam(":origen", $this->origen, PDO::PARAM_STR);
            $cursor->bindParam(":foto", $this->pathFoto, PDO::PARAM_STR);
            $cursor->bindParam(":precio", $this->precio, PDO::PARAM_INT);
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

    public function Existe($listado)
    {
        $retorno = false;
        foreach($listado as $item){
            if($item->nombre == $this->nombre && $item->origen == $this->origen){
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    /* GuardarEnArchivo: escribirá en un archivo de texto (./archivos/productos_envasados_borrados.txt) toda
    la información del producto envasado más la nueva ubicación de la foto. 
    La foto se moverá al subdirectorio “./productosBorrados/”, con el nombre formado por el id punto nombre punto 'borrado'
    punto hora, minutos y segundos del borrado (Ejemplo: 688.tomate.borrado.105905.jpg). */
    public function GuardarEnArchivo()
    {
        $retorno = false;
        $pathTxtBorrados = "./archivos/productos_envasados_borrados.txt";
        $pathDestino = "./productosBorrados/$this->id.$this->nombre.borrado." . date('His') . "." . pathinfo($this->pathFoto, PATHINFO_EXTENSION); 
        if (file_exists($pathTxtBorrados)) {
            $archivo = fopen($pathTxtBorrados, "a");
            if ($archivo) {
                if(fwrite($archivo, $this->ToJSON() . "\r\n")){
                    $retorno = true;
                    copy($this->pathFoto, $pathDestino);
                    unlink($this->pathFoto);
                }
            }
            fclose($archivo);
        }
        return $retorno;
    }

    public static function MostrarBorradosJSON()
    {
        $arrayProductos = array();
        $path = "./archivos/productos_eliminados.json";
        if (file_exists($path)) {
            $archivo = fopen($path, "r");
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

    public static function MostrarModificados(){
        $directorio = opendir('./productosModificados/');
        $pathsImagenes = array();
        while (($file = readdir($directorio))) {
            if($file !== '.' && $file !== ".."){
                array_push($pathsImagenes, $file);
            }
        }
        return $pathsImagenes;
    }
}