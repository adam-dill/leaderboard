<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence;

class DB
{
    protected $pdo;

    /**
     * DB constructor.
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllGames() {
        $query = 'SELECT * FROM games';
        $stm = $this->pdo->prepare($query);
        $stm->execute();
        $returnValue = array();
        while($row = $stm->fetch()) {
            $game = new GameResult();
            $game->populate($row);
            array_push($returnValue, $game);
        }

        return $returnValue;
    }

    public function getGameById($id) {
        $query = "SELECT * FROM games WHERE id=:id";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":id", $id);
        $stm->execute();
        $row = $stm->fetch();
        $returnValue = null;
        if ($row) {
            $returnValue = new GameResult();
            $returnValue->populate($row);
        }

        return $returnValue;
    }

    public function getGameByName($name) {
        $query = "SELECT * FROM games WHERE name LIKE :name";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":name", $name);
        $stm->execute();
        $row = $stm->fetch();
        $returnValue = null;
        if ($row) {
            $returnValue = new GameResult();
            $returnValue->populate($row);
        }

        return $returnValue;
    }

    public function getGameBySlug($slug) {
        $query = "SELECT * FROM games WHERE slug LIKE :slug";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":slug", $slug);
        $stm->execute();
        $row = $stm->fetch();
        $returnValue = null;
        if ($row) {
            $returnValue = new GameResult();
            $returnValue->populate($row);
        }

        return $returnValue;
    }

    public function getScoresByGameId($id) {
        $query = 'SELECT e.id, e.game_id, e.player_name,  e.timestamp, s.property, s.value
                    FROM entries e
                    LEFT JOIN scores s ON s.entry_id=e.id
                    WHERE e.game_id=:id
                    ORDER BY e.id';
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":id", $id);
        $stm->execute();

        $returnValue = array();
        $queue;
        while($row = $stm->fetch()) {
            if (isset($queue) && $row['id'] != $queue->id) {
                array_push($returnValue, $queue);
                $queue = new ScoreResult();
            } else if (isset($queue) == false) {
                $queue = new ScoreResult();
            }
            $queue->populate($row);
        }
        if (isset($queue)) {
            array_push($returnValue, $queue);
        }

        return $returnValue;
    }

    public function postScore($data) {
        $query = "INSERT INTO entries (game_id, player_name, timestamp) VALUES (:gameId, :name, now())";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':gameId', $data->game_id);
        $stmt->bindParam(':name', $data->player_name);
        $stmt->execute();

        $entryId = $this->pdo->lastInsertId();
        foreach($data->scores as $key => $value) {
            $query = "INSERT INTO scores (entry_id, property, value) VALUES (:entryId, :property, :value)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':entryId', $entryId);
            $stmt->bindParam(':property', $key);
            $stmt->bindParam(':value', $value);
            $stmt->execute();
        }
    }

    public function addGame($data) {
        $slug = $this->createSlugFromName($data->name);
        $game = $this->getGameBySlug($data->name);
        if ($game) {
            return $game;
        }
        
        $query = "INSERT INTO games (name, slug) VALUES (:name, :slug)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name', $data->name);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();

        return $this->getGameByName($data->name);
    }

    private function createSlugFromName($name) {
        $name = strtolower($name);
        $name = str_replace(' ', '-', $name);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $name);
    }
}
