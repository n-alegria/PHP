<?php

require_once "FiguraGeometrica.php";

class Rectangulo extends FiguraGeometrica{
    # Atributos
    private $_ladoUno;
    private $_ladoDos;

    # Constructor
    public function __construct($double1, $double2){
        parent::__construct();
        $this->_ladoUno = $double1;
        $this->_ladoDos = $double2;
    }

    # Metodos
    public function Dibujar(){
        $dibu ='<div style="color :'.$this->GetColor().'">';
        $dibu ='<div style="color : violet">';
        for($i=0; $i<$this->_ladoUno; $i++)
        {
            for($j=0; $j<$this->_ladoDos; $j++)
            {
                $dibu .= "*";
            }
            $dibu .= "<br>";
        }
        echo $dibu ."</div>";
    }

    protected function CalcularDatos(){
        $this->_perimetro = ($this->_ladoUno * 2) + ($this->_ladoDos * 2);
        $this->_superficie = ($this->_ladoUno * $this->_ladoDos);
    }

    public function ToString()
    {
        return parent::ToString(). "<br>Lado Uno:". $this->_ladoUno. "<br>Lado Dos: ". $this->_ladoDos;
    }  
}