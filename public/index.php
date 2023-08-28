<?php
require_once __DIR__ . "/../vendor/autoload.php";

$url = isset($_SERVER['REQUEST_URI']) ? explode('/', ltrim($_SERVER['REQUEST_URI'], '/')) : [];
$url = array_shift($url);
$newUrl = strstr($url, "?" ,true);
$url = $newUrl ?: $url;

if (!$url) {
    require_once __DIR__ . "/../list-videos.php";
} elseif ($url === "novo-video" || $url === "editar-video") {
    require_once __DIR__ . "/../form.php";
} elseif ($url === "deletar-video") {
    require_once __DIR__ . "/../delete.php";

}