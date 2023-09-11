<?php

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

use function DI\create;

/**
 * @var ContainerInterface $container;
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
    }
]);
$container = $builder->build();

return $container;