<?php

declare(strict_types=1);

namespace App\Support;

final class JsonResponseStrategy implements ResponseStrategyInterface
{
    private const JSON_FLAGS =
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

    public function render(string $view, array $data = []): void
    {
        header('Content-Type: application/json');

        echo json_encode(
            $data,
            self::JSON_FLAGS
        );
    }

    public function redirect(string $url): void
    {
        header('Content-Type: application/json');

        echo json_encode(
            ['redirect' => $url],
            self::JSON_FLAGS
        );
    }

    public function notFound(): void
    {
        http_response_code(404);

        header('Content-Type: application/json');

        echo json_encode(
            ['error' => 'Ressource introuvable.'],
            self::JSON_FLAGS
        );
    }

    public function methodNotAllowed(array $allowedMethods): void
    {
        http_response_code(405);

        header('Content-Type: application/json');

        echo json_encode(
            [
                'error' => 'Méthode non autorisée.',
                'allowed' => $allowedMethods,
            ],
            self::JSON_FLAGS
        );
    }
}
