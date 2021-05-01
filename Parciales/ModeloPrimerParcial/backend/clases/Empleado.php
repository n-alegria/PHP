<?php

require_once('./clases/Usuario.php');
require_once('./clases/ICRUD.php');

class Empleado extends Usuario implements ICRUD{
    public $foto;
    public $sueldo;

    public function __construct($id = null, $nombre = null, $correo = null, $clave = null, $id_perfil = null, $perfil = null, $foto = null, $sueldo = null){
        parent::__construct($id, $nombre, $correo, $clave, $id_perfil, $perfil);
        $this->foto = $foto != null ? $foto : "";;
        $this->sueldo = $sueldo != null ? $sueldo : "";;
    }

    public static function TraerTodos(){
        $arrayEmpleados = array();
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
            $cursor = $pdo->prepare("SELECT empleados.id, correo, clave, nombre, id_perfil, descripcion, foto, sueldo FROM empleados 
                                    INNER JOIN perfiles 
                                    ON empleados.id_perfil = perfiles.id");
            $cursor->execute();
            while($registro = $cursor->fetch(PDO::FETCH_OBJ)){
                $empleadoAux = new Empleado($registro->id, $registro->nombre, $registro->correo, $registro->clave, $registro->id_perfil, $registro->descripcion, $registro->foto, $registro->sueldo);
                array_push($arrayEmpleados, $empleadoAux);
            }
        }
        catch(PDOException $e){
            echo "Ocurrio un error: " . $e->getMessage() . "<br/>";
        }
        return $arrayEmpleados;
    }

    public function Agregar(){
        $retorno = false;
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
            $cursor = $pdo->prepare("INSERT INTO empleados (nombre, correo, clave, id_perfil, foto, sueldo) 
                                    VALUES (:nombre, :correo, :clave, :id_perfil, :foto, :sueldo)");
            $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $cursor->bindParam(":correo", $this->correo, PDO::PARAM_STR);
            $cursor->bindParam(":clave", $this->clave, PDO::PARAM_STR);
            $cursor->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $cursor->bindParam(":foto", $this->foto, PDO::PARAM_STR);
            $cursor->bindParam(":sueldo", $this->sueldo, PDO::PARAM_INT);
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
            $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', "root", "");
            $cursor = $pdo->prepare("UPDATE empleados SET nombre = :nombre, correo = :correo, clave = :clave, id_perfil = :id_perfil, foto = :foto, sueldo = :sueldo 
                                    WHERE empleados.id = :id");
            $cursor->bindParam(":id", $this->id, PDO::PARAM_INT);             
            $cursor->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $cursor->bindParam(":correo", $this->correo, PDO::PARAM_STR);
            $cursor->bindParam(":clave", $this->clave, PDO::PARAM_STR);
            $cursor->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $cursor->bindParam(":foto", $this->foto, PDO::PARAM_STR);
            $cursor->bindParam(":sueldo", $this->sueldo, PDO::PARAM_INT);
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
            $cursor = $pdo->prepare("DELETE FROM empleados WHERE empleados.id = :id");
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
?>