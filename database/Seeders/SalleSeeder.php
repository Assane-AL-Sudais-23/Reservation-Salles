<?php
namespace Database\Seeders;

    use App\Model\Salle;
    use Database\SeederInterface;

    class SalleSeeder implements SeederInterface
    {
        public function run(): void
        {
            $salles = [
                [
                    'nom' => 'Amphithéâtre A',
                    'capacite' => 250,
                    'description' => 'Grand amphithéâtre pour cours magistraux et conférences.'
                ],
                [
                    'nom' => 'Salle B12',
                    'capacite' => 40,
                    'description' => 'Salle de cours standard.'
                ],
                [
                    'nom' => 'Laboratoire Chimie',
                    'capacite' => 24,
                    'description' => 'Salle équipée pour travaux pratiques de chimie.'
                ],
                [
                    'nom' => 'Salle Informatique 1',
                    'capacite' => 30,
                    'description' => 'Salle équipée d’ordinateurs et d’un vidéoprojecteur.'
                ],
                [
                    'nom' => 'Salle de réunion',
                    'capacite' => 12,
                    'description' => 'Petite salle pour réunions d’équipe et soutenances.'
                ],
            ];

            foreach ($salles as $data) {
                Salle::updateOrCreate(
                    ['nom' => $data['nom']],
                    [
                        'capacite' => $data['capacite'],
                        'description' => $data['description']
                    ]
                );
            }
        }
    }