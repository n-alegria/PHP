<?php
require_once('IBM.php');

class Usuario implements IBM
{
    public $id;
    public $nombre;
    public $correo;
    public $clave;
    public $id_perfil;
    public $perfil;

    public function __construct($id = null, $nombre = null, $correo = null, $clave = null, $id_perfil = null, $perfil = null)
    {
        $this->id = $id != null ? $id : "";
        $this->nombre = $nombre != null ? $nombre : "";
        $this->correo = $correo != null ? $correo : "";
        $this->clave = $clave != null ? $clave : "";
        $this->id_perfil = $id_perfil != null ? $id_perfil : "";
        $this->perfil = $perfil != null ? $perfil : "";
    }

    public function ToJSON()
    {
        $retornoJson = new stdClass();
        $retornoJson->nombre = $this->nombre;
        $retornoJson->correo = $this->correo;
        $retornoJson->clave = $this->clave;

        return json_encode($retornoJson);
    }

    public function GuardarEnArchivo()
    {
        $retornoJson = new stdClass();
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No se pudo guardar en el archivo";
        if (file_exists("./archivos/usuarios.json")) {
            $archivo = fopen("./archivos/usuarios.json", "a");
            if ($archivo) {
                fwrite($archivo, $this->ToJSON() . "\r\n");
                $retornoJson->exito = true;
                $retornoJson->mensaje = "Usuario guardado con exito.";
            }
            fclose($archivo);
        }
        return json_encode($retornoJson);
    }

    public static function TraerTodosJson()
    {
        $arrayUsuarios = array();
        if (file_exists("./archivos/usuarios.json")) {
            $archivo = fopen("./archivos/usuarios.json", "r");
            if ($archivo) {
                while (!feof($archivo)) {
                    $lineaLeida = trim(fgets($archivo));
                    if ($lineaLeida > 0) {
                        $usuarioJson = json_decode($lineaLeida);
                        $usuarioAux = new Usuario(null, $usuarioJson->nombre, $usuarioJson->correo, $usuarioJson->clave,null, null);
                        array_push($arrayUsuarios, $usuarioAux);
                    }
                }
            }
            fclose($archivo);
        }
        return $arrayUsuarios;
    }

    public function Agregar(){
        $retorno = false;
        
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
            $cursor = $pdo->prepare("INSERT INTO usuarios (nombre, correo, clave, id_perfil) VALUES (:nombre, :correo, :clave, :id_perfil)");
            $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $cursor->bindParam(":correo", $this->correo, PDO::PARAM_STR);
            $cursor->bindParam(":clave", $this->clave, PDO::PARAM_STR);
            $cursor->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
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

    public static function TraerTodos(){
        $arrayUsuarios = array();
        
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
            $cursor = $pdo->prepare("SELECT usuarios.id, correo, clave, nombre, id_perfil, descripcion FROM usuarios 
                                    INNER JOIN perfiles 
                                    ON perfiles.id = usuarios.id_perfil");
            $cursor->execute();
            while($registro = $cursor->fetch(PDO::FETCH_OBJ)){
                $usuarioAux = new Usuario($registro->id, $registro->nombre, $registro->correo, $registro->clave, $registro->id_perfil, $registro->descripcion);
                array_push($arrayUsuarios, $usuarioAux);
            }
        }
        catch(PDOException $e){
            echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
        }
        return $arrayUsuarios;
    }

    public static function TraerUno($correo, $clave){
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
            $cursor = $pdo->prepare("SELECT usuarios.id, correo, clave, nombre, id_perfil, descripcion FROM usuarios 
                                    INNER JOIN perfiles 
                                    ON usuarios.id_perfil = perfiles.id
                                    WHERE correo = :correo AND clave = :clave");
            $cursor->bindParam(":correo", $correo, PDO::PARAM_STR);
            $cursor->bindParam(":clave", $clave, PDO::PARAM_STR);
            $cursor->execute();
            if($cursor->rowCount() > 0){
                $registro = $cursor->fetch(PDO::FETCH_ASSOC);
                $usuarioAux = new Usuario($registro["id"], $registro["nombre"], $registro["correo"], $registro["clave"], $registro["id_perfil"], $registro["descripcion"]);
            }
            else{
                $usuarioAux = null;
            }
        }
        catch(PDOException $e){
            echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
        }
        return $usuarioAux;
    }

    public function Modificar()
    {
        $retorno = false;
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
            $cursor = $pdo->prepare("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil
                                    WHERE usuarios.id = :id");
            $cursor->bindParam(":id", $this->id, PDO::PARAM_INT);
            $cursor->bindParam(":correo", $this->correo, PDO::PARAM_STR);
            $cursor->bindParam(":clave", $this->clave, PDO::PARAM_STR);
            $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $cursor->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
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

    public static function Eliminar($id)
    {
        $retorno = false;
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
            $cursor = $pdo->prepare("DELETE FROM usuarios
                                    WHERE usuarios.id = :id");
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
}
