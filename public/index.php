<?php

use Aluraplay\Controller\Error404;
use Aluraplay\Controller\Video\DeleteController;
use Aluraplay\Controller\Video\FormController;
use Aluraplay\Controller\Video\ListController;
use Aluraplay\Database\Connection;
use Aluraplay\Repository\VideoRepository;

require_once __DIR__ . "/../vendor/autoload.php";

$url = isset($_SERVER['REQUEST_URI']) ? explode('/', ltrim($_SERVER['REQUEST_URI'], '/')) : [];
$url = array_shift($url);
$newUrl = strstr($url, "?", true);
$url = $newUrl ?: $url;


$connection = Connection::getInstance();
$repository = new VideoRepository($connection);

if (!$url) {
    (new ListController($repository))->dispatch();
} elseif ($url === "novo-video" || $url === "editar-video") {
    (new FormController($repository))->dispatch();
} elseif ($url === "deletar-video") {
    (new DeleteController($repository))->dispatch();
} else {
    (new Error404())->dispatch();
}