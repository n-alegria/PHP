<?php

/* FiltrarProductos.php: 
Se recibe por POST el origen, se mostrarán en una tabla (HTML) los productos envasados
cuyo origen coincidan con el pasado por parámetro.
Si se recibe por POST el nombre, se mostrarán en una tabla (HTML) los productos envasados cuyo nombre
coincida con el pasado por parámetro.
Si se recibe por POST el nombre y el origen, se mostrarán en una tabla (HTML) los productos envasados cuyo
nombre y origen coincidan con los pasados por parámetro. */

$origen = isset($_POST["origen"]) ? $_POST["origen"] : null;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;

require_once('./clases/ProductoEnvasado.php');

$listado = ProductoEnvasado::Traer();

if($listado !== null && count($listado) !== 0)
{
    $listAux = array();
    if($origen != null && $nombre == null){
        foreach($listado as $item){
            if($item->origen == $origen){
                array_push($listAux, $item);
            }
        }
    }
    else if($origen == null && $nombre != null){
        foreach($listado as $item){
            if($item->nombre == $nombre){
                array_push($listAux, $item);
            }
        }
    }
    else if($origen != null && $nombre != null){
        foreach($listado as $item){
            if($item->nombre == $nombre && $item->origen == $origen){
                array_push($listAux, $item);
            }
        }
    }
    var_dump($listAux);
    echo "<table style='border:2px solid black;border-collapse:collapse;'>
    <tr>
        <th style='border:1px solid black;padding:20px;'>Nombre</th>
        <th style='border:1px solid black;padding:20px;'>Origen</th>
        <th style='border:1px solid black;padding:20px;'>Codigo de barras</th>
        <th style='border:1px solid black;padding:20px;'>Precio</th>
        <th style='border:1px solid black;padding:20px;'>Foto</th>
    </tr>";
    foreach($listAux as $itemAux){
        echo "<tr>
            <td style='border:1px solid black;padding:20px;'>$itemAux->nombre</td>
            <td style='border:1px solid black;padding:20px;'>$itemAux->origen</td>
            <td style='border:1px solid black;padding:20px;'>$itemAux->codigoBarra</td>
            <td style='border:1px solid black;padding:20px;'>$itemAux->precio</td>
            <td style='border:1px solid black;padding:20px;'><img width=50 height=50 src'$itemAux->pathFoto /></td>
        </tr>";
    }
    echo "</table>";
}


?>