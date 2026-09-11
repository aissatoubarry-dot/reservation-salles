<?php

declare(strict_types=1);

namespace App\Support;

final class FlashMessage
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function success(string $message): void
    {
        $_SESSION['flash_success'] = $message;
        session_write_close();
    }

    public function error(string $message): void
    {
        $_SESSION['flash_error'] = $message;
        session_write_close();
    }

    public function getSuccess(): ?string
    {
        $message = $_SESSION['flash_success'] ?? null;

        unset($_SESSION['flash_success']);

        return $message;
    }

    public function getError(): ?string
    {
        $message = $_SESSION['flash_error'] ?? null;

        unset($_SESSION['flash_error']);

        return $message;
    }
}
