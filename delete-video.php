<?php

use Aluraplay\Database\Connection;
use Aluraplay\Repository\VideoRepository;

require_once __DIR__ . "/vendor/autoload.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: /aluraplay/index.php");
    exit;
}

$connection = Connection::getInstance();
$repository = new VideoRepository($connection);
try {
    $result = $repository->remove($id);
} catch (Exception $e) {
    echo "<h1>{$e->getMessage()}</h1>";
}


if ($result) {
    header("Location: /");
}

