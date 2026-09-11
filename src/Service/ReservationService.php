<?php 
    declare(strict_types=1);

    namespace App\Service;

    use App\Repository\ReservationRepositoryInterface;
    use App\Exception\ReservationIntrouvableException;
    use App\Model\Reservation;
    use App\DTO\CreerReservationDTO;
    use App\DTO\ReservationDTOBuilder;
    use App\Exception\RegleMetierException;
    use App\Repository\SalleRepositoryInterface;
    use Illuminate\Support\Collection;
    use App\Exception\SalleIndisponibleException;
    use App\Model\Salle;


    class ReservationService {

        private const DUREE_MAX_HEURES = 4;

        public function __construct(
            private readonly ReservationRepositoryInterface $reservationRepository,
            private readonly SalleRepositoryInterface $salleRepository

        ){}

        public function annulerReservation(int $reservationId): bool
        {
            $reservation = $this->reservationRepository->retrouverReservationParId($reservationId);

            if (!$reservation) {
                throw new ReservationIntrouvableException("La réservation #{$reservationId} est introuvable.");
            }

            return $this->reservationRepository->annulerReservation($reservationId);
        }

        public function listerReservation(): Collection {
            $reservationEntities = $this->reservationRepository->listerReservations();
            return ReservationDTOBuilder::fromEntities($reservationEntities);
        }

        public function retrouverReservation(int $id): ?Reservation {
            return $this->reservationRepository->retrouverReservationParId($id);
        }

        public function listerSalles(): Collection {
            return $this->salleRepository->listerSalles();
        }

        public function enregistrerReservation(CreerReservationDTO $dto): Reservation
        {
            $salle = $this->salleRepository->retrouverSalleParId($dto->salleId);

            $this->validerExistenceEtStatutSalle($salle, $dto->salleId);
            $this->validerDateDebutFuture($dto->dateDebut);
            $this->validerChronologieDates($dto->dateDebut, $dto->dateFin);
            $this->validerDureeMaximales($dto->dateDebut, $dto->dateFin);
            $this->verifierAbsenceDeConflit($dto->salleId, $dto->dateDebut, $dto->dateFin);

            $reservation = new Reservation();
            $reservation->salle_id = $dto->salleId;
            $reservation->nom_client = $dto->responsable;
            $reservation->email = $dto->email;
            $reservation->motif = $dto->motif;
            $reservation->date_debut = $dto->dateDebut;
            $reservation->date_fin = $dto->dateFin;

            return $this->reservationRepository->enregistrerReservation($reservation);
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

        private function validerDateDebutFuture(\DateTimeImmutable $debut): void
        {
            if ($debut <= new \DateTimeImmutable()) {
                throw new RegleMetierException("La date de début doit être dans le futur.");
            }
        }

        private function validerChronologieDates(\DateTimeImmutable $debut, \DateTimeImmutable $fin): void
        {
            if ($debut >= $fin) {
                throw new RegleMetierException("La date de début doit précéder la date de fin.");
            }
        }

        private function validerDureeMaximales(\DateTimeImmutable $debut, \DateTimeImmutable $fin): void
        {
            $dureeEnHeures = ($fin->getTimestamp() - $debut->getTimestamp()) / 3600;

            if ($dureeEnHeures > self::DUREE_MAX_HEURES) {
                throw new RegleMetierException("La durée ne peut dépasser " . self::DUREE_MAX_HEURES . " heures.");
            }
        }

        private function verifierAbsenceDeConflit(int $salleId, \DateTimeImmutable $debut, \DateTimeImmutable $fin): void
        {
            $conflit = $this->reservationRepository->rechercherConflit(
                $salleId,
                $debut,
                $fin
            );

            if ($conflit !== null) {
                throw new SalleIndisponibleException("La salle est déjà réservée sur ce créneau.");
            }
        }
    }