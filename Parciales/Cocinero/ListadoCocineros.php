<?php
// ListadoCocineros.php: (GET) Se mostrará el listado de todos los cocineros en formato JSON.

require_once('./clases/Cocinero.php');
$listado = Cocinero::TraerTodos();
$retorno = '';
foreach ($listado as $aux) {
    $retorno .= $aux->ToJSON();
}
echo $retorno;