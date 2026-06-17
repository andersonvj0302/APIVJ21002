<?php

declare(strict_types=1);

use App\Application\Middleware\CorsMiddleware;
use Slim\App;

// Middleware global de la aplicacion
return function (App $app) {
    $app->add(CorsMiddleware::class);
};
