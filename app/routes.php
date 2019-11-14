<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
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
        $response->getBody()->write('Hello world!');
        return $response;
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

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
