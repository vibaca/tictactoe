<?php

namespace App\Game\Domain;

class Player implements User
{
    private $id;
    private $name;

    public function create(string $id, string $name): void
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function delete(string $id): void
    {
        // unset();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}