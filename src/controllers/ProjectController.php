<?php

declare(strict_types=1);

namespace App\Controller;

final class ProjectController extends AppController
{
    public function index(): void
    {
        $query = trim((string) ($_GET['q'] ?? ''));

        $this->render('projects', [
            'pageTitle' => 'Projekty',
            'searchQuery' => $query,
        ]);
    }

    public function byStatus(string $status): void
    {
        $this->render('projects', [
            'pageTitle' => 'Projekty (' . $status . ')',
            'searchQuery' => '',
            'statusFilter' => $status,
        ]);
    }

    public function show(int $id): void
    {
        $this->render('project', [
            'pageTitle' => 'Szczegóły projektu #' . $id,
            'projectId' => $id,
        ]);
    }
}
