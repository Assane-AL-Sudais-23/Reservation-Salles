<?php
declare(strict_types=1);

    namespace App\Controller;

    use App\DTO\CreerReservationDTOBuilder;
    use App\Exception\RegleMetierException;
    use App\Exception\SalleIndisponibleException;
    use App\Service\ReservationService;
    use App\Validator\ReservationValidator;
    use App\Controller\AbstractController;

    final class ReservationController extends AbstractController
    {
        public function __construct(
            private readonly ReservationService $reservationService,
            private readonly ReservationValidator $reservationValidator
        ) {
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
            $salles = $this->reservationService->listerSalles();
            parent::render('reservation/form', [
                'salles' => $salles,
                'errors' => [],
                'old' => []
            ]);
        }

        public function store(): void
        {
            $data = $_POST;
            $validation = $this->reservationValidator->validate($data);

            if (!$validation->isValid()) {
                $salles = $this->reservationService->listerSalles();
                parent::render('reservation/form', [
                    'salles' => $salles,
                    'errors' => $validation->errors(),
                    'old' => $data
                ]);
                return;
            }

            try {
                $dto = (new CreerReservationDTOBuilder())
                    ->fromArray($validation->data())
                    ->build();

                $this->reservationService->enregistrerReservation($dto);

                header('Location: /reservations');
                exit;
            } catch (SalleIndisponibleException | RegleMetierException $e) {
                $salles = $this->reservationService->listerSalles();
                parent::render('reservation/form', [
                    'salles' => $salles,
                    'errors' => ['global' => $e->getMessage()],
                    'old' => $data
                ]);
            }
        }

        public function cancel(array $vars): void
        {
            $id = (int)$vars['id'];
            $this->reservationService->annulerReservation($id);

            header('Location: /reservations');
            exit;
        }
    }