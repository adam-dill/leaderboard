<?php
declare(strict_types=1);

namespace App\Domain\Game;

use JsonSerializable;

class Game implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $name;


    /**
     * @param int|null  $id
     * @param string    $name
     */
    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = strtolower($name);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
