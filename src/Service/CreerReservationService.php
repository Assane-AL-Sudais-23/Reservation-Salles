<?php

    declare(strict_types=1);

    namespace App\Service;

    use App\DTO\CreerReservationDTO;
    use App\Model\Reservation;
    use App\Repository\SalleRepositoryInterface;
    use App\Repository\ReservationRepositoryInterface;
    use App\Exception\SalleIndisponibleException;
    use App\Exception\RegleMetierException;

    class CreerReservationService
    {
        private const DUREE_MAX_HEURES = 4;

        public function __construct(
            private readonly SalleRepositoryInterface $salleRepository,
            private readonly ReservationRepositoryInterface $reservationRepository
        ) {
        }

        public function executer(CreerReservationDTO $dto): Reservation
        {
            $salle = $this->salleRepository->retrouverSalleParId($dto->salleId);
            
            $this->salleDoitExisterEtEtreActive($salle, $dto->salleId);
            $this->validerReglesHoraires($dto->dateDebut, $dto->dateFin);
            $this->verifierAbsenceDeConflit($dto);

            return $this->reservationRepository->enregistrerReservation($dto);
        }


        private function salleDoitExisterEtEtreActive(?object $salle, int $salleId): void
        {
            match (true) {
                $salle === null => throw new SalleIndisponibleException("La salle ID {$salleId} n'existe pas."),
                isset($salle->active) && !$salle->active => throw new SalleIndisponibleException("La salle '{$salle->nom}' est désactivée."),
                default => null,
            };
        }

    
        private function validerReglesHoraires(\DateTimeImmutable $debut, \DateTimeImmutable $fin): void
        {
            $maintenant = new \DateTimeImmutable();
            $dureeEnHeures = ($fin->getTimestamp() - $debut->getTimestamp()) / 3600;

            match (true) {
                $debut <= $maintenant => throw new RegleMetierException("La date de début doit être dans le futur."),
                $debut >= $fin => throw new RegleMetierException("La date de début doit précéder la date de fin."),
                $dureeEnHeures > self::DUREE_MAX_HEURES => throw new RegleMetierException("La durée ne peut dépasser " . self::DUREE_MAX_HEURES . "h."),
                default => null,
            };
        }


        private function verifierAbsenceDeConflit(CreerReservationDTO $dto): void
        {
            $conflit = $this->reservationRepository->rechercherConflit(
                $dto->salleId,
                $dto->dateDebut,
                $dto->dateFin
            );

            if ($conflit !== null) {
                throw new SalleIndisponibleException("La salle est déjà réservée sur ce créneau.");
            }
        }
    }