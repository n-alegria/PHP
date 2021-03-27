<?php

require_once "empleado.php";

class Fabrica{
    # Atributos
    private $cantidadMaxima;
    private $empleados;
    private $razonSocial;

    # Constructor
    public function __construct($razonSocial, $cantidadMaxima = 5)
    {
        $this->cantidadMaxima = $cantidadMaxima;
        $this->empleados = array();
        $this->razonSocial = $razonSocial;
    }

    # Metodos
    public function AgregarEmpleado($emp){
        $retorno = false;
        if(count($this->empleados) < $this->cantidadMaxima){
            array_push($this->empleados, $emp);
            $this->EliminarEmpleadosRepetidos();
            $retorno = true;
        }
        return $retorno;
    }

    public function CalcularSueldos(){
        $totalSueldos = 0;
        foreach ($this->empleados as $empleado) {
            $totalSueldos += $empleado->GetSueldo();
        }
        return $totalSueldos;
    }

    public function EliminarEmpleado($emp){
        $retorno = false;
        foreach ($this->empleados as $index => $empleado) {
            if($emp == $empleado){
                unset($this->empleados[$index]);
                $retorno = true;
            }
        }
        return $retorno;
    }

    private function EliminarEmpleadosRepetidos(){
        $this->empleados = array_unique($this->empleados, SORT_REGULAR);
    }

    public function ToString(){
        $retorno = "Fabrica: $this->razonSocial<br/>";
        $retorno .= "Cantidad de empleados: " . count($this->empleados) . "<br/><br/>";
        $retorno .= "Lista de empleados:<br/>";
        foreach ($this->empleados as $index => $empleado) {
            $retorno .= $empleado->ToString();
        }
        $retorno .= "<br/>";
        return $retorno;
    }
}


?>