<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use App\Infrastructure\Database;
use App\Infrastructure\Persistence\DoctorRepository;
use App\Infrastructure\Persistence\HospitalRepository;
use DI\ContainerBuilder;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true,
                'logError' => false,
                'logErrorDetails' => false,
                'db' => [
                    'host' => $_ENV['DB_HOST'] ?? 'localhost',
                    'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
                    'name' => $_ENV['DB_NAME'] ?? 'salud_vj21002',
                    'user' => $_ENV['DB_USER'] ?? 'root',
                    'pass' => $_ENV['DB_PASS'] ?? '',
                ],
                'logger' => [
                    'name' => 'salud-api-vj21002',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
            ]);
        },

        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);
            $handler = new \Monolog\Handler\StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        Database::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class)->get('db');

            return new Database(
                $settings['host'],
                $settings['name'],
                $settings['user'],
                $settings['pass'],
                $settings['port']
            );
        },

        DoctorRepository::class => function (ContainerInterface $c) {
            return new DoctorRepository($c->get(Database::class));
        },

        HospitalRepository::class => function (ContainerInterface $c) {
            return new HospitalRepository($c->get(Database::class));
        },
    ]);
};
