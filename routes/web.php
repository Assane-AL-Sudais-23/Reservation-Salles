<?php

    declare(strict_types=1);

    use FastRoute\RouteCollector;
    use App\Controller\SalleController;
    use App\Controller\ReservationController;
    use App\Controller\AuthController;
    use App\Routing\RouteDefinition;

    return function (RouteCollector $r) {
        $r->addRoute('GET', '/login', RouteDefinition::publique([AuthController::class, 'showLogin']));
        $r->addRoute('POST', '/login', RouteDefinition::publique([AuthController::class, 'login']));
        $r->addRoute('POST', '/logout', RouteDefinition::authentifiee([AuthController::class, 'logout']));

        $r->addRoute('GET', '/', RouteDefinition::publique([SalleController::class, 'index']));

        $r->addRoute('GET', '/salle', RouteDefinition::publique([SalleController::class, 'index']));
        $r->addRoute('GET', '/salle/create', RouteDefinition::publique([SalleController::class, 'create']));
        $r->addRoute('POST', '/salle', RouteDefinition::publique([SalleController::class, 'store']));
        $r->addRoute('GET', '/salle/{id:\d+}', RouteDefinition::publique([SalleController::class, 'show']));
        $r->addRoute('GET', '/salle/{id:\d+}/edit', RouteDefinition::publique([SalleController::class, 'edit']));
        $r->addRoute('POST', '/salle/{id:\d+}/edit', RouteDefinition::publique([SalleController::class, 'update']));

        $r->addRoute('GET', '/reservation', RouteDefinition::publique([ReservationController::class, 'index']));
        $r->addRoute('GET', '/reservation/create', RouteDefinition::publique([ReservationController::class, 'create']));
        $r->addRoute('POST', '/reservation', RouteDefinition::publique([ReservationController::class, 'store']));
        $r->addRoute('GET', '/reservation/{id:\d+}', RouteDefinition::publique([ReservationController::class, 'show']));
        $r->addRoute('POST', '/reservation/{id:\d+}/cancel', RouteDefinition::publique([ReservationController::class, 'cancel']));
    };