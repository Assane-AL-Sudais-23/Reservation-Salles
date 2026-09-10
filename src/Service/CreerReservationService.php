<?php

    declare(strict_types=1);

    namespace App\Service;

    use App\DTO\CreerReservationDTO;
    use App\Exception\RegleMetierException;
    use App\Exception\SalleIndisponibleException;
    use App\Model\Reservation;
    use App\Model\Salle;
    use App\Repository\ReservationRepositoryInterface;
    use App\Repository\SalleRepositoryInterface;
    use DateTimeImmutable;

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

            $this->validerExistenceEtStatutSalle($salle, $dto->salleId);
            $this->validerDateDebutFuture($dto->dateDebut);
            $this->validerChronologieDates($dto->dateDebut, $dto->dateFin);
            $this->validerDureeMaximales($dto->dateDebut, $dto->dateFin);
            $this->verifierAbsenceDeConflit($dto);

            return $this->reservationRepository->enregistrerReservation($dto);
        }

        private function validerExistenceEtStatutSalle(?Salle $salle, int $salleId): void
        {
            if ($salle === null) {
                throw new SalleIndisponibleException("La salle ID {$salleId} n'existe pas.");
            }

            if (isset($salle->active) && !$salle->active) {
                throw new SalleIndisponibleException("La salle '{$salle->nom}' est désactivée.");
            }
        }


        private function validerDateDebutFuture(DateTimeImmutable $debut): void
        {
            if ($debut <= new DateTimeImmutable()) {
                throw new RegleMetierException("La date de début doit être dans le futur.");
            }
        }


        private function validerChronologieDates(DateTimeImmutable $debut, DateTimeImmutable $fin): void
        {
            if ($debut >= $fin) {
                throw new RegleMetierException("La date de début doit précéder la date de fin.");
            }
        }


        private function validerDureeMaximales(DateTimeImmutable $debut, DateTimeImmutable $fin): void
        {
            $dureeEnHeures = ($fin->getTimestamp() - $debut->getTimestamp()) / 3600;

            if ($dureeEnHeures > self::DUREE_MAX_HEURES) {
                throw new RegleMetierException("La durée ne peut dépasser " . self::DUREE_MAX_HEURES . " heures.");
            }
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