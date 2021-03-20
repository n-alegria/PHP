<?php
/* Cargar los tres arrays con los siguientes valores y luego ‘juntarlos’ en uno. Luego mostrarlo por
pantalla.
“Perro”, “Gato”, “Ratón”, “Araña”, “Mosca”
“1986”, “1996”, “2015”, “78”, “86”
“php”, “mysql”, “html5”, “typescript”, “ajax”
Para cargar los arrays utilizar la función array_push. Para juntarlos, utilizar la función
array_merge. */

$animales = array('Perro', 'Gato', 'Ratón', 'Araña', 'Mosca');
$numeros = array();
$lenguajes = array('php', 'mysql', 'html5', 'typescript', 'ajax');

echo "<b>Muestro animales (hardcodeado) con foreach: <br></b>";
foreach ($animales as $v) {
    echo $v, "<br>";
}

// Al metodo debo pasarle el array y los datos que cargare en el
array_push($numeros, '1986', '1996', '2015', '78', '86');
echo "<br><b>Muestro numeros (array_push) con foreach: <br></b>";
foreach ($numeros as $v) {
    echo $v, "<br>";
}

// El metodo retorna un nuevo array, este contendra los arrays pasados por parametros
$resultado = array_merge($animales, $numeros, $lenguajes);
echo "<br><b>Muestro MERGE con foreach: <br></b>";
foreach ($resultado as $v) {
    echo "&emsp;", $v, "<br>";
}
?>