<?php

    declare(strict_types=1);

    use FastRoute\RouteCollector;
    use App\Controller\SalleController;
    use App\Controller\ReservationController;
    use App\Controller\AuthController;
    use App\Routing\RouteDefinition;
    use App\Security\Role;

    return function (RouteCollector $r) {
        $r->addRoute('GET', '/login', RouteDefinition::publique([AuthController::class, 'showLogin']));
        $r->addRoute('POST', '/login', RouteDefinition::publique([AuthController::class, 'login']));
        $r->addRoute('POST', '/logout', RouteDefinition::authentifiee([AuthController::class, 'logout']));

        $r->addRoute('GET', '/', RouteDefinition::authentifiee([SalleController::class, 'index']));

        $r->addRoute('GET', '/salle', RouteDefinition::authentifiee([SalleController::class, 'index']));
        $r->addRoute('GET', '/salle/create', RouteDefinition::protegee([SalleController::class, 'create'], Role::ADMIN));
        $r->addRoute('POST', '/salle', RouteDefinition::protegee([SalleController::class, 'store'], Role::ADMIN));
        $r->addRoute('GET', '/salle/{id:\d+}', RouteDefinition::authentifiee([SalleController::class, 'show']));
        $r->addRoute('GET', '/salle/{id:\d+}/edit', RouteDefinition::protegee([SalleController::class, 'edit'], Role::ADMIN));
        $r->addRoute('POST', '/salle/{id:\d+}/edit', RouteDefinition::protegee([SalleController::class, 'update'], Role::ADMIN));

        $r->addRoute('GET', '/reservation', RouteDefinition::authentifiee([ReservationController::class, 'index']));
        $r->addRoute('GET', '/reservation/create', RouteDefinition::protegee([ReservationController::class, 'create'], Role::RESPONSABLE));
        $r->addRoute('POST', '/reservation', RouteDefinition::protegee([ReservationController::class, 'store'], Role::RESPONSABLE));
        $r->addRoute('GET', '/reservation/{id:\d+}', RouteDefinition::authentifiee([ReservationController::class, 'show']));
        $r->addRoute('POST', '/reservation/{id:\d+}/cancel', RouteDefinition::authentifiee([ReservationController::class, 'cancel']));
    };