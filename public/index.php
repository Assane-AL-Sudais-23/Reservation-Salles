<?php

    declare(strict_types=1);
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $db = require_once __DIR__ . '/../config/database.php';

    echo "<h1>Connexion à la base de données réussie </h1>";

    use App\View\View;
    use FastRoute\Dispatcher;
    use function FastRoute\simpleDispatcher;

    require_once __DIR__ . '/../vendor/autoload.php';

    $container = require __DIR__ . '/../config/container.php';

    require __DIR__ . '/../config/database.php';

    $routesDefiner = require __DIR__ . '/../routes/web.php';
    $dispatcher = simpleDispatcher($routesDefiner);

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

    switch ($routeInfo[0]) {
        case Dispatcher::NOT_FOUND:
            http_response_code(404);
            View::render('error/404');
            break;

        case Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            http_response_code(405);
            header('Allow: ' . implode(', ', $allowedMethods));
            View::render('error/405');
            break;

        case Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];

            [$controllerClass, $method] = $handler;
            
            $controller = $container->get($controllerClass);

            $controller->$method($vars);
            break;
    }