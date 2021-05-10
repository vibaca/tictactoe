<?php

namespace App\Game\Domain;

class Player
{
    private $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(playerId $id, string $name): Player
    {
        return new self($id, $name);
    }

    public function id(): playerId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}