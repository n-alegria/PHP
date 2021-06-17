<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../clases/usuario.php';

$app = AppFactory::create();

$app->group('/usuarios', function (RouteCollectorProxy $grupo) {   
    $grupo->post('/login', Usuario::class . ':TraerUno');
    // $grupo->get('/{id}', \Cd::class . ':TraerUno');
    // $grupo->post('/', \Cd::class . ':AgregarUno');
    // $grupo->put('/{cadenaJson}', \Cd::class . ':ModificarUno');
    // $grupo->delete('/{id}', \Cd::class . ':BorrarUno');
});

$app->run();


?>