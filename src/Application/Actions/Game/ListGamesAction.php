<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use Psr\Http\Message\ResponseInterface as Response;

class ListGamesAction extends GameAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $games = $this->db->getAllGames();
        $this->logger->info("Games list was viewed.");
        
        return $this->respondWithData($games);
    }
}
