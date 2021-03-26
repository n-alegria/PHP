<?php
require_once "persona.php";

class Empleado extends Persona{
    # Atributos
    protected $legajo;
    protected $sueldo;
    protected $turno;

    # Constructor
    public function __construct($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno){
        parent::__construct($nombre, $apellido, $dni, $sexo);
        $this->legajo = $legajo;
        $this->sueldo = $sueldo;
        $this->turno = $turno;
    }

    # Propiedades
    public function GetLegajo(){
        return $this->legajo;
    }

    public function GetSueldo(){
        return $this->sueldo;
    }

    public function GetTurno(){
        return $this->turno;
    }

    # Metodos
    public function Hablar($idiomas)
    {
        $idiomasCapitalizados = [];
        foreach($idiomas as $idioma){
            array_push($idiomasCapitalizados, ucfirst($idioma));
        }
        $idiomasCapitalizados = implode(", ", $idiomasCapitalizados);
        return "El empleado habla " . $idiomasCapitalizados;
    }

    public function ToString()
    {
        return parent::ToString()." - $this->legajo - $this->sueldo - " . ucfirst($this->turno);
    }
}


?>