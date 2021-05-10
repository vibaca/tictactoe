<?php

namespace Test\Unit\Game\Domain;

use App\Game\Domain\playerId;
use PHPUnit\Framework\TestCase;
use App\Game\Domain\Player;

class PlayerTest extends TestCase
{
    public function testSuccesfullyCreatePlayer(): void
    {
        $playerId = new playerId("Player1");
        $player = Player::create($playerId, "PEDRO");
        self::assertNotNull($player->id());
    }
}