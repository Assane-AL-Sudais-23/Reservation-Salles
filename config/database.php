<?php

    use Illuminate\Database\Capsule\Manager as Capsule;

    try {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver'    => $_ENV['DB_DRIVER'] ?? 'mysql',
            'host'      => $_ENV['DB_HOST'] ?? 'db',
            'port'      => $_ENV['DB_PORT'] ?? 3306,
            'database'  => $_ENV['DB_DATABASE'] ?? 'reservation_salles',
            'username'  => $_ENV['DB_USERNAME'] ?? 'root',
            'password'  => $_ENV['DB_PASSWORD'] ?? '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $capsule->getConnection()->getPdo();

        return $capsule;

    } catch (\PDOException $e) {
        error_log("Erreur de connexion à la base de données : " . $e->getMessage());
        
        http_response_code(500);
        die("Erreur critique : Impossible de se connecter à la base de données.");
    }