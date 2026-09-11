<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\View\View;

    abstract class AbstractController
    {

        protected function render(string $template, array $data = []): void
        {
            View::render($template, $data);
        }

        protected function json(array $data, int $statusCode = 200): void
        {
            http_response_code($statusCode);
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        protected function redirect(string $url): void
        {
            header("Location: {$url}");
            exit;
        }
    }