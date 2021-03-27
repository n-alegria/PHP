<?php
require_once "BACKEND/fabrica.php";

$fabrica = new Fabrica("TypeScript");

$empleado1 = new Empleado("Juan", "Zar", 223344 , "masculino", 10000, 50000, "mañana");
$empleado2 = new Empleado("Selene", "Flores", 223345 , "femenino", 10001, 55000, "tarde");
$empleado3 = new Empleado("Federico", "Rosa", 223346 , "masculino", 10002, 60000, "mañana");
$empleado4 = new Empleado("Veronica", "Busto", 223347 , "femenino", 10003, 40000, "tarde");
$empleado5 = new Empleado("Diego", "Collazo", 223348 , "masculino", 10004, 70000, "mañana");
$empleado6 = new Empleado("Zahira", "Barriento", 223349 , "femenino", 10005, 30000, "tarde");
$empleadoRepetido = new Empleado("Juan", "Zar", 223344 , "masculino", 10000, 50000, "mañana");

echo "--> Agrego empleados.<br/><br/>";
$fabrica->AgregarEmpleado($empleado1);
$fabrica->AgregarEmpleado($empleado2);
$fabrica->AgregarEmpleado($empleado3);
$fabrica->AgregarEmpleado($empleado4);
$fabrica->AgregarEmpleado($empleadoRepetido);
$fabrica->AgregarEmpleado($empleado5);
$fabrica->AgregarEmpleado($empleado6);

echo "--> Muestro los empleados.<br/><br/>";
echo $fabrica->ToString();

echo "--> Elimino empleados.<br/><br/>";
$fabrica->EliminarEmpleado($empleado1);
$fabrica->EliminarEmpleado($empleado3);


echo "--> Muestro los empleados<br/><br/>";
echo $fabrica->ToString();

?>