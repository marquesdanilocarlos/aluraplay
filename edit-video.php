<?php

use Aluraplay\Database\Connection;
use Aluraplay\Entity\Video;
use Aluraplay\Repository\VideoRepository;

require_once __DIR__ . "/vendor/autoload.php";

$data = filter_input_array(INPUT_POST, [
    "url" => FILTER_VALIDATE_URL,
    "title" => FILTER_SANITIZE_SPECIAL_CHARS
]);
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (in_array(false, $data)) {
    header("Location: /aluraplay");
    exit;
}

$video = new Video(...$data);
$video->setId($id);
$connection = Connection::getInstance();
$repository = new VideoRepository($connection);

try {
    $result = $repository->update($video);
} catch (Exception $e) {
    echo "<h1>{$e->getMessage()}</h1>";
}

if ($result) {
    header("Location: /");
}