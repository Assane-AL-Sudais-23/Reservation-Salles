<?php
declare(strict_types=1);

    namespace App;

    use App\View\View;
    use FastRoute\Dispatcher;
    use Invoker\InvokerInterface;

    final class Application
    {
        public function __construct(
            private readonly Dispatcher $dispatcher,
            private readonly InvokerInterface $invoker
        ) {
        }

        public function run(): void
        {
            $httpMethod = $_SERVER['REQUEST_METHOD'];
            $uri = $_SERVER['REQUEST_URI'];

            if (false !== $pos = strpos($uri, '?')) {
                $uri = substr($uri, 0, $pos);
            }
            $uri = rawurldecode($uri);

            $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

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
                    $this->invoker->call($handler, ['vars' => $vars]);
                    break;
            }
        }
    }