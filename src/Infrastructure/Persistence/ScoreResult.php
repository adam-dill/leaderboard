<?php

namespace App\Infrastructure\Persistence;

class ScoreResult {
    public $id;
    public $game_id;
    public $player_name;
    public $timestamp;
    public $scores = array();

    public function populate($row) {
        $this->id                       = $row['id'];
        $this->game_id                  = $row['game_id'];
        $this->player_name              = $row['player_name'];
        $this->timestamp                = $row['timestamp'];
        $this->scores[$row['property']] = $row['value'];
    }
}