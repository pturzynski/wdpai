<?php

declare(strict_types=1);

namespace App\Controller;

final class DefaultController extends AppController
{
    public function index(): void
    {
        $this->render('home', [
            'pageTitle' => 'SplitIt — Strona główna',
        ]);
    }

    public function badRequest(): void
    {
        http_response_code(400);
        $this->render('error', [
            'pageTitle' => '400 — Nieprawidłowe żądanie',
            'statusCode' => 400,
            'heading' => 'Nieprawidłowe żądanie',
            'message' => 'Podany identyfikator lub parametr w adresie URL jest niepoprawny.',
        ]);
    }

    public function notFound(): void
    {
        http_response_code(404);
        $this->render('not-found', [
            'pageTitle' => '404 — Nie znaleziono strony',
        ]);
    }

    public function methodNotAllowed(): void
    {
        http_response_code(405);
        $this->render('error', [
            'pageTitle' => '405 — Niedozwolona metoda HTTP',
            'statusCode' => 405,
            'heading' => 'Niedozwolona metoda',
            'message' => 'Ta ścieżka nie obsługuje użytej metody HTTP.',
        ]);
    }
}
