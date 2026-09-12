<?php
    declare(strict_types=1);

    namespace App;

        use App\Exception\ApplicationException;
        use App\Exception\EtatRoutageInvalideException;
    use App\Routing\RouteDefinition;
    use App\Security\AuthService;
    use App\View\View;
    use FastRoute\Dispatcher;
    use Invoker\InvokerInterface;
    use Throwable;

    final class Application
    {
        public function __construct(
            private readonly Dispatcher $dispatcher,
            private readonly InvokerInterface $invoker,
            private readonly View $view,
            private readonly AuthService $authService
        ) {
        }

        public function run(): void
        {
            try {
                $this->dispatchRequest();
            } catch (ApplicationException $exception) {
                $this->renderApplicationException($exception);
            } catch (Throwable $exception) {
                error_log((string) $exception);
                http_response_code(500);
                $this->view->render('error/500');
            }
        }

        private function dispatchRequest(): void
        {
            $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
            $uri = $_SERVER['REQUEST_URI'] ?? '/';

            if (false !== $pos = strpos($uri, '?')) {
                $uri = substr($uri, 0, $pos);
            }
            $uri = rawurldecode($uri);

            $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

            switch ($routeInfo[0]) {
                case Dispatcher::NOT_FOUND:
                    http_response_code(404);
                    $this->view->render('error/404');
                    break;

                case Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    http_response_code(405);
                    header('Allow: ' . implode(', ', $allowedMethods));
                    $this->view->render('error/405');
                    break;

                case Dispatcher::FOUND:
                    /** @var RouteDefinition $route */
                    $route = $routeInfo[1];
                    $vars = $routeInfo[2];

                    if (!$route->estAutorisePour($this->authService->role())) {
                        if (!$this->authService->estConnecte()) {
                            header('Location: /login');
                            exit;
                        }

                        http_response_code(403);
                        $this->view->render('error/403');
                        break;
                    }

                    $this->invoker->call($route->handler, [
                        'params' => $vars,
                        'vars'   => $vars,
                        ...$vars
                    ]);
                    break;

                default:
                    throw new EtatRoutageInvalideException();
            }
        }

        private function renderApplicationException(ApplicationException $exception): void
        {
            http_response_code($exception->getStatusCode());

            $template = match ($exception->getStatusCode()) {
                404 => 'error/404',
                422 => 'error/422',
                default => 'error/500',
            };

            $data = in_array($exception->getStatusCode(), [404, 422], true)
                ? ['message' => $exception->getMessage()]
                : [];

            $this->view->render($template, $data);
        }
    }
