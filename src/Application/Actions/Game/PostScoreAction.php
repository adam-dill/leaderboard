<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use Psr\Http\Message\ResponseInterface as Response;

class PostScoreAction extends GameAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getBody()->getContents();
        $obj = json_decode($body);
        $result = $this->db->postScore($obj);
        $this->logger->info("posting score. ");
        
        return $this->respondWithData($result);
    }
}
