<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use Psr\Http\Message\ResponseInterface as Response;

class ViewScoresAction extends GameAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $gameId = (int) $this->resolveArg('id');
        $scores = $this->db->getScoresByGameId($gameId);
        $this->logger->info("Scores for game `${gameId}` was viewed.");

        return $this->respondWithData($scores);
    }
}
