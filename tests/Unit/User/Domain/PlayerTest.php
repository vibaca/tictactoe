<?php
namespace Test\Unit\Player\Domain;

use App\Game\Domain\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{

    public function testSuccesfullyCreatedUser(): void
    {
        $player = new Player();
        $player->create("1", "PEDRO");
        self::assertNotNull($player->id());
    }
}