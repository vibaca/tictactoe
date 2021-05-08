<?php

namespace App\Game\Domain;

interface User
{
    public function create(string $id, string $name);
    public function delete(string $id);
}