<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\DTO\CreerSalleDTOBuilder;
    use App\Service\ConsulterSalleService;
    use App\Service\CreerSalleService;
    use App\Service\ListerSallesService;
    use App\Validator\SalleValidator;
    use App\View\View;

    final class SalleController
    {
        public function __construct(
            private readonly SalleValidator $salleValidator,
            private readonly CreerSalleService $creerSalleService,
            private readonly ListerSallesService $listerSallesService,
            private readonly ConsulterSalleService $consulterSalleService
        ) {
        }

        public function index(): void
        {
            $salles = $this->listerSallesService->executer();

            View::render('salle/index', ['salles' => $salles]);
        }

        public function show(array $vars): void
        {
            $id = (int) $vars['id'];
            $salle = $this->consulterSalleService->executer($id);

            if ($salle === null) {
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
            
            $errors = $this->salleValidator->validate($data);

            if (!empty($errors)) {
                View::render('salle/form', [
                    'errors' => $errors,
                    'old' => $data
                ]);
                return;
            }

            $dto = (new CreerSalleDTOBuilder())
                ->fromArray($data)
                ->build();

            $this->creerSalleService->executer($dto);

            header('Location: /salles');
            exit;
        }

        public function edit(array $vars): void
        {
            $id = (int) $vars['id'];
            $salle = $this->consulterSalleService->executer($id);

            if ($salle === null) {
                http_response_code(404);
                View::render('error/404');
                return;
            }

            View::render('salle/form', [
                'salle' => $salle,
                'errors' => [],
                'old' => $salle
            ]);
        }

        public function update(array $vars): void
        {
        }
    }