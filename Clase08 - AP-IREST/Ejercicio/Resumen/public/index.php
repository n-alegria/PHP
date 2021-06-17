<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function(Request $request, Response $response, array $args) : Response{
    $response->getBody()->write("Hola Mundo");
    return $response;
});

//**************************************************************************************************************
// PARAMETROS => deben ir entre llaves en la URL
//**************************************************************************************************************
$app->get('/ruta/{id}', function(Request $request, Response $response, array $args) : Response{
    // Para acceder a los parametros debo utilizar la variable '$args[]' y entre corchetes indicar el nombre de la varible que tiene la URL 7
    $response->getBody()->write("Los parametros deben ir entre llaves '{parametro}'<br/>");
    $response->getBody()->write("Para acceder a los parametros debo utilizar la variable '\$args' y pasarle entre corchetes el nombre del parametro '[\"parametro\"]'<br/>");
    $response->getBody()->write("<br/>");
    $response->getBody()->write("<b>Parametro: </b>" . $args["id"]);
    return $response;
});

//**************************************************************************************************************
// RUTAS y PARAMETROS OPCIONALES => corchetes en la URL
//**************************************************************************************************************
$app->get('/rutaOpcional[/]', function(Request $request, Response $response, array $args) : Response{
    $response->getBody()->write("Las rutas opcionales deben ir entre corchetes [/]<br/>");
    $response->getBody()->write("URL con ruta opcional");
    return $response;
});
$app->get('/parametroOpcional/[{id}]', function(Request $request, Response $response, array $args) : Response{
    if(isset($args['id'])){
        $response->getBody()->write("<b>Parametro: </b>" . $args["id"]);
        $response->getBody()->write("<br/>");
    }
    $response->getBody()->write("Los parametros opcionales deben ir entre corchetes [{parametro}]<br/>");
    $response->getBody()->write("URL con parametro opcional");
    return $response;
});

//**************************************************************************************************************
// MAP -> solo recibe los verbos HTTP que estan detallados entre corchetes
//**************************************************************************************************************
$app->map(["GET", "POST"], '/mapa', function(Request $request, Response $response, array $args) : Response{
    $response->getBody()->write("Para saber que verbo se utilizo se debe utilizar: '\$request->getMethod()'<br/>");
    if($request->getMethod() === 'GET'){
        $response->getBody()->write("Verbo: GET");
    }
    if($request->getMethod() === "POST"){
        $response->getBody()->write("Verbo: POST");
    }
    return $response;
});

//**************************************************************************************************************
// GROUP -> recibe todos los verbos HTTP que respeten la ruta y los redirige a las que tiene definida
//**************************************************************************************************************
$app->group('/grupo', function(\Slim\Routing\RouteCollectorProxy $group){
    $group->get('/', function(Request $request, Response $response, array $args){
        $response->getBody()->write("GET");
        return $response;
    });
    $group->post('/', function(Request $request, Response $response, array $args){
        $response->getBody()->write("POST");
        return $response;
    });
});

//**************************************************************************************************************
// Retornar objetos JSON 
//**************************************************************************************************************
$app->get('/json/', function(Request $request, Response $response, array $args){
    // Declato un array asociativo de retorno (el JSON)
    $datos = array("nombre" => "lautaro", "datos" => "json");
    // Indico el estatus y mensaje de retorno en una nueva respuesta
    $nuvaRespuesta = $response->withStatus(200, "Mensaje JSON");
    // Escribo el JSON a partir del array asociativo
    $nuvaRespuesta->getBody()->write(json_encode($datos));
    // Retorno la respuesta e indico el tipo de contenido que se retorna (en el header)
    return $nuvaRespuesta->withHeader('Content-Type', 'application/json');
});

//**************************************************************************************************************
// Recibir parametros por POST y retornar objetos JSON 
// Se reciben en el cuerpo del HTTP no en la URL
//**************************************************************************************************************
$app->post('/parametrosJson/', function(Request $request, Response $response, array $args){
    // Obtengo los parametros (POST) en un array asociativo
    $arrayDeParametros = $request->getParsedBody();
    // Creo el objeto
    $objeto = new stdClass();
    $objeto->nombre = $arrayDeParametros['nombre'];
    $objeto->edad = $arrayDeParametros['edad'];
    $objeto->mail = $arrayDeParametros['mail'];
    // Indico el estatus y mensaje de retorno en una nueva respuesta
    $nuvaRespuesta = $response->withStatus(200, "Retorno JSON");
    // Escribo el JSON a partir del array asociativo
    $nuvaRespuesta->getBody()->write(json_encode($objeto));
    // Retorno la respuesta e indico el tipo de contenido que se retorna (en el header)
    return $nuvaRespuesta->withHeader('Content-Type', 'application/json');
});
// -> Recibir json por POST
$app->post('/recibirJson/', function(Request $request, Response $response, array $args){
    // Obtengo el json
    $arrayJson = $request->getParsedBody();
    // Debo traducir a objeto PHP
    $datos = json_decode($arrayJson['cadenaJson']);
    // Muestro los datos
    var_dump($datos);
    // Retorno una respuesta
    return $response;
});






$app->run();


?>