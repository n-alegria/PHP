<?php
// Crear, en ./clases, la interface IParte3. Esta interface poseerá los métodos:
//  Eliminar: elimina de la base de datos el registro coincidente con la instancia actual (comparar por nombre
// y tipo). Retorna true, si se pudo eliminar, false, caso contrario.
//  GuardarEnArchivo: escribirá en un archivo de texto (recetas_borradas.txt) toda la información de la
// receta más la nueva ubicación de la foto. La foto se moverá al subdirectorio “./recetasBorradas/”, con el
// nombre formado por el id punto nombre punto 'borrado' punto hora, minutos y segundos del borrado
// (Ejemplo: 123.paella.borrado.105905.jpg).
interface IParte3{
    public function Eliminar();
    public function GuardarEnArchivo();
}