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
        $this->render('salle/index', ['salles' => $salles]);
    }

    public function show(array $vars): void
    {
        $id = (int) ($vars['id'] ?? 0);
        $salle = $this->salleService->retrouverSalle($id);

        if ($salle === null) {
            $this->render('error/404', ['message' => 'Salle introuvable']);
            return;
        }

        $this->render('salle/show', ['salle' => $salle]);
    }

    public function create(): void
    {
        $this->render('salle/form');
    }

    public function store(): void
    {
        $data = $_POST;
        $errors = $this->salleValidator->validate($data);

        if (!empty($errors)) {
            $this->render('salle/form', [
                'errors' => $errors,
                'old'    => $data
            ]);
            return;
        }

        $dto = (new CreerSalleDTOBuilder())->fromArray($data)->build();
        $this->salleService->enregistrerSalle($dto);
        $this->redirect('/salle');
    }

    public function edit(array $vars): void
    {
        $id = (int) ($vars['id'] ?? 0);
        $salleDto = $this->salleService->retrouverSalle($id);

        if ($salleDto === null) {
            $this->render('error/404', ['message' => 'Salle introuvable']);
            return;
        }

        $this->render('salle/form', [
            'salle' => $salleDto
        ]);
    }

    public function update(array $vars): void {
        $id = (int) ($vars['id'] ?? 0);
        $data = $_POST;

        $this->redirect('/salle/' . $id);
    }
}