<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Game;

use App\Domain\Game\Game;
use App\Domain\Game\GameNotFoundException;
use App\Domain\Game\GameRepository;

class MySQLGameRepository implements GameRepository
{

    /**
     * InMemoryGameRepository constructor.
     *
     * @param array|null $games
     */
    public function __construct($pdo)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function findGameOfId(int $id): Game
    {
        return new Game($id, "custom");
    }
}
