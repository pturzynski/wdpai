<?php

declare(strict_types=1);

namespace App;

use App\Controller\AppController;

final class Routing
{
    /**
     * @var list<array{
     *     method: string,
     *     pattern: string,
     *     controller: class-string<AppController>,
     *     action: string,
     *     idParams: list<string>
     * }>
     */
    private array $routes = [];

    /** @param class-string<AppController> $controller */
    public function get(string $path, string $controller, string $action): void
    {
        $this->add('GET', $path, $controller, $action);
    }

    /** @param class-string<AppController> $controller */
    public function post(string $path, string $controller, string $action): void
    {
        $this->add('POST', $path, $controller, $action);
    }

    /** @param class-string<AppController> $controller */
    public function getRegex(string $regex, string $controller, string $action): void
    {
        $this->addRegex('GET', $regex, $controller, $action);
    }

    /** @param class-string<AppController> $controller */
    public function postRegex(string $regex, string $controller, string $action): void
    {
        $this->addRegex('POST', $regex, $controller, $action);
    }

    /** @param class-string<AppController> $controller */
    private function add(
        string $method,
        string $path,
        string $controller,
        string $action,
    ): void {
        [$pattern, $idParams] = $this->createPattern($path);

        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action,
            'idParams' => $idParams,
        ];
    }

    /** @param class-string<AppController> $controller */
    private function addRegex(
        string $method,
        string $regex,
        string $controller,
        string $action,
    ): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $regex,
            'controller' => $controller,
            'action' => $action,
            'idParams' => [],
        ];
    }

    /**
     * Zamienia ścieżkę na wyrażenie regularne. Parametry {id} lub {*Id}
     * dopasowują dowolny segment, a ich poprawność (dodatnia liczba całkowita)
     * jest sprawdzana w dispatch(), aby błędne ID zwracało 400 Bad Request.
     *
     * @return array{0: string, 1: list<string>}
     */
    private function createPattern(string $path): array
    {
        $parts = explode('/', $path);
        $idParams = [];

        foreach ($parts as &$part) {
            if (str_starts_with($part, '{') && str_ends_with($part, '}')) {
                $parameterName = trim($part, '{}');
                if ($parameterName === 'id' || str_ends_with($parameterName, 'Id')) {
                    $idParams[] = $parameterName;
                }
                $part = '(?P<' . $parameterName . '>[^/]+)';
                continue;
            }

            $part = preg_quote($part, '~');
        }
        unset($part);

        return ['~^' . implode('/', $parts) . '$~', $idParams];
    }

    /**
     * Dopasowuje żądanie HTTP do zarejestrowanej trasy.
     * Zwraca kod statusu HTTP: 200 (wywołano kontroler), 400 (błędne id),
     * 405 (znana ścieżka, zła metoda) lub 404 (nie znaleziono trasy).
     */
    public function dispatch(string $method, string $uri): int
    {
        $method = strtoupper($method);
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $allowedMethods = [];

        foreach ($this->routes as $route) {
            if (!preg_match($route['pattern'], $path, $matches)) {
                continue;
            }

            if ($route['method'] !== $method) {
                $allowedMethods[] = $route['method'];
                continue;
            }

            $parameters = array_filter(
                $matches,
                static fn (int|string $key): bool => is_string($key),
                ARRAY_FILTER_USE_KEY,
            );

            foreach ($route['idParams'] as $idParam) {
                $raw = $parameters[$idParam] ?? '';
                if (!ctype_digit($raw) || (int) $raw <= 0) {
                    return 400;
                }
                $parameters[$idParam] = (int) $raw;
            }

            $controllerClass = $route['controller'];
            $controller = new $controllerClass();

            if (!$controller instanceof AppController) {
                throw new \RuntimeException('Invalid controller: ' . $controllerClass);
            }

            $controller->{$route['action']}(...$parameters);

            return 200;
        }

        if ($allowedMethods !== []) {
            header('Allow: ' . implode(', ', array_unique($allowedMethods)));
            return 405;
        }

        return 404;
    }
}
