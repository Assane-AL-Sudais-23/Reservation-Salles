<?php
declare(strict_types=1);

    namespace App\Controller;

    use App\DTO\CreerSalleDTOBuilder;
    use App\Repository\SalleRepositoryInterface;
    use App\Validator\SalleValidator;
    use App\View\View;

    final class SalleController
    {
        public function __construct(
            private readonly SalleRepositoryInterface $salleRepository,
            private readonly SalleValidator $salleValidator
        ) {
        }

        public function index(): void
        {
            $salles = $this->salleRepository->listerSalles();
            View::render('salle/index', ['salles' => $salles]);
        }

        public function show(array $vars): void
        {
            $id = (int)$vars['id'];
            $salle = $this->salleRepository->retrouverSalleParId($id);

            if (!$salle) {
                http_response_code(404);
                View::render('error/404');
                return;
            }

            View::render('salle/show', ['salle' => $salle]);
        }

        public function create(): void
        {
            View::render('salle/form', ['errors' => [], 'old' => []]);
        }

        public function store(): void
        {
            $data = $_POST;
            $validation = $this->salleValidator->validate($data);

            if (!$validation->isValid()) {
                View::render('salle/form', [
                    'errors' => $validation->errors(),
                    'old' => $data
                ]);
                return;
            }

            $dto = (new CreerSalleDTOBuilder())
                ->fromArray($validation->data())
                ->build();

            $this->salleRepository->enregistrerSalle($dto);

            header('Location: /salles');
            exit;
        }

        public function edit(array $vars): void
        {
            $id = (int)$vars['id'];
            $salle = $this->salleRepository->retrouverSalleParId($id);

            if (!$salle) {
                http_response_code(404);
                View::render('error/404');
                return;
            }

            View::render('salle/form', [
                'salle' => $salle,
                'errors' => [],
                'old' => $salle->toArray()
            ]);
        }

        public function update(array $vars): void
        {
        }
    }