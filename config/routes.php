<?php

use Aluraplay\Controller\LoginController;
use Aluraplay\Controller\LogoutController;
use Aluraplay\Controller\Video\DeleteController;
use Aluraplay\Controller\Video\EditController;
use Aluraplay\Controller\Video\InsertController;
use Aluraplay\Controller\Video\ListController;

return [
    "GET|/" => ListController::class,
    "GET|novo-video" => InsertController::class,
    "POST|novo-video" => InsertController::class,
    "GET|editar-video" => EditController::class,
    "POST|editar-video" => EditController::class,
    "GET|deletar-video" => DeleteController::class,
    "GET|login" => LoginController::class,
    "POST|login" => LoginController::class,
    "GET|logout" => LogoutController::class
];