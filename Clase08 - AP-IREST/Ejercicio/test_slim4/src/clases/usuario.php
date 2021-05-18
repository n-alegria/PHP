<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once 'AccesoDatos.php';
require_once 'interface.php';

class Usuario implements IApi{
    # Atributos
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $foto;
    private $id_perfil;
    private $perfil;

    # Propiedades
    public function GetNombre(){
        return $this->nombre;
    }
    public function SetNombre($nombre){
        $this->nombre = $nombre;
    }

    public function GetApellido(){
        return $this->apellido;
    }
    public function SetApellido($apellido){
        $this->apellido = $apellido;
    }

    public function GetCorreo(){
        return $this->correo;
    }
    public function SetCorreo($correo){
        $this->correo = $correo;
    }

    public function GetClave(){
        return $this->clave;
    }
    public function SetClave($clave){
        $this->clave = $clave;
    }

    public function GetFoto(){
        return $this->foto;
    }
    public function SetFoto($foto){
        $this->foto = $foto;
    }

    public function GetIdPerfil(){
        return $this->id_perfil;
    }
    public function SetIdPerfil($id_perfil){
        $this->id_perfil = $id_perfil;
    }

    public function GetPerfil(){
        return $this->perfil;
    }
    public function SetPerfil($perfil){
        $this->perfil = $perfil;
    }

    # Constructor
    public function __construct($nombre = "", $apellido = "", $correo = "", $clave = "", $foto = "", $id_perfil = "", $perfil = ""){
        $this->SetNombre($nombre);
        $this->SetApellido($apellido);
        $this->SetCorreo($correo);
        $this->SetClave($clave);
        $this->SetFoto($foto);
        $this->SetIdPerfil($id_perfil);
        $this->SetPerfil($perfil);
    }

    # Funciones
    public function ToString(){
        return $this->GetNombre() . " - " . $this->GetApellido() . " - " . $this->GetCorreo() . " - " . $this->GetFoto() . " - " . $this->GetPerfil();
    }

    # Base de datos
    private static function TraerUnUsuario($correo, $clave)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "El usuario no existe";
        try{
            $pdo = AccesoDatos::DameUnObjetoAcceso();
            $cursor = $pdo->RetornarConsulta('SELECT * FROM usuarios INNER JOIN perfiles ON usuarios.id_perfil = perfiles.id WHERE usuarios.correo = :correo AND usuarios.clave = :clave');
            $cursor->bindParam(':correo', $correo, PDO::PARAM_STR);
            $cursor->bindParam(':clave', $clave, PDO::PARAM_STR);
            $cursor->execute();
            if($cursor->rowCount()){
                $retorno->exito = true;
                $retorno->mensaje = "El usuario esta ingresado en al base de datos";
            }
        }
        catch(PDOException $e){
            $retorno->mensaje = "Error en la conexion: " . $e->getMessage();
        }
        return json_encode($retorno);
    }

    # Interface
    public function TraerUno(Request $request, Response $response, array $args) : Response
    {
        $datos = $request->getParsedBody();
        $traerUn = Usuario::TraerUnUsuario($datos["correo"], $datos["clave"]);

        $newResponse = $response->withStatus(200, "OK");
		$newResponse->getBody()->write($traerUn);	

		return $newResponse->withHeader('Content-Type', 'application/json');
    }

}

?>