<?php

use DI\ContainerBuilder;
use League\Plates\Engine;
use Psr\Container\ContainerInterface;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {            // o PDO:: ajuda a ide e o PHP-DI exatamente o que ela vai add //
        $dbPath = __DIR__ . '/../banco.sqlite';
        return new PDO("sqlite:$dbPath");
    },
    Engine::class => function () {
        $templatePath = __DIR__ . '/../views';
        return new League\Plates\Engine($templatePath);

        // return new League\Plates\Engine($templatePath); // é uma forma de fazer, mas como ja tem no USE, não precisa necessariamente //
    }
]);
// utilizado uma factory com funcoes anonimas, com isso só vai executar o codigo quando alguem chamar, economizando processamento //

/** @var ContainerInterface $container */
$container = $builder->build();

return $container;
