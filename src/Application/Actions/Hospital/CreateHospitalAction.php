<?php

declare(strict_types=1);

namespace App\Application\Actions\Hospital;

use App\Application\Actions\Action;
use App\Infrastructure\Persistence\HospitalRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

// POST /hospitales - registrar un hospital
class CreateHospitalAction extends Action
{
    private HospitalRepository $hospitalRepository;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        HospitalRepository $hospitalRepository
    ) {
        parent::__construct($logger);
        $this->hospitalRepository = $hospitalRepository;
    }

    protected function action(): Response
    {
        $data = $this->getFormData();

        if (!is_array($data)) {
            throw new HttpBadRequestException($this->request, 'Datos JSON invalidos.');
        }

        // Validar campos obligatorios
        $required = ['nombre_hospital', 'direccion', 'telefono', 'id_especialidad'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new HttpBadRequestException($this->request, "El campo {$field} es obligatorio.");
            }
        }

        $id = $this->hospitalRepository->create($data);

        $responseData = [
            'mensaje' => 'Hospital registrado correctamente',
            'id_hospital' => $id,
        ];

        $json = json_encode($responseData, JSON_UNESCAPED_UNICODE);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
