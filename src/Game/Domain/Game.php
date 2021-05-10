<?php

namespace App\Game\Domain;

interface Game
{
    public static function startGame(GameId $id, playerId $defiant, playerId $opponent): Game;

    public function finish(?playerId $winner): void;

    public function winner(): ?playerId;

    public function isTie(): bool;
}