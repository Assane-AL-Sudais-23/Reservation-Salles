<?php

    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $db = require_once __DIR__ . '/../config/database.php';

    echo "<h1>Connexion à la base de données réussie </h1>";