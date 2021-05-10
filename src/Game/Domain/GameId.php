<?php

namespace App\Game\Domain;

class GameId
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value() : string
    {
        return $this->value;
    }
}