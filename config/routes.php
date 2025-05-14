<?php 

declare(strict_types=1);

// config/routes.php
use App\Controller\Api\V1\UsersController;
use App\Controller\BlogApiController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routesList = [
        '/api/v1/users' => [
            UsersController::class => [
                'list' => ['GET']
            ],
        ],
    ];

    foreach ($routesList as $path => $controllers) {
        foreach ($controllers as $controller => $actions) {
            foreach ($actions as $action => $methdos) {
                $routes
                    ->add(str_replace('/', '_', trim($path, '/')), $path)
                    ->controller([$controller, $action])
                    ->methods($methdos);
            }
        }
    }
};