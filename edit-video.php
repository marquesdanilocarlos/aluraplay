<?php

use Aluraplay\Database\Connection;

require_once __DIR__ . "/vendor/autoload.php";

$data = filter_input_array(INPUT_POST, [
    "id" => FILTER_VALIDATE_INT,
    "url" => FILTER_VALIDATE_URL,
    "title" => FILTER_SANITIZE_SPECIAL_CHARS
]);

if (in_array(false, $data)) {
    header("Location: /aluraplay");
    exit;
}

$connection = Connection::getInstance();
$query = "UPDATE videos SET url = :url, title = :title WHERE id = :id";
$stmt = $connection->prepare($query);

if ($stmt->execute($data)) {
    header("Location: /");
}