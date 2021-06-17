<?php
// EliminarReceta.php: Si recibe un nombre por GET, retorna si la receta está en la base o no (mostrar mensaje).
// Si recibe por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todas las recetas
// borradas y sus respectivas imagenes.
// Si recibe el parámetro receta_json (id, nombre y tipo, en formato de cadena JSON) por POST, más el parámetro
// accion con valor "borrar", se deberá borrar la receta (invocando al método Eliminar).
// Si se pudo borrar en la base de datos, invocar al método GuardarEnArchivo.
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

$retorno = new stdClass();
$retorno->exito = false;
$retorno->mensaje = 'Error';

$porGet = isset($_GET['porGet']) ? $_GET['porGet'] : null;
$receta_json = isset($_POST['receta_json']) ? $_POST['receta_json'] : null;
$accion = isset($_POST['accion']) ? $_POST['accion'] : null;

if($porGet != null){
    $objetoAccesoDato =AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM recetas WHERE nombre=:nombre");           
    $consulta->bindValue(':nombre', $porGet, PDO::PARAM_STR);
    $consulta->execute();
    if($consulta->rowCount()){
        $retorno->exito = true;
        $retorno->mensaje = 'La receta esta en la base de datos';
    }
}
else{
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
if($receta != null){
// Si recibe el parámetro receta_json (id, nombre y tipo, en formato de cadena JSON) por POST, más el parámetro
// accion con valor "borrar", se deberá borrar la receta (invocando al método Eliminar).
// Si se pudo borrar en la base de datos, invocar al método GuardarEnArchivo.
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
    $json = json_decode($receta_json);
    if($accion == 'borrar'){
        $receta = new Receta($json->id, $json->nombre, '', $json->tipo, '');
        if($receta->Eliminar()){
            $receta->GuardarEnArchivo();
            $retorno->exito = true;
            $retorno->mensaje = 'Receta eliminada con exito';
        }
    }
    else{
        $retorno->mensaje = 'La accion no coincide con la aceptada';
    }


}

return json_encode($retorno);


?>