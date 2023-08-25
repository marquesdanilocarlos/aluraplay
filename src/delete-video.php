<?php

use Aluraplay\Database\Connection;

require_once __DIR__ . "/../vendor/autoload.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: /aluraplay/index.php");
    exit;
}

$connection = Connection::getInstance();
$query = "DELETE FROM videos WHERE id = :id";
$stmt = $connection->prepare($query);
$stmt->bindValue(":id", $id);

if ($stmt->execute()) {
    header("Location: /aluraplay/index.php?success=1");
} else {
    header("Location: /aluraplay/index.php?success=0");
}

