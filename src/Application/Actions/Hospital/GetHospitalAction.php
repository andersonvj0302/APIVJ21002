<?php

declare(strict_types=1);

namespace App\Application\Actions\Hospital;

use App\Application\Actions\Action;
use App\Infrastructure\Persistence\HospitalRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class GetHospitalAction extends Action
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
        $id = (int) $this->resolveArg('id');
        $hospital = $this->hospitalRepository->findById($id);

        if ($hospital === null) {
            throw new HttpNotFoundException($this->request, 'Hospital no encontrado.');
        }

        $json = json_encode($hospital, JSON_UNESCAPED_UNICODE);
        $this->response->getBody()->write($json);

        return $this->response->withHeader('Content-Type', 'application/json');
    }
}
