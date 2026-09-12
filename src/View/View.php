<?php
declare(strict_types=1);

    namespace App\View;

    class View
    {

        public function render(string $template, array $data = []): void
        {
            extract($data);
            $content = __DIR__ . "/../../templates/{$template}.php";
            require __DIR__ . '/../../templates/layout/base.php';
        }
    }

    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }