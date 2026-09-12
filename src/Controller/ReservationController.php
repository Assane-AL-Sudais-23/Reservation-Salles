<?php
declare(strict_types=1);

    namespace App\Controller;

    use App\DTO\CreerReservationDTOBuilder;
    use App\Exception\ExceptionMetier;
    use App\Security\AuthService;
    use App\Service\ReservationService;
    use App\Service\SalleService;
    use App\Validator\ReservationValidator;
    use App\Controller\AbstractController;
    use App\View\View;

    final class ReservationController extends AbstractController
    {
        public function __construct(
            private readonly ReservationService $reservationService,
            private readonly SalleService $salleService,
            private readonly ReservationValidator $reservationValidator,
            private readonly AuthService $authService,
            View $view
        ) {
            parent::__construct($view);
        }

        public function index(): void
        {
            $reservations = $this->reservationService->listerReservation();
            parent::render('reservation/index', ['reservations' => $reservations]);
        }

        public function show(array $vars): void
        {
            $id = (int)$vars['id'];
            $reservation = $this->reservationService->retrouverReservation($id);

            if (!$reservation) {
                http_response_code(404);
                parent::render('error/404');
                return;
            }

            parent::render('reservation/show', ['reservation' => $reservation]);
        }

        public function create(): void
        {
            $salles = $this->salleService->listeSalles();
            parent::render('reservation/form', [
                'salles' => $salles,
                'errors' => [],
                'old' => []
            ]);
        }

        public function store(): void
        {
            $this->traiterFormulaire(
                validator: $this->reservationValidator,
                data: $_POST,
                template: 'reservation/form',
                persister: function (array $donneesValidees): void {
                    $dto = (new CreerReservationDTOBuilder())
                        ->fromArray($donneesValidees)
                        ->build();

                    $userId = $this->authService->utilisateurConnecte()?->id;
                    $this->reservationService->enregistrerReservation($dto, $userId);
                },
                urlRedirection: '/reservation',
                donneesSupplementaires: ['salles' => $this->salleService->listeSalles()]
            );
        }

        public function cancel(array $vars): void
        {
            $id = (int)$vars['id'];

            try {
                $this->reservationService->annulerReservation($id);
            } catch (ExceptionMetier $e) {
                http_response_code(404);
                $this->render('error/404', ['message' => $e->getMessage()]);
                return;
            }

            $this->redirect('/reservation');
        }
    }