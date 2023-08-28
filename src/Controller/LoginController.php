<?php

namespace Aluraplay\Controller;

use Aluraplay\Database\Connection;
use Aluraplay\Repository\UserRepository;
use Exception;

class LoginController extends Controller
{
    private readonly UserRepository $repository;
    public function __construct()
    {
        $this->repository = new UserRepository(Connection::getInstance());
    }
    public function dispatch(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            if (!empty($_SESSION["logged"])) {
                header("Location: /");
            }
            require_once __DIR__ . "/../../views/login.php";
            return;
        }

        $data = filter_input_array(INPUT_POST, [
            "email" => FILTER_VALIDATE_EMAIL,
            "password" => FILTER_DEFAULT
        ]);

        if (in_array(null, $data)) {
            header("Location: login");
            return;
        }

        try {
            $user = $this->repository->getByEmail($data["email"]);

            if (!password_verify($data["password"], $user->password ?? '')) {
                header("Location: login");
                return;
            }

            $_SESSION["logged"] = true;
            header("Location: /");

        } catch (Exception $e) {
            echo "<h1>{$e->getMessage()}</h1>";
        }

    }
}