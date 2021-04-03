<?php
require_once "../vendor/autoload.php";
//DEBUG BONITOS
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();



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

$map->get('loguin', '/loguin', [
    "Controller" => "App\Controller\LoginController",
    "Action" => "getIndex"
]);
$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if ($route->isRoutable) {
        $handler = $route->handler;
        $controller = $handler['Controller'];
        $action = $handler['Action'];
        $callController = new $controller();
        $response = $callController->$action($request);
        echo $response->getBody();
   
} else {
    echo "ruta no encontrada";
}
