<?php
declare(strict_types=1);

    namespace App\View;

    use App\Security\AuthService;

    class View
    {
        public function __construct(
            private readonly AuthService $authService
        ) {
        }

        public function render(string $template, array $data = []): void
        {
            $data['utilisateurConnecte'] = $this->authService->utilisateurConnecte();

            extract($data);
            $content = dirname(__DIR__, 2) . "/templates/{$template}.php";
            require dirname(__DIR__, 2) . '/templates/layout/base.php';
        }
    }

    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }