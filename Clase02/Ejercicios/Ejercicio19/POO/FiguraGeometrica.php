<?php

abstract Class FiguraGeometrica{
    # Atributos
    protected $_color;
    protected $_perimetro;
    protected $_superficie;


    # Constructor
    public function __construct(){
        $this->_color = "#4F054F";
        $this->_perimetro = 0;
        $this->_superficie = 0;
    }

    # Propiedades
    public function GetColor(){
        return $this->_color;
    }

    public function SetColor($_color){
        $this->_color = $_color;
    }

    # Metodos
    public function ToString()
    {
        return "Color: " . $this->GetColor() . "<br/>Perimetro: " . $this->_perimetro . "<br/>Superficie: " . $this->_superficie; 
    }

    public abstract function Dibujar();

    protected abstract function CalcularDatos();

}