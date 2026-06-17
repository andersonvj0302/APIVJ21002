<?php

declare(strict_types=1);

namespace App\Application\Actions\Doctor;

use App\Application\Actions\Action;
use App\Infrastructure\Persistence\DoctorRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateDoctorAction extends Action
{
    private DoctorRepository $doctorRepository;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        DoctorRepository $doctorRepository
    ) {
        parent::__construct($logger);
        $this->doctorRepository = $doctorRepository;
    }

    protected function action(): Response
    {
        $data = $this->getFormData();

        if (!is_array($data)) {
            throw new HttpBadRequestException($this->request, 'Datos JSON invalidos.');
        }

        $required = ['nombre', 'apellido', 'num_colegiado', 'id_hospital'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new HttpBadRequestException($this->request, "El campo {$field} es obligatorio.");
            }
        }

        $id = $this->doctorRepository->create($data);

        $responseData = [
            'mensaje' => 'Doctor registrado correctamente',
            'id_doctor' => $id,
        ];

        $json = json_encode($responseData, JSON_UNESCAPED_UNICODE);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
