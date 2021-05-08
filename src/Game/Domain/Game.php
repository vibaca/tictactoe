<?php

namespace App\Game\Domain;

interface Game
{
    public function startGame(string $id, string $defiant, string $opponent): void;

    public function finishGame(): void;
}