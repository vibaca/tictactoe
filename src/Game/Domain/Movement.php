<?php

namespace App\Game\Domain;

class Movement
{
    private $player;
    private $position;

    public function __construct(playerId $player, int $move){
        $this->player = $player;
        $this->position = $move;
    }

    public function player(): playerId
    {
        return $this->player;
    }

    public function position(): int
    {
        return $this->position;
    }
}