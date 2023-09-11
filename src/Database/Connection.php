<?php

namespace Aluraplay\Database;

use PDO;

class Connection
{
    private static PDO $instance;

    public static function getInstance(PDO $pdo): PDO
    {
        if (empty(self::$instance)) {
            self::$instance = $pdo;
        }

        return self::$instance;
    }
}