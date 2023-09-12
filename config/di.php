<?php

use Aluraplay\FlashMessage;
use DI\ContainerBuilder;
use League\Plates\Engine;
use Psr\Container\ContainerInterface;

/**
 * @var ContainerInterface $container
 */

$builder = new ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        return new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS,
            DB_OPTIONS
        );
    },
    Engine::class => function () {
        $templatePath = __DIR__ . "/../views/";
        $engine = new Engine($templatePath);
        $engine->addData(["message" => FlashMessage::showMessage()]);
        return $engine;
    }
]);

return $builder->build();