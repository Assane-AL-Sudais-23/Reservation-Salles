<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\View\View;
    use App\Validator\ValidatorInterface;
    use App\Exception\ExceptionMetier;

    abstract class AbstractController
    {
        public function __construct(
            protected readonly View $view
        ) {
        }

        protected function render(string $template, array $data = []): void
        {
            $this->view->render($template, $data);
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

        protected function traiterFormulaire(
            ValidatorInterface $validator,
            array $data,
            string $template,
            callable $persister,
            string $urlRedirection,
            array $donneesSupplementaires = []
        ): void {
            $validation = $validator->validate($data);
 
            if (!$validation->isValid()) {
                $this->render($template, array_merge($donneesSupplementaires, [
                    'errors' => $validation->errors(),
                    'old'    => $data,
                ]));
                return;
            }
 
            try {
                $persister($validation->data());
                $this->redirect($urlRedirection);
            } catch (ExceptionMetier $e) {
                $this->render($template, array_merge($donneesSupplementaires, [
                    'errors' => ['global' => $e->getMessage()],
                    'old'    => $data,
                ]));
            }
        }
    }