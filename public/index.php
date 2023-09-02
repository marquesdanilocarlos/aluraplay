<?php

use Aluraplay\Controller\Controller;
use Aluraplay\Controller\Error404;
use Aluraplay\Database\Connection;
use Aluraplay\Repository\VideoRepository;

require_once __DIR__ . "/../vendor/autoload.php";

$connection = Connection::getInstance();
$repository = new VideoRepository($connection);

$url = isset($_SERVER['REQUEST_URI']) ? explode('/', ltrim($_SERVER['REQUEST_URI'], '/')) : [];
$url = array_shift($url);
$newUrl = strstr($url, "?", true);
$url = $newUrl ?: $url;
$url = $url ?: "/";
$method = $_SERVER["REQUEST_METHOD"];

$routes = require_once __DIR__ . "/../config/routes.php";

$key = "$method|$url";
$controllerClass = Error404::class;

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];
}

session_start();

//Regerar o ID da sessão
/*if (isset($_SESSION['logado'])) {
    $originalInfo = $_SESSION['logado'];
    unset($_SESSION['logado']);
    session_regenerate_id();
    $_SESSION['logado'] = $originalInfo;
}*/


if (!array_key_exists("logged", $_SESSION) && $url !== "login") {
    header("Location: login");
    return;
}

/**
 * @var Controller $controller
 */
$controller = new $controllerClass($repository);
$controller->dispatch();
