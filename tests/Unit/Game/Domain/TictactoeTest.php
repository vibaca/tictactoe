<?php

namespace Test\Unit\Game\Domain;

use App\Game\Domain\CannotMoveIntoSamePosition;
use App\Game\Domain\CannotMoveWhenIsNotTurn;
use App\Game\Domain\GameId;
use App\Game\Domain\playerId;
use PHPUnit\Framework\TestCase;
use App\Game\Domain\Tictactoe;

class TictactoeTest extends TestCase
{
    public function testSuccesfullyStartedGame(): void
    {

        $gameId = new GameId("1");
        $defiantId = new playerId("Player1");
        $opponentId = new playerId("Player2");
        $game = Tictactoe::startGame($gameId, $defiantId, $opponentId);

        self::assertEmpty($game->movements());
    }

    public function testFailsWhenIsNotTurn(): void
    {
        $this->expectException(CannotMoveWhenIsNotTurn::class);
        $gameId = new GameId("2");
        $defiantId = new playerId("Player1");
        $opponentId = new playerId("Player2");
        $game = Tictactoe::startGame($gameId, $defiantId, $opponentId);

        $game->move($defiantId, 7);
        $game->move($opponentId, 6);
        $game->move($opponentId, 5);
    }

    public function testFailsWithRepeatedPosition(): void
    {
        $this->expectException(CannotMoveIntoSamePosition::class);
        $gameId = new GameId("3");
        $defiantId = new playerId("Player1");
        $opponentId = new playerId("Player2");
        $game = Tictactoe::startGame($gameId, $defiantId, $opponentId);

        $game->move($defiantId, 1);
        $game->move($opponentId, 2);
        $game->move($defiantId, 2);
    }

    public function testWinnerDefiant(): void
    {
        $gameId = new GameId("4");
        $defiantId = new playerId("Player1");
        $opponentId = new playerId("Player2");
        $game = Tictactoe::startGame($gameId, $defiantId, $opponentId);

        $game->move($defiantId, 1);
        $game->move($opponentId, 4);
        $game->move($defiantId, 2);
        $game->move($opponentId, 5);
        $game->move($defiantId, 3);

        self::assertEquals($game->winner(), $defiantId);
    }

    public function testWinnerOpponent(): void
    {
        $gameId = new GameId("5");
        $defiantId = new playerId("Player1");
        $opponentId = new playerId("Player2");
        $game = Tictactoe::startGame($gameId, $defiantId, $opponentId);

        $game->move($defiantId, 4);
        $game->move($opponentId, 1);
        $game->move($defiantId, 5);
        $game->move($opponentId, 2);
        $game->move($defiantId, 7);
        $game->move($opponentId, 3);

        self::assertEquals($game->winner(), $opponentId);
    }

    public function testFinishedGame(): void
    {
        $gameId = new GameId("6");
        $defiantId = new playerId("Player1");
        $opponentId = new playerId("Player2");
        $game = Tictactoe::startGame($gameId, $defiantId, $opponentId);

        $game->move($defiantId, 4);
        $game->move($opponentId, 1);
        $game->move($defiantId, 5);
        $game->move($opponentId, 2);
        $game->move($defiantId, 7);
        $game->move($opponentId, 3);

        self::assertTrue($game->isFinished());
        self::assertNotNull($game->winner());
    }

    public function testisTieGame(): void
    {
        $gameId = new GameId("7");
        $defiantId = new playerId("Player1");
        $opponentId = new playerId("Player2");
        $game = Tictactoe::startGame($gameId, $defiantId, $opponentId);

        $game->move($defiantId, 1);
        $game->move($opponentId, 2);
        $game->move($defiantId, 3);
        $game->move($opponentId, 6);
        $game->move($defiantId, 4);
        $game->move($opponentId, 7);
        $game->move($defiantId, 5);
        $game->move($opponentId, 9);
        $game->move($defiantId, 8);

        self::assertNull($game->winner());
        self::assertTrue($game->isTie());
    }
}