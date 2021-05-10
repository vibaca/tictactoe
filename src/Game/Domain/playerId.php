<?php

namespace App\Game\Domain;

class playerId
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

    public function __toString() : string
    {
        return $this->value;
    }
}