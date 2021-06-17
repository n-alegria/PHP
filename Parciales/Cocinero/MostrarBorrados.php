<?php
// MostrarBorrados.php: Muestra todo lo registrado en el archivo de texto “recetas_borradas.txt”. Para ello,
// agregar un método estático (en Receta), llamado MostrarBorrados.

require_once './clases/Receta.php';

foreach (Receta::MostrarBorrados() as $receta) {
    echo $receta->ToJson();
}
?>