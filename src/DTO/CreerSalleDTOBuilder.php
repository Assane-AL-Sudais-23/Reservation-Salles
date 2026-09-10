<?php
    declare(strict_types=1);

    namespace App\DTO;

    class CreerSalleDTOBuilder
    {
        private string $nom = '';
        private string $batiment = '';
        private int $capacite = 0;
        private string $type = '';
        private bool $active = true;

        public function fromArray(array $data): self
        {
            $this->nom = (string)($data['nom'] ?? '');
            $this->batiment = (string)($data['batiment'] ?? '');
            $this->capacite = (int)($data['capacite'] ?? 0);
            $this->type = (string)($data['type'] ?? '');
            $this->active = isset($data['active']) ? (bool)$data['active'] : true;

            return $this;
        }

        public function setNom(string $nom): self
        {
            $this->nom = $nom;
            return $this;
        }

        public function setBatiment(string $batiment): self
        {
            $this->batiment = $batiment;
            return $this;
        }

        public function setCapacite(int $capacite): self
        {
            $this->capacite = $capacite;
            return $this;
        }

        public function setType(string $type): self
        {
            $this->type = $type;
            return $this;
        }

        public function setActive(bool $active): self
        {
            $this->active = $active;
            return $this;
        }

        public function build(): CreerSalleDTO
        {
            return new CreerSalleDTO(
                nom: $this->nom,
                batiment: $this->batiment,
                capacite: $this->capacite,
                type: $this->type,
                active: $this->active
            );
        }
    }