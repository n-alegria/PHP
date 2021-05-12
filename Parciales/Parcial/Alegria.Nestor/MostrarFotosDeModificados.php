<?php

/* MostrarFotosDeModificados.php: 
Muestra (en una tabla HTML) todas las imagenes (50px X 50px) de los
productos envasados registrados en el directorio “./productosModificados/”. 
Para ello, agregar un método estático (en ProductoEnvasado), llamado MostrarModificados. */

require_once('./clases/ProductoEnvasado.php');

$listado = ProductoEnvasado::MostrarModificados();
if($listado !== null && count($listado) !== 0){
    // var_dump($listado);
    echo "<table style='border:2px solid black;border-collapse:collapse;'>
    <tr>
        <th style='border:1px solid black;padding:20px;'>Foto</th>
        <th style='border:1px solid black;padding:20px;'>Path</th>
    </tr>";
    foreach($listado as $path){
        echo 
        "<tr>
            <td style='border:1px solid black;padding:20px;'><img width=50 height=50 src='productosModificados/$path' /></td>
            <td style='border:1px solid black;padding:20px;'>$path</td>
        </tr>";
    }
    echo "</table>";
}


?>