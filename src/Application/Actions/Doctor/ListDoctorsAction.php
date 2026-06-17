<?php

declare(strict_types=1);

namespace App\Application\Actions\Doctor;

use App\Application\Actions\Action;
use App\Infrastructure\Persistence\DoctorRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ListDoctorsAction extends Action
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
        $doctores = $this->doctorRepository->findAll();

        $json = json_encode($doctores, JSON_UNESCAPED_UNICODE);
        $this->response->getBody()->write($json);

        return $this->response->withHeader('Content-Type', 'application/json');
    }
}
