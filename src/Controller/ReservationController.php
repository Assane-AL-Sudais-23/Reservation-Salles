<?php

    declare(strict_types=1);

    namespace App\Controller;

    use App\DTO\CreerReservationDTOBuilder;
    use App\Exception\RegleMetierException;
    use App\Exception\SalleIndisponibleException;
    use App\Repository\ReservationRepositoryInterface;
    use App\Repository\SalleRepositoryInterface;
    use App\Service\AnnulerReservationService;
    use App\Service\CreerReservationService;
    use App\Validator\ReservationValidator;
    use App\View\View;

    final class ReservationController
    {
        public function __construct(
            private readonly ReservationRepositoryInterface $reservationRepository,
            private readonly SalleRepositoryInterface $salleRepository,
            private readonly ReservationValidator $reservationValidator,
            private readonly CreerReservationService $creerReservationService,
            private readonly AnnulerReservationService $annulerReservationService
        ) {
        }

        public function index(): void
        {
            $reservations = $this->reservationRepository->listerReservations();
            View::render('reservation/index', ['reservations' => $reservations]);
        }

        public function show(array $vars): void
        {
            $id = (int)$vars['id'];
            $reservation = $this->reservationRepository->retrouverReservationParId($id);

            if (!$reservation) {
                http_response_code(404);
                View::render('error/404');
                return;
            }

            View::render('reservation/show', ['reservation' => $reservation]);
        }

        public function create(): void
        {
            $salles = $this->salleRepository->listerSalles();
            View::render('reservation/form', [
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
                $salles = $this->salleRepository->listerSalles();
                View::render('reservation/form', [
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

                $this->creerReservationService->executer($dto);

                header('Location: /reservations');
                exit;
            } catch (SalleIndisponibleException | RegleMetierException $e) {
                $salles = $this->salleRepository->listerSalles();
                View::render('reservation/form', [
                    'salles' => $salles,
                    'errors' => ['global' => $e->getMessage()],
                    'old' => $data
                ]);
            }
        }

        public function cancel(array $vars): void
        {
            $id = (int)$vars['id'];
            $this->annulerReservationService->executer($id);

            header('Location: /reservations');
            exit;
        }
    }