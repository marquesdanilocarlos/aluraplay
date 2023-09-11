<?php

namespace Aluraplay\Controller;

use Aluraplay\Database\Connection;
use Aluraplay\Repository\UserRepository;
use Exception;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController extends Controller implements RequestHandlerInterface
{

    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $redirect = [];

            if (!empty($_SESSION["logged"])) {
                $redirect = ["Location" => "/"];
            }

            return new Response(301, $redirect, $this->render("login"));
        }

        $data = filter_input_array(INPUT_POST, [
            "email" => FILTER_VALIDATE_EMAIL,
            "password" => FILTER_DEFAULT
        ]);

        if (in_array(null, $data)) {
            return new Response(301, ["Location" => "login"]);
        }

        try {
            $user = $this->repository->getByEmail($data["email"]);

            if (!password_verify($data["password"], $user->password ?? '') || empty($user)) {
                self::addMessage("Usuário ou senha incorretos.", MESSAGE_WARNING);
                return new Response(301, ["Location" => "login"]);
            }

            $_SESSION["logged"] = true;
            return new Response(301, ["Location" => "/"]);
        } catch (Exception $e) {
            self::addMessage($e->getMessage(), MESSAGE_ERROR);
            return new Response(500, ["Location" => "login"]);
        }
    }
}