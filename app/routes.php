<?php
declare(strict_types=1);

use App\Application\Actions\Game\ListGamesAction;
use App\Application\Actions\Game\ViewGameAction;
use App\Application\Actions\Game\ViewScoresAction;
use App\Application\Actions\Game\PostScoreAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $file = '../public/landing.html';
        if (file_exists($file)) {
            $response->getBody()->write(file_get_contents($file));
            return $response;
        } else {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }
    });

    $app->group('/games', function (Group $group) {
        $group->get('', ListGamesAction::class);
        $group->get('/{id}', ViewGameAction::class);
    });

    $app->group('/scores', function (Group $group) {
        $group->get('/{id}', ViewScoresAction::class);
    });

    $app->group('/add', function(Group $group) {
        $group->post('', PostScoreAction::class);
    });
};
