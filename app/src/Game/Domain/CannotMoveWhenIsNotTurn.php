<?php

namespace App\Game\Domain;

class CannotMoveWhenIsNotTurn extends \Exception
{
    public function __construct(playerId $player)
    {
        parent::__construct(sprintf('<%s> cannot make the move. Is not your turn.', $player));
    }
}