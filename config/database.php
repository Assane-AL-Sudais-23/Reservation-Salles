<?php
    declare(strict_types=1);

    use Illuminate\Database\Capsule\Manager as Capsule;

    $capsule = new Capsule();
    $connectionOptions = [];

    if (defined('PDO::MYSQL_ATTR_SSL_CA')) {
        $connectionOptions[PDO::MYSQL_ATTR_SSL_CA] = true;
        $connectionOptions[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
    }

    $capsule->addConnection([
        'driver'    => getenv('DB_DRIVER') ?: ($_ENV['DB_DRIVER'] ?? 'mysql'),
        'host'      => getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'db'),
        'port'      => (int)(getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? 3306)),
        'database'  => getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? 'reservation_db'),
        'username'  => getenv('DB_USERNAME') ?: ($_ENV['DB_USERNAME'] ?? 'root'),
        'password'  => getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? 'root'),
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
        'options'   => $connectionOptions,
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
