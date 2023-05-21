<?php

require_once __DIR__ . '/vendor/autoload.php';

use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;

// Crear una instancia del contenedor de enrutamiento
$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();

// Rutas
$map->get('login.page', '/', [
  'App\Controllers\AuthController',
  'showLoginPage'
]);

$map->post('login.auth', '/auth', [
  'App\Controllers\AuthController',
  'authenticate'
]);

$map->get('login.out', '/salir', [
  'App\Controllers\AuthController',
  'logOut'
]);

$map->get('register.askdata', '/registro/datos-personales', [
  'App\Controllers\RegisterController',
  'askData'
]);

$map->get('register.requestData', '/registrarme', [
  'App\Controllers\RegisterController',
  'requestData'
]);

$map->post('register.register', '/registrarme', [
  'App\Controllers\RegisterController',
  'register'
]);

$map->get('home.welcome', '/inicio', [
  'App\Controllers\HomeController',
  'showHomePage'
]);

$map->get('make.notation', '/hacer/anotaciones', [
  'App\Controllers\MakeNotationController',
  'makeNotation'
]);

$map->post('save.notation', '/hacer/anotaciones', [
  'App\Controllers\MakeNotationController',
  'saveNotation'
]);

$map->get('make.citation', '/citacion/padres', [
  'App\Controllers\CiteParentsController',
  'citeParents'
]);

$map->post('save.citation', '/citacion/padres', [
  'App\Controllers\CiteParentsController',
  'saveCitation'
]);

$map->get('view.cite.parents', '/ver/citacion/padres', [
  'App\Controllers\ViewCiteParentsController',
  'viewCitations'
]);

$map->get('view.observer', '/ver/observador', [
  'App\Controllers\ViewObserverController',
  'viewObserver'
]);

// Obtener la ruta coincidente de las variables globales
$route = $routerContainer->getMatcher()->match(
  ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
  )
);

// Ejecutar la acción de la ruta coincidente
if ($route) {
  // Obtener el manejador de la ruta
  $handler = $route->handler;
  
  // Separar el nombre de la clase y el método
  list($controller, $method) = $handler;

  // Crear una instancia de la clase controladora
  $controllerInstance = new $controller();

  // Ejecutar el método de la clase controladora
  $controllerInstance->$method();
} else {
  // Ruta no encontrada
  echo 'Página no encontrada';
}
