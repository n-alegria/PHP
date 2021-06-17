<?php
// FiltrarReceta.php: Se recibe por POST el tipo, se mostrarán en una tabla (HTML) las recetas cuyo tipo coincidan
// con el pasado por parámetro.
// Si se recibe por POST el nombre, se mostrarán en una tabla (HTML) las recetas cuyo nombre coincida con el
// pasado por parámetro.
// Si se recibe por POST el nombre y el tipo, se mostrarán en una tabla (HTML) las recetas cuyo nombre y tipo
// coincidan con los pasados por parámetro.

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;

require_once './clases/AccesoDatos.php';
require_once './clases/Receta.php';

$receta = new Receta();
$listado = $receta->Traer();
$listadoFiltrado = array();

if($tipo != null && $nombre == null){
    foreach ($listado as $recetaAux) {
        if($recetaAux->tipo == $tipo)
        {
            array_push($listadoFiltrado, $recetaAux);
        }
    }
}
else if($tipo == null && $nombre != null){
    foreach ($listado as $recetaAux) {
        if($recetaAux->nombre == $nombre)
        {
            array_push($listadoFiltrado, $recetaAux);
        }
    }
}
else if($nombre != null && $tipo != null){
    foreach ($listado as $recetaAux) {
        if($recetaAux->nombre == $nombre && $recetaAux->tipo == $tipo)
        {
            array_push($listadoFiltrado, $recetaAux);
        }
    }
}

echo "<div>
    <table border=1>
        <thead>
            <tr>
                <td>Id</td>
                <td>Nombre</td>
                <td>Ingredientes</td> 
                <td>Tipo</td>
                <td>Imagen</td>
            </tr>
        </thead>";    
    foreach($listadoFiltrado as $receta)
    {
        echo "<tr>";
            echo "<td>" . $receta->id . "</td>";
            echo "<td>" . $receta->nombre . "</td>";
            echo "<td>" . $receta->ingredientes . "</td>";
            echo "<td>" . $receta->tipo . "</td>";
            echo "<td>";
            if($receta->pathFoto != "")
            {
                if(file_exists("./recetas/imagenes/".$receta->pathFoto)) {
                    echo '<img src="./recetas/imagenes/'.$receta->pathFoto.'" alt=./recetas/imagenes/"'.$receta->pathFoto.'" height="100px" width="100px">'; 
                }else{
                echo 'no hay imagen guardada '. $receta->pathFoto; 
                }
            }else{
                echo "Sin datos //";
            }
            echo "</td>";
        echo "</tr>";
    }
echo "</table>
</div>";