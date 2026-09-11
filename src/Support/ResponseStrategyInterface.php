<?php

declare(strict_types=1);

namespace App\Support;

interface ResponseStrategyInterface
{
    public function render(string $view, array $data = []): void;

    public function redirect(string $url): void;

    public function notFound(): void;

    public function methodNotAllowed(array $allowedMethods): void;
}
