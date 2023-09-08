<?php

use Aluraplay\Controller\Controller;
use Aluraplay\Controller\Error404;
use Aluraplay\Database\Connection;
use Aluraplay\Repository\VideoRepository;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

require_once __DIR__ . "/../vendor/autoload.php";

$connection = Connection::getInstance();
$repository = new VideoRepository($connection);

$rawUrl = isset($_SERVER['REQUEST_URI']) ? explode('/', ltrim($_SERVER['REQUEST_URI'], '/')) : [];
$rawUrl = array_shift($rawUrl);
$newUrl = strstr($rawUrl, "?", true);
$url = $newUrl ?: $rawUrl;
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


$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();


/**
 * @var Controller $controller
 */
$controller = new $controllerClass($repository);
$response = $controller->handle($request);
http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        $name = ($name==="Location") ? "Location: " : $name;
        header(sprintf('%s %s', $name, $value), false);
    }
}

echo $response->getBody();
