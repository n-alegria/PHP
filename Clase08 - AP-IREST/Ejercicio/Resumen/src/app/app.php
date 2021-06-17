<?php
use Psr\Http\Message\ResponseInterface as Response; # Respuesta
use Psr\Http\Message\ServerRequestInterface as Request; # Peticion
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

$app = AppFactory::create();

//################################################################################
// 01- CONFIGURO LOS VERBOS GET, POST, PUT Y DELETE
//################################################################################
// firma correcta para el standard -> (request, response, array) => response

$app->get('/', function (Request $request, Response $response, $args) : Response {
    $response->getBody()->write("GET => Bienvenido, SlimFramework 4!");
    return $response;
});

$app->post('/', function (Request $request, Response $response, $args) : Response {
    $response->getBody()->write("POST => Bienvenido, SlimFramework 4!");
    return $response;
});

$app->put('/', function (Request $request, Response $response, $args) : Response {
    $response->getBody()->write("PUT => Bienvenido, SlimFramework 4!");
    return $response;
});

$app->delete('/', function (Request $request, Response $response, $args) : Response {
    $response->getBody()->write("DELETE => Bienvenido, SlimFramework 4!");
    return $response;
});

$app->run();
