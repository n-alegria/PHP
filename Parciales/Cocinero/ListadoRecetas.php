<!-- // ListadoRecetas.php: (GET) Se mostrará el listado completo de las recetas (obtenidas de la base de datos) en una
// tabla (HTML con cabecera). Invocar al método Traer.
// Nota: preparar la tabla (HTML) con una columna extra para que muestre la imagen de la foto (si es que la tiene). -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado</title>
</head>
<body>
    
    <?php
    require_once "./clases/Receta.php";
    $receta = new Receta();
    $array = $receta->Traer();
    if($array!==null && count($array)!==0)
    {
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
        foreach($array as $receta)
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
    }
    ?>
   
</body>
</html>