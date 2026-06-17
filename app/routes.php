<?php

declare(strict_types=1);

use App\Application\Actions\Doctor\CreateDoctorAction;
use App\Application\Actions\Doctor\ListDoctorsAction;
use App\Application\Actions\Hospital\CreateHospitalAction;
use App\Application\Actions\Hospital\GetHospitalAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

// Definicion de rutas de la API
return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    // Pagina inicial con info de la API
    $app->get('/', function (Request $request, Response $response) {
        $payload = [
            'proyecto' => 'API Ministerio de Salud - VJ21002',
            'endpoints' => [
                'GET /doctores' => 'Listar todos los doctores',
                'POST /doctores' => 'Registrar un doctor',
                'GET /hospitales/{id}' => 'Obtener hospital por ID',
                'POST /hospitales' => 'Registrar un hospital',
            ],
        ];

        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // Endpoints de doctores
    $app->get('/doctores', ListDoctorsAction::class);
    $app->post('/doctores', CreateDoctorAction::class);

    // Endpoints de hospitales
    $app->get('/hospitales/{id}', GetHospitalAction::class);
    $app->post('/hospitales', CreateHospitalAction::class);
};
