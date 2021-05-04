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
    productos están registrados con el mismo origen del producto recibido por parámetro. Caso contrario, retornará
    false, y el/los nombres de la/las productos más populares (mayor cantidad de apariciones). */
    public static function VerificarProductoJSON($producto)
    {
        $retornoJson = new stdClass();
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No se pudo guardar en el archivo";

        $arrayProductos = Producto::TraerJson();

        foreach($arrayProductos as $item)
        {
            if($item->nombre == $producto->nombre && $item->origen == $producto->origen)
            {
                $retornoJson->exito = true;
                break;
            }
        }

        $cantidadOrigen = 0;
        if($arrayProductos !== null && $arrayProductos !== 0){
            if($retornoJson->exito = true){
                foreach($arrayProductos as $item)
                {
                    if($item->origen == $producto->origen)
                    {
                        $retornoJson->exito = true;
                        $cantidadOrigen ++;
                    }
                }
                $retornoJson->mensaje = "El producto '" . $producto->nombre . "' se encuentra '" . $cantidadOrigen . "' veces en el listado.";
            }
        }
        else{
            $retornoJson->mensaje = "EL listado se encuentra vacio.";
        }

        return json_encode($retornoJson);
    }

    // public function Agregar(){
    //     $retorno = false;
        
    //     try{
    //         $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
    //         $cursor = $pdo->prepare("INSERT INTO usuarios (nombre, correo, clave, id_perfil) VALUES (:nombre, :correo, :clave, :id_perfil)");
    //         $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
    //         $cursor->bindParam(":correo", $this->correo, PDO::PARAM_STR);
    //         $cursor->bindParam(":clave", $this->clave, PDO::PARAM_STR);
    //         $cursor->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
    //         $cursor->execute();
    //         if($cursor->rowCount() > 0){
    //             $retorno = true;
    //         }
    //     }
    //     catch(PDOException $e){
    //         echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
    //     }
    //     return $retorno;
    // }

    // public static function TraerTodos(){
    //     $arrayUsuarios = array();
        
    //     try{
    //         $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
    //         $cursor = $pdo->prepare("SELECT usuarios.id, correo, clave, nombre, id_perfil, descripcion FROM usuarios 
    //                                 INNER JOIN perfiles 
    //                                 ON perfiles.id = usuarios.id_perfil");
    //         $cursor->execute();
    //         while($registro = $cursor->fetch(PDO::FETCH_OBJ)){
    //             $usuarioAux = new Usuario($registro->id, $registro->nombre, $registro->correo, $registro->clave, $registro->id_perfil, $registro->descripcion);
    //             array_push($arrayUsuarios, $usuarioAux);
    //         }
    //     }
    //     catch(PDOException $e){
    //         echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
    //     }
    //     return $arrayUsuarios;
    // }

    // public static function TraerUno($params){
    //     try{
    //         $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
    //         $cursor = $pdo->prepare("SELECT usuarios.id, correo, clave, nombre, id_perfil, descripcion FROM usuarios 
    //                                 INNER JOIN perfiles 
    //                                 ON usuarios.id_perfil = perfiles.id
    //                                 WHERE correo = :correo AND clave = :clave");
    //         $datosJson = json_decode($params);
    //         $cursor->bindParam(":correo", $datosJson->correo, PDO::PARAM_STR);
    //         $cursor->bindParam(":clave", $datosJson->clave, PDO::PARAM_STR);
    //         $cursor->execute();
    //         if($cursor->rowCount() > 0){
    //             $registro = $cursor->fetch(PDO::FETCH_ASSOC);
    //             $usuarioAux = new Usuario($registro["id"], $registro["nombre"], $registro["correo"], $registro["clave"], $registro["id_perfil"], $registro["descripcion"]);
    //         }
    //         else{
    //             $usuarioAux = null;
    //         }
    //     }
    //     catch(PDOException $e){
    //         echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
    //     }
    //     return $usuarioAux;
    // }

    // public function Modificar()
    // {
    //     $retorno = false;
    //     try{
    //         $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
    //         $cursor = $pdo->prepare("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil
    //                                 WHERE usuarios.id = :id");
    //         $cursor->bindParam(":id", $this->id, PDO::PARAM_INT);
    //         $cursor->bindParam(":correo", $this->correo, PDO::PARAM_STR);
    //         $cursor->bindParam(":clave", $this->clave, PDO::PARAM_STR);
    //         $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
    //         $cursor->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
    //         $cursor->execute();
    //         if($cursor->rowCount() > 0){
    //             $retorno = true;
    //         }
    //     }
    //     catch(PDOException $e){
    //         echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
    //     }
    //     return $retorno;
    // }

    // public static function Eliminar($id)
    // {
    //     $retorno = false;
    //     try{
    //         $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
    //         $cursor = $pdo->prepare("DELETE FROM usuarios
    //                                 WHERE usuarios.id = :id");
    //         $cursor->bindParam(":id", $id, PDO::PARAM_INT);
    //         $cursor->execute();
    //         if($cursor->rowCount() > 0){
    //             $retorno = true;
    //         }
    //     }
    //     catch(PDOException $e){
    //         echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
    //     }

    //     return $retorno;
    // }
}