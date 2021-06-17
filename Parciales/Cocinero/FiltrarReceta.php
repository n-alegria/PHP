<?php
// FiltrarReceta.php: Se recibe por POST el tipo, se mostrarán en una tabla (HTML) las recetas cuyo tipo coincidan
// con el pasado por parámetro.
// Si se recibe por POST el nombre, se mostrarán en una tabla (HTML) las recetas cuyo nombre coincida con el
// pasado por parámetro.
// Si se recibe por POST el nombre y el tipo, se mostrarán en una tabla (HTML) las recetas cuyo nombre y tipo
// coincidan con los pasados por parámetro.

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;