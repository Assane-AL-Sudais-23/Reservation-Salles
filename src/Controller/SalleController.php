<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\DTO\CreerSalleDTOBuilder;
    use App\Service\SalleService;
    use App\Validator\SalleValidator;

    final class SalleController extends AbstractController
    {
        public function __construct(
            private readonly SalleService $salleService,
            private readonly SalleValidator $salleValidator
        ) {
        }

        public function index(): void
        {
            $salles = $this->salleService->listeSalles();
            parent::render('salles/index', ['salles' => $salles]);
        }

        public function show(array $vars): void
        {
            $id = (int) ($vars['id'] ?? 0);
            $salle = $this->salleService->retrouverSalle($id);

            if ($salle === null) {
                parent::render('errors/404', ['message' => 'Salle introuvable']);
                return;
            }

            $this->render('salles/show', ['salle' => $salle]);
        }

        public function create(): void
        {
            parent::render('salles/create');
        }

        public function store(): void
        {
            $data = $_POST;
            $erreurs = $this->salleValidator->validate($data);

            if (!empty($erreurs)) {
                $this->render('salles/create', [
                    'erreurs' => $erreurs,
                    'champs' => $data
                ]);
                return;
            }

            $dto = (new CreerSalleDTOBuilder())->fromArray($data)->build();
            $this->salleService->enregistrerSalle($dto);

            $this->redirect('/salles');
        }

        public function edit(array $vars): void
        {
            $id = (int) ($vars['id'] ?? 0);
            $salle = $this->salleService->retrouverSalle($id);

            if ($salle === null) {
                $this->render('errors/404', ['message' => 'Salle introuvable']);
                return;
            }

            parent::render('salles/edit', ['salle' => $salle]);
        }

        public function update(array $vars): void
        {
            $id = (int) ($vars['id'] ?? 0);
            $data = $_POST;
            $this->redirect('/salles/' . $id);
        }
    }