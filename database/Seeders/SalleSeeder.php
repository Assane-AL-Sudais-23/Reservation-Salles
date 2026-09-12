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
                    'batiment' => 'Bâtiment Principal',
                    'capacite' => 250,
                    'type' => 'amphi',
                    'active' => true,
                ],
                [
                    'nom' => 'Salle B12',
                    'batiment' => 'Bâtiment B',
                    'capacite' => 40,
                    'type' => 'standard',
                    'active' => true,
                ],
                [
                    'nom' => 'Laboratoire Chimie',
                    'batiment' => 'Bâtiment Sciences',
                    'capacite' => 24,
                    'type' => 'tp',
                    'active' => true,
                ],
                [
                    'nom' => 'Salle Informatique 1',
                    'batiment' => 'Bâtiment Sciences',
                    'capacite' => 30,
                    'type' => 'tp',
                    'active' => true,
                ],
                [
                    'nom' => 'Salle de réunion',
                    'batiment' => 'Bâtiment Administratif',
                    'capacite' => 12,
                    'type' => 'reunion',
                    'active' => true,
                ],
            ];

            foreach ($salles as $data) {
                Salle::updateOrCreate(
                    ['nom' => $data['nom']],
                    [
                        'batiment' => $data['batiment'],
                        'capacite' => $data['capacite'],
                        'type' => $data['type'],
                        'active' => $data['active'],
                    ]
                );
            }
        }
    }