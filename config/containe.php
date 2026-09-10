<?php
declare(strict_types=1);

    use function DI\autowire;
    use function DI\factory;

    use Illuminate\Database\Capsule\Manager as Capsule;
    use FastRoute\Dispatcher;
    use function FastRoute\simpleDispatcher;

    use App\Repository\SalleRepositoryInterface;
    use App\Repository\Eloquent\SalleRepository as EloquentSalleRepository;
    use App\Repository\ReservationRepositoryInterface;
    use App\Repository\Eloquent\ReservationRepository as EloquentReservationRepository;

    use App\Service\CreerReservationService;
    use App\Service\AnnulerReservationService;
    use App\Validator\SalleValidator;
    use App\Validator\ReservationValidator;

    use App\Controller\SalleController;
    use App\Controller\ReservationController;
    use App\Application;

    return [
        Capsule::class => factory(require __DIR__ . '/database.php'),

        Dispatcher::class => factory(function (): Dispatcher {
            $routesDefiner = require dirname(__DIR__) . '/routes/web.php';
            return simpleDispatcher($routesDefiner);
        }),

        SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
        ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),

        SalleValidator::class => autowire(SalleValidator::class),
        ReservationValidator::class => autowire(ReservationValidator::class),
        CreerReservationService::class => autowire(CreerReservationService::class),
        AnnulerReservationService::class => autowire(AnnulerReservationService::class),

        SalleController::class => autowire(SalleController::class),
        ReservationController::class => autowire(ReservationController::class),

        Application::class => autowire(Application::class),
    ];