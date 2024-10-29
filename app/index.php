<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';
require_once './db/AccesoDatos.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php'; 
require_once './controllers/MesaController.php'; 
require_once './controllers/PedidoController.php'; 

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes for usuarios
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \UsuarioController::class . ':CargarUno');
});

// Routes for productos
$app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->get('/{id}', \ProductoController::class . ':TraerUno');
    $group->post('[/]', \ProductoController::class . ':CargarUno');
});

// Routes for mesas
$app->group('/mesas', function (RouteCollectorProxy $group) {

  $group->get('[/]', \MesaController::class . ':TraerTodos'); 
  $group->get('/{id}', \MesaController::class . ':TraerUno'); 
  $group->post('[/]', \MesaController::class . ':CargarUno'); 
});

// Routes for mesas
$app->group('/pedidos', function (RouteCollectorProxy $group) {

  $group->get('[/]', \PedidoController::class . ':TraerTodos'); 
  $group->get('/{id}', \PedidoController::class . ':TraerUno'); 
  $group->post('[/]', \PedidoController::class . ':CargarUno'); 
});

$app->run();
