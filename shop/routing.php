<?php
require_once(__DIR__.'/autoload.php');
use Controllers\SnackController;
use Controllers\UserController;
use Controllers\CartController;
use Controllers\RatingController;

$reqUrl = $_SERVER['REQUEST_URI'];

$routeMap = [
    '/^\/$/' => ['controller' => SnackController::class, 'view' => 'index'],
    '/^\/login$/' => ['controller' => UserController::class, 'view' => 'login'],
    '/^\/logout$/' => ['controller' => UserController::class, 'view' => 'logout'],
    '/^\/cart$/' => ['controller' => CartController::class, 'view' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'update' : 'show'],
    '/^\/checkout$/' => ['controller' => CartController::class, 'view' => 'checkout'],
    '/^\/rating$/' => ['controller' => RatingController::class, 'view' => 'rate']
];

foreach ($routeMap as $url => $route) {
    if (preg_match($url, $reqUrl)) {
        $dispatch = new $route['controller'];
        $dispatch->{$route['view']}();
        exit();
    }
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';

?>