<?php

require 'vendor/autoload.php';

session_save_path('/tmp');
session_start();

use PHPRouter\RouteCollection;
use PHPRouter\Router;
use PHPRouter\Route;

$collection = new RouteCollection();

$collection->attach(new Route('/', array(
    '_controller' => 'Zitcom\Controllers\IndexController::index',
    'methods' => 'GET'
)));

$collection->attach(new Route('/registrer', array(
    '_controller' => 'Zitcom\Controllers\IndexController::create_user',
    'methods' => 'GET'
)));

$collection->attach(new Route('/login', array(
    '_controller' => 'Zitcom\Controllers\LoginController::login',
    'methods' => 'POST'
)));


$router = new Router($collection);
$router->setBasePath('/');
$route = $router->matchCurrentRequest();
var_dump($route);


