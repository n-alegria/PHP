<?php
// Crear, en ./clases, la interface IParte1. Esta interface poseerá los métodos:
//  Agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla recetas (id, nombre,
// ingredientes, tipo, foto), de la base de datos recetas_bd. Retorna true, si se pudo agregar, false, caso
// contrario.
//  Traer: retorna un array de objetos de tipo Receta, recuperados de la base de datos.

interface IParte1
{
    public function Agregar();
    public function Traer();
}