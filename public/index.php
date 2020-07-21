<?php
declare(strict_types=1);

use Melfo01\DeclarationImpot\Application\DeclarationHandler;
use Melfo01\DeclarationImpot\Infrastructure\QontoBankHttpClient;

require dirname(__DIR__).'/vendor/autoload.php';

require dirname(__DIR__).'/config/config.php';
if (file_exists(dirname(__DIR__).'/config/config.local.php')) {
    require dirname(__DIR__) . '/config/config.local.php';
}

$declarationHandler = new DeclarationHandler(
    new QontoBankHttpClient(...$bankConstructorParameters)
);

$declarationHandler($month, $year);

