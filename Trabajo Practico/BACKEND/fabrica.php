<?php

class Fabrica{
    # Atributos
    private $cantidadMaxima;
    private $empleados;
    private $razonSocial;

    # Constructor
    public function __construct($razonSocial)
    {
        $this->cantidadMaxima = 5;
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
            echo "Se agrego el empleado a la lista<br/>";
        }
        else{
            echo "No hay lugar para ingresar un nuevo empleado<br/>";
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
        $retorno .= "Cantidad de empleados: " . count($this->empleados) . "<br/>";
        foreach ($this->empleados as $index => $empleado) {
            $retorno .= $empleado->ToString() . "<br/>";
        }

        return $retorno;
    }
}


?>