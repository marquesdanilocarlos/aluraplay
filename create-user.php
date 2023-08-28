<?php

use Aluraplay\Database\Connection;

require __DIR__ . "/vendor/autoload.php";

$connection = Connection::getInstance();

$email = $argv[1];
$password = password_hash($argv[2], PASSWORD_ARGON2I);

$query = "INSERT INTO users (email, password) VALUES (:email, :password)";
$stmt = $connection->prepare($query);
$stmt->bindValue(":email", $email);
$stmt->bindValue(":password", $password);

var_dump($stmt->execute());