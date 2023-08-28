<?php

require_once __DIR__ . "/vendor/autoload.php";

use Aluraplay\Database\Connection;
use Aluraplay\Entity\Video;
use Aluraplay\Repository\VideoRepository;

$connection = Connection::getInstance();

$data = filter_input_array(INPUT_POST, [
    "url" => FILTER_VALIDATE_URL,
    "title" => FILTER_SANITIZE_SPECIAL_CHARS
]);

if (in_array(false, $data)) {
    header("Location: /");
    exit;
}

$repository = new VideoRepository($connection);

try {
    $result = $repository->insert(new Video(...$data));
} catch (Exception $e) {
    echo "<h1>{$e->getMessage()}</h1>";
}

if ($result) {
    header("Location: /");
}