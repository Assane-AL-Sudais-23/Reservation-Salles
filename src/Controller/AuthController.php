<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\Exception\IdentifiantsInvalidesException;
    use App\Security\AuthService;
    use App\Validator\AuthValidator;
    use App\View\View;

    final class AuthController extends AbstractController
    {
        public function __construct(
            private readonly AuthService $authService,
            private readonly AuthValidator $authValidator,
            View $view
        ) {
            parent::__construct($view);
        }

        public function showLogin(): void
        {
            if ($this->authService->estConnecte()) {
                $this->redirect('/');
            }

            $this->render('auth/login', ['errors' => [], 'old' => []]);
        }

        public function login(): void
        {
            $this->traiterFormulaire(
                validator: $this->authValidator,
                data: $_POST,
                template: 'auth/login',
                persister: function (array $donneesValidees): void {
                    $connecte = $this->authService->tenterConnexion(
                        $donneesValidees['email'],
                        $donneesValidees['password']
                    );

                    if (!$connecte) {
                        throw new IdentifiantsInvalidesException('Email ou mot de passe incorrect.');
                    }
                },
                urlRedirection: '/'
            );
        }

        public function logout(): void
        {
            $this->authService->deconnecter();
            $this->redirect('/login');
        }
    }