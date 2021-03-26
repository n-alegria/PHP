<?php
require_once "BACKEND/empleado.php";

$idiomas = array("ingles", "frances", "catalan", "Ruso");

$empleado = new Empleado("lautaro", "alegria", 2323, "masculino", 107211, 150000, "tarde");
echo $empleado->ToString();
echo "<br/>";
echo $empleado->Hablar($idiomas);
?>