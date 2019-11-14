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
        $rows = $stm->fetchAll();
        return $rows;
    }

    public function getGameById($id) {
        $query = "SELECT * FROM games WHERE id=:id";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":id", $id);
        $stm->execute();
        $row = $stm->fetch();
        return $row;
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

}