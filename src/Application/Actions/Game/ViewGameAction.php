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
        $arg = $this->resolveArg('id');
        $game = $this->db->getGame($arg);
        $this->logger->info("Game of arg `${arg}` was viewed.");
        
        return $this->respondWithData($game);
    }
}
