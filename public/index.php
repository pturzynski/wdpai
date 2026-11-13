<?php

declare(strict_types=1);

use App\Controller\DefaultController;
use App\Controller\ProjectController;
use App\Routing;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$routing = new Routing();

$routing->get('/', DefaultController::class, 'index');
$routing->get('/projects', ProjectController::class, 'index');
$routing->getRegex('~^/projects/status/(?P<status>planned|active|completed)$~', ProjectController::class, 'byStatus');
$routing->get('/projects/{id}', ProjectController::class, 'show');

$statusCode = $routing->dispatch(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $_SERVER['REQUEST_URI'] ?? '/',
);

$defaultController = new DefaultController();
match ($statusCode) {
    200 => null,
    400 => $defaultController->badRequest(),
    405 => $defaultController->methodNotAllowed(),
    default => $defaultController->notFound(),
};
