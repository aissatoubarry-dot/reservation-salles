<?php

declare(strict_types=1);

namespace App\Support;

final class HtmlResponseStrategy implements ResponseStrategyInterface
{
    private const TEMPLATES_PATH = __DIR__ . '/../../templates/';

    public function __construct(
        private FlashMessage $flash
    ) {
    }

    public function render(string $view, array $data = []): void
    {
        $title = $data['title'] ?? 'Réservation de salles';

        extract($data, EXTR_SKIP);

        ob_start();

        require self::TEMPLATES_PATH . $view . '.php';

        $content = ob_get_clean();

        $successMessage = $this->flash->getSuccess();
        $errorMessage = $this->flash->getError();

        require self::TEMPLATES_PATH . 'layout/base.php';
    }

    public function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    public function notFound(): void
    {
        http_response_code(404);

        $this->render('error/404');
    }

    public function methodNotAllowed(array $allowedMethods): void
    {
        http_response_code(405);

        header('Allow: ' . implode(', ', $allowedMethods));

        $this->render('error/405');
    }
}