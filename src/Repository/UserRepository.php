<?php

namespace Aluraplay\Repository;

use Aluraplay\Entity\User;
use Aluraplay\Entity\Video;
use Exception;
use PDO;

class UserRepository
{
    public function __construct(public readonly PDO $connection)
    {
    }

    public function getByEmail(string $email): ?User
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":email", $email);

        if (!$stmt->execute()) {
            throw new Exception("Não foi possível recuperar o usuário com o e-mail informado.");
        }

        $userData = $stmt->fetch();

        if (!$userData) {
            return null;
        }

        return new User(...$userData);
    }
}