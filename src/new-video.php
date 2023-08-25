<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Aluraplay\Database\Connection;

$connection = Connection::getInstance();

$data = filter_input_array(INPUT_POST, [
    "url" => FILTER_VALIDATE_URL,
    "title" => FILTER_SANITIZE_SPECIAL_CHARS
]);

if (in_array(false, $data)) {
    header("Location: /aluraplay/index.php");
    exit;
}

$query = "INSERT INTO videos (title, url) VALUES (:title, :url)";
$stmt = $connection->prepare($query);

$result = $stmt->execute($data);

if ($result) {
    header("Location: /aluraplay/index.php?success=1");
} else {
    header("Location: /aluraplay/index.php?success=0");
}