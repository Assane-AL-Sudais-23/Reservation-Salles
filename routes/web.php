<?php

    declare(strict_types=1);

    use FastRoute\RouteCollector;
    use App\Controller\SalleController;
    use App\Controller\ReservationController;

    return function (RouteCollector $r) {
        $r->addRoute('GET', '/', [SalleController::class, 'index']);

        $r->addRoute('GET', '/salle', [SalleController::class, 'index']);
        $r->addRoute('GET', '/salle/create', [SalleController::class, 'create']);
        $r->addRoute('POST', '/salle', [SalleController::class, 'store']);
        $r->addRoute('GET', '/salle/{id:\d+}', [SalleController::class, 'show']);
        $r->addRoute('GET', '/salle/{id:\d+}/edit', [SalleController::class, 'edit']);
        $r->addRoute('POST', '/salle/{id:\d+}/edit', [SalleController::class, 'update']);

        $r->addRoute('GET', '/reservation', [ReservationController::class, 'index']);
        $r->addRoute('GET', '/reservation/create', [ReservationController::class, 'create']);
        $r->addRoute('POST', '/reservation', [ReservationController::class, 'store']);
        $r->addRoute('GET', '/reservation/{id:\d+}', [ReservationController::class, 'show']);
        $r->addRoute('POST', '/reservation/{id:\d+}/cancel', [ReservationController::class, 'cancel']);
    };