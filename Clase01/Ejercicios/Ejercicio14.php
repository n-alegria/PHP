<?php
/* Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays. */

$asociativo = [
    $animales = array('Perro', 'Gato', 'Ratón', 'Araña', 'Mosca'),
    $numeros = array('1986', '1996', '2015', '78', '86'),
    $lenguajes = array('php', 'mysql', 'html5', 'typescript', 'ajax')
];

echo "<b>Mostrar array asociativo: <br></b>";
foreach ($asociativo as $v) {
    foreach ($v as $var) {
        echo $var, " ";
    }
}


$indexado = array(
    array('Perro', 'Gato', 'Ratón', 'Araña', 'Mosca'),
    array('1986', '1996', '2015', '78', '86'),
    array('php', 'mysql', 'html5', 'typescript', 'ajax')
);

echo "<b><br><br>Mostrar array indexado con foreach: <br></b>";
foreach ($indexado as $v) {
    foreach ($v as $var) {
        echo $var, " ";
    }
}

echo "<b><br><br>Mostrar array indexado con for: </b> //debido a que es indexado, se puede trabajar como una matriz, lo cual lo diferencia del asociativo<br>";
for ($i=0; $i < count($indexado); $i++) { 
    for ($j=0; $j < count($indexado[$i]); $j++) { 
        echo $indexado[$i][$j], " ";
    }
}
?>