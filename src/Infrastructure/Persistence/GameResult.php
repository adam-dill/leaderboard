<?php

namespace App\Infrastructure\Persistence;

class GameResult {
    public $id;
    public $name;

    public function populate($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
    }
}