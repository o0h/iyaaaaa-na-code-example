<?php

function dispatch($route): void
{
    $map = [
        'ranking' => [\O0h\IyaaaaaNaCodeExample\Controller\RankingController::class, 'index'],
        'my_ranking' => [\O0h\IyaaaaaNaCodeExample\Controller\UserController::class, 'myRanking']
    ];

    /** @var class-string<\O0h\IyaaaaaNaCodeExample\Controller\Controller> $controller */
    [$controller, $action] = $map[$route] ?? throw new \RuntimeException('Page not found');

    $controller = new $controller();
    $controller
        ->initialize()
        ->$action();
}
