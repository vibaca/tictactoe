<?php

namespace App\Game\Domain;

class Movement
{
    private $moveId;
    private $player;
    private $move;

    public function __construct($moveId, $player, $move){
        $this->moveId = $moveId;
        $this->player = $player;
        $this->move = $move;
    }

    public function moveId(): string
    {
        return $this->moveId;
    }

    public function player():string
    {
        return $this->player;
    }

    public function move(): int
    {
        return $this->move;
    }



}