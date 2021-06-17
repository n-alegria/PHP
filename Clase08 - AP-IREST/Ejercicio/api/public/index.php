<?php
use Psr\Http\Message\ResponseInterface as Response; # Respuesta
use Psr\Http\Message\ServerRequestInterface as Request; # Peticion
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();
