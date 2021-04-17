<?php
require_once "../vendor/autoload.php";
//DEBUG BONITOS
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if (!isset($_SESSION)) {
    session_start();
}

use Aura\Router\RouterContainer;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

// loguin
$map->get('loguin', '/', [
    "Controller" => "App\Controller\LoginController",
    "Action" => "getIndex"
]);
$map->post('loguinAuth', '/loguin/auth', [
    "Controller" => "App\Controller\LoginController",
    "Action" => "auth"
]);
$map->get('logout', '/loguin/logout', [
    "Controller" => "App\Controller\LoginController",
    "Action" => "logout"
]);

//DASHBOARD
$map->get('dashboard', '/dashboard', [
    "Controller" => "App\Controller\DashboardController",
    "Action" => "getIndex",
    "needAuth" => true
]);

$map->post('goal', '/goal', [
    "Controller" => "App\Controller\GoalController",
    "Action" => "goal",
    "needAuth" => true
]);

$map->post('goalSave', '/goal/guardarController', [
    "Controller" => "App\Controller\GoalController",
    "Action" => "guardarController",
    "needAuth" => true
]);

$map->post('saveSaving', '/saving/save', [
    "Controller" => "App\Controller\SavingController",
    "Action" => "saveSaving",
    "needAuth" => true
]);

$map->post('saving', '/saving', [
    "Controller" => "App\Controller\SavingController",
    "Action" => "saving",
    "needAuth" => true
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if ($route->isRoutable) {
    $handler = $route->handler;
    $controller = $handler['Controller'];
    $action = $handler['Action'];
    $needAuth = $handler['needAuth'];

    if (!isset($_SESSION['id']) && $needAuth) {
        header("location:/");
    }

    $callController = new $controller();
    $response = $callController->$action($request);

    foreach ($response->getHeaders() as $key => $values) {
        foreach ($values as $value) {
            header("$key: $value", false);
        }
    }
    echo $response->getBody();
} else {
    echo "ruta no encontrada";
}
