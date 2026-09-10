<?php
    declare(strict_types=1);

    namespace App\DTO;

    use DateTimeImmutable;

    class CreerReservationDTOBuilder
    {
        private int $salleId = 0;
        private string $responsable = '';
        private string $email = '';
        private string $motif = '';
        private ?DateTimeImmutable $dateDebut = null;
        private ?DateTimeImmutable $dateFin = null;

        public function fromArray(array $data): self
        {
            $this->salleId = (int)($data['salle_id'] ?? 0);
            $this->responsable = (string)($data['responsable'] ?? '');
            $this->email = (string)($data['email'] ?? '');
            $this->motif = (string)($data['motif'] ?? '');
            
            if (!empty($data['date_debut'])) {
                $this->dateDebut = new DateTimeImmutable((string)$data['date_debut']);
            }
            
            if (!empty($data['date_fin'])) {
                $this->dateFin = new DateTimeImmutable((string)$data['date_fin']);
            }

            return $this;
        }

        public function setSalleId(int $salleId): self
        {
            $this->salleId = $salleId;
            return $this;
        }

        public function setResponsable(string $responsable): self
        {
            $this->responsable = $responsable;
            return $this;
        }

        public function setEmail(string $email): self
        {
            $this->email = $email;
            return $this;
        }

        public function setMotif(string $motif): self
        {
            $this->motif = $motif;
            return $this;
        }

        public function setDateDebut(DateTimeImmutable $dateDebut): self
        {
            $this->dateDebut = $dateDebut;
            return $this;
        }

        public function setDateFin(DateTimeImmutable $dateFin): self
        {
            $this->dateFin = $dateFin;
            return $this;
        }

        public function build(): CreerReservationDTO
        {
            return new CreerReservationDTO(
                salleId: $this->salleId,
                responsable: $this->responsable,
                email: $this->email,
                motif: $this->motif,
                dateDebut: $this->dateDebut ?? new DateTimeImmutable(),
                dateFin: $this->dateFin ?? new DateTimeImmutable()
            );
        }
    }