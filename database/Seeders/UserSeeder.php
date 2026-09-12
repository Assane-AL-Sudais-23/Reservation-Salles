<?php
namespace Database\Seeders;

    use App\Model\User;
    use Database\SeederInterface;

    class UserSeeder implements SeederInterface
    {
        public function run(): void
        {
            $users = [
                [
                    'nom' => 'Admin Principal',
                    'email' => 'admin@universite.fr',
                    'password' => 'admin1234',
                    'role' => 'admin',
                ],
                [
                    'nom' => 'Fatou Diop',
                    'email' => 'fatou.diop@universite.fr',
                    'password' => 'responsable1234',
                    'role' => 'responsable',
                ],
                [
                    'nom' => 'Moussa Ndiaye',
                    'email' => 'moussa.ndiaye@universite.fr',
                    'password' => 'responsable1234',
                    'role' => 'responsable',
                ],
            ];

            foreach ($users as $data) {
                User::updateOrCreate(
                    ['email' => $data['email']],
                    [
                        'nom' => $data['nom'],
                        'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                        'role' => $data['role'],
                    ]
                );
            }

            echo "Comptes de démonstration créés (mots de passe : admin1234 / responsable1234).\n";
        }
    }