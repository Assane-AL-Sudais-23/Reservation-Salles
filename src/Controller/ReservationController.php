<?php

    declare(strict_types=1);

    namespace App\Controller;

    use App\Repository\ReservationRepositoryInterface;
    use App\Repository\SalleRepositoryInterface;
    use App\Validator\ReservationValidator;
    use App\Service\CreerReservationService;
    use App\Service\AnnulerReservationService;
    use App\DTO\CreerReservationDTO;
    use App\Exception\SalleIndisponibleException;
    use App\Exception\RegleMetierException;
    use App\View\View;

    class ReservationController
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
            $reservation = $this->reservationRepository->retrouverReservationParId((int) $vars['id']);
            if (!$reservation) {
                View::render('error/404');
                return;
            }
            View::render('reservation/show', ['reservation' => $reservation]);
        }

        public function create(): void
        {
            $salles = $this->salleRepository->listerSalles();
            View::render('reservation/form', ['salles' => $salles, 'errors' => [], 'old' => []]);
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
                $dto = CreerReservationDTO::fromArray($validation->data());
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
            $this->annulerReservationService->executer((int) $vars['id']);
            header('Location: /reservations');
            exit;
        }
    }