<?php

namespace App\Game\Domain;

class CannotMoveIntoSamePosition extends \Exception
{
    public function __construct(int $move)
    {
        parent::__construct(sprintf('cannot move in the same position <%s>.', $move));
    }
}