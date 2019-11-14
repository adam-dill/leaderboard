<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Game;

use App\Domain\Game\Game;
use App\Domain\Game\GameNotFoundException;
use App\Domain\Game\GameRepository;

class InMemoryGameRepository implements GameRepository
{
    /**
     * @var Game[]
     */
    private $games;

    /**
     * InMemoryGameRepository constructor.
     *
     * @param array|null $games
     */
    public function __construct(array $games = null)
    {
        $this->games = $games ?? [
            1 => new Game(1, 'Box Roller'),
            2 => new Game(2, 'E.L.E.'),
            3 => new Game(3, 'Labyrinth'),
            4 => new Game(4, 'Jackel'),
            5 => new Game(5, 'Fishy Water'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->games);
    }

    /**
     * {@inheritdoc}
     */
    public function findGameOfId(int $id): Game
    {
        if (!isset($this->games[$id])) {
            throw new GameNotFoundException();
        }

        return $this->games[$id];
    }
}
