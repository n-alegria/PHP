<?php
/* Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
lapiceras. */

$lapicera1 = array('color'=>"negro" ,'marca'=>"bic" ,'trazo'=>"0.5" , 'precio'=>70 );
$lapicera2 = array('color'=>"violeta" ,'marca'=>"pelican" ,'trazo'=>"0.7" , 'precio'=>60 );
$lapicera3 = array('color'=>"blanco" ,'marca'=>"frambula" ,'trazo'=>"1" , 'precio'=>40 );

echo "<b>Muestro lapicera #1 con foreach: <br></b>";
foreach ($lapicera1 as $v) {
    echo $v, "<br>";
}

echo "<br><b>Muestro solo el COLOR de lapicera #2: </b>";
echo "<br>" . $lapicera2["color"] ."<br>"; 

echo "<br><b>Muestro lapicera #3 con var_dump:</b><br> ";
var_dump(($lapicera3));

?>