<?php

    declare(strict_types=1);

    namespace App\DTO;

    use DateTimeImmutable;
    use InvalidArgumentException;

    final class CreerReservationDTOBuilder
    {
        private int $salleId = 0;
        private string $responsable = '';
        private string $email = '';
        private string $motif = '';
        private ?DateTimeImmutable $dateDebut = null;
        private ?DateTimeImmutable $dateFin = null;

        public function withSalleId(int $salleId): self
        {
            $this->salleId = $salleId;
            return $this;
        }

        public function withResponsable(string $responsable): self
        {
            $this->responsable = trim($responsable);
            return $this;
        }

        public function withEmail(string $email): self
        {
            $this->email = trim($email);
            return $this;
        }

        public function withMotif(string $motif): self
        {
            $this->motif = trim($motif);
            return $this;
        }

        public function withDateDebut(DateTimeImmutable|string $dateDebut): self
        {
            $this->dateDebut = is_string($dateDebut) 
                ? new DateTimeImmutable($dateDebut) 
                : $dateDebut;

            return $this;
        }

        public function withDateFin(DateTimeImmutable|string $dateFin): self
        {
            $this->dateFin = is_string($dateFin) 
                ? new DateTimeImmutable($dateFin) 
                : $dateFin;

            return $this;
        }

        public function fromArray(array $data): self
        {
            $this->salleId = (int)($data['salle_id'] ?? 0);
            $this->responsable = trim((string)($data['responsable'] ?? ''));
            $this->email = trim((string)($data['email'] ?? ''));
            $this->motif = trim((string)($data['motif'] ?? ''));

            $debutRaw = (string)($data['date_debut'] ?? 'now');
            $finRaw = (string)($data['date_fin'] ?? 'now');

            $this->dateDebut = new DateTimeImmutable($debutRaw);
            $this->dateFin = new DateTimeImmutable($finRaw);

            return $this;
        }

        public function build(): CreerReservationDTO
        {
            if ($this->dateDebut === null || $this->dateFin === null) {
                throw new InvalidArgumentException("Les dates de début et de fin doivent être définies.");
            }

            return new CreerReservationDTO(
                salleId: $this->salleId,
                responsable: $this->responsable,
                email: $this->email,
                motif: $this->motif,
                dateDebut: $this->dateDebut,
                dateFin: $this->dateFin
            );
        }
    }