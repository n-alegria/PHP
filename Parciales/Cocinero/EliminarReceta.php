<?php
// EliminarReceta.php: Si recibe un nombre por GET, retorna si la receta está en la base o no (mostrar mensaje).
// Si recibe por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todas las recetas
// borradas y sus respectivas imagenes.
// Si recibe el parámetro receta_json (id, nombre y tipo, en formato de cadena JSON) por POST, más el parámetro
// accion con valor "borrar", se deberá borrar la receta (invocando al método Eliminar).
// Si se pudo borrar en la base de datos, invocar al método GuardarEnArchivo.
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

require_once './clases/Receta.php';
require_once './clases/AccesoDatos.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');

$retorno = new stdClass();
$retorno->exito = false;
$retorno->mensaje = 'Error';

$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
$receta_json = isset($_POST['receta_json']) ? $_POST['receta_json'] : null;
$accion = isset($_POST['accion']) ? $_POST['accion'] : null;

if(isset($_POST['receta_json'])){
/// Si recibe el parámetro receta_json (id, nombre y tipo, en formato de cadena JSON) por POST, más el parámetro
// accion con valor "borrar", se deberá borrar la receta (invocando al método Eliminar).
// Si se pudo borrar en la base de datos, invocar al método GuardarEnArchivo.
    $json = json_decode($receta_json);
    if($accion == 'borrar'){
        $receta = new Receta($json->id, $json->nombre, '', $json->tipo, '');
        $recetaAnterior = null;

        $listado = $receta->Traer();

        if($receta->Existe($listado)){
            foreach ($listado as $auxiliar) {
                if($auxiliar->id == $receta->id){
                    $recetaAnterior = $auxiliar;
                    break;
                }
            }
            if($receta->Eliminar()){
                $recetaAnterior->GuardarEnArchivo();
                $retorno->exito = true;
                $retorno->mensaje = 'Receta eliminada con exito';
            }
        }
    }
    else{
        $retorno->mensaje = 'La accion no coincide con la aceptada';
    }
    echo json_encode($retorno);
}
else if(isset($_GET['nombre'])){
// Si recibe por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todas las recetas
// borradas y sus respectivas imagenes.
    $objetoAccesoDato =AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM recetas WHERE nombre=:nombre");           
    $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
    $consulta->execute();
    if($consulta->rowCount()){
        $retorno->exito = true;
        $retorno->mensaje = 'La receta esta en la base de datos';
    }
    echo json_encode($retorno);
}
else if(!isset($_GET['nombre'])){
// Si recibe por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todas las recetas
// borradas y sus respectivas imagenes.
    $listado = array();
    $path = './recetas_borradas.txt';
    if(file_exists($path)){
        $archivo = fopen($path, 'r');
        if($archivo){
            while(!feof($archivo)){
                $linea = trim(fgets($archivo));
                if($linea){
                    $json = json_decode($linea);
                    $cocinero = new Receta($json->id, $json->nombre, $json->ingredientes, $json->tipo, $json->pathFoto);
                    array_push($listado, $cocinero);
                }
            }
        }
        fclose($archivo);
    }
    if(count($listado) > 0){
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
        foreach($listado as $receta)
        {
            echo "<tr>";
                echo "<td>" . $receta->id . "</td>";
                echo "<td>" . $receta->nombre . "</td>";
                echo "<td>" . $receta->ingredientes . "</td>";
                echo "<td>" . $receta->tipo . "</td>";
                echo "<td>";
                if($receta->pathFoto != "")
                {
                    if(file_exists("./recetasBorradas/".$receta->pathFoto)) {
                        echo '<img src="./recetasBorradas/'.$receta->pathFoto.'" alt=./recetasBorradas/"'.$receta->pathFoto.'" height="100px" width="100px">'; 
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
}
?>