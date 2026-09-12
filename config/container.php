<?php
    declare(strict_types=1);

    use function DI\autowire;
    use function DI\factory;

    use Illuminate\Database\Capsule\Manager as Capsule;
    use FastRoute\Dispatcher;
    use function FastRoute\simpleDispatcher;

    use App\Repository\SalleRepositoryInterface;
    use App\Repository\SalleRepository;
    use App\Repository\ReservationRepositoryInterface;
    use App\Repository\ReservationRepository;
    use App\Repository\UserRepositoryInterface;
    use App\Repository\UserRepository;

    use App\Service\SalleService;
    use App\Service\ReservationService;
    use App\Security\AuthService;
    use App\Validator\SalleValidator;
    use App\Validator\ReservationValidator;
    use App\Validator\AuthValidator;

    use App\Controller\SalleController;
    use App\Controller\ReservationController;
    use App\Controller\AuthController;
    use App\View\View;
    use App\Application;

    $capsule = require __DIR__ . '/database.php';

    return [
        Capsule::class => $capsule,

        View::class => autowire(View::class),

        Dispatcher::class => factory(function (): Dispatcher {
            $routesDefiner = require dirname(__DIR__) . '/routes/web.php';
            return simpleDispatcher($routesDefiner);
        }),

        SalleRepositoryInterface::class => autowire(SalleRepository::class),
        ReservationRepositoryInterface::class => autowire(ReservationRepository::class),
        UserRepositoryInterface::class => autowire(UserRepository::class),

        SalleValidator::class => autowire(SalleValidator::class),
        ReservationValidator::class => autowire(ReservationValidator::class),
        AuthValidator::class => autowire(AuthValidator::class),
        SalleService::class => autowire(SalleService::class),
        ReservationService::class => autowire(ReservationService::class),
        AuthService::class => autowire(AuthService::class),

        SalleController::class => autowire(SalleController::class),
        ReservationController::class => autowire(ReservationController::class),
        AuthController::class => autowire(AuthController::class),

        Application::class => autowire(Application::class),
    ];