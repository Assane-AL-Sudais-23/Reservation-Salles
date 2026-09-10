<?php
declare(strict_types=1);

    use Illuminate\Database\Capsule\Manager as Capsule;

    $capsule = new Capsule();

    $capsule->addConnection([
        'driver'    => $_ENV['DB_DRIVER'] ?? 'pgsql',
        'host'      => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'port'      => $_ENV['DB_PORT'] ?? '5432',
        'database'  => $_ENV['DB_DATABASE'] ?? 'store_manager_pro',
        'username'  => $_ENV['DB_USERNAME'] ?? 'postgres',
        'password'  => $_ENV['DB_PASSWORD'] ?? 'postgres',
        'charset'   => 'utf8',
        'prefix'    => '',
        'schema'    => 'public',
        'sslmode'   => 'prefer',
    ]);

    $capsule->setAsGlobal();

    $capsule->bootEloquent();

    return $capsule;