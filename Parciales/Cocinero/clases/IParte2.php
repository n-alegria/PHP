<?php
// Crear, en ./clases, la interface IParte2. Esta interface poseerá los métodos:
//  Existe: retorna true, si la instancia actual está en el array de objetos de tipo Receta que recibe como
// parámetro (comparar por nombre y tipo). Caso contrario retorna false.
//  Modificar: Modifica en la base de datos el registro coincidente con la instancia actual (comparar por id).
// Retorna true, si se pudo modificar, false, caso contrario.
interface IParte2
{
    public function Existe($listado);
    public function Modificar();
}