<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use Psr\Http\Message\ResponseInterface as Response;

class ViewGameAction extends GameAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $gameId = (int) $this->resolveArg('id');
        $game = $this->db->getGameById($gameId);
        $this->logger->info("Game of id `${gameId}` was viewed.");
        
        return $this->respondWithData($game);
    }
}
