<?php

namespace Test\Unit\Game\Domain;

use App\Game\Domain\CannotMoveIntoSamePosition;
use App\Game\Domain\CannotMoveWhenIsNotTurn;
use PHPUnit\Framework\TestCase;
use App\Game\Domain\Tictactoe;

class TictactoeTest extends TestCase
{
    public function testSuccesfullyStartedGame(): void
    {
        $tictactoe = new Tictactoe();
        $tictactoe->startGame("1", "Player1", "Player2");

        self::assertEmpty($tictactoe->movements());
    }

    public function testFailWhenMoveIsNotTurn(): void
    {
        $this->expectException(CannotMoveWhenIsNotTurn::class);
        $tictactoe = new Tictactoe();
        $tictactoe->startGame("1", "Player1", "Player2");

        $tictactoe->movementGame("1", "Player1", 1);
        $tictactoe->movementGame("1", "Player2", 2);
        $tictactoe->movementGame("1", "Player2", 3);
    }

    public function testFailWhenMoveIsTheSame(): void
    {
        $this->expectException(CannotMoveIntoSamePosition::class);
        $tictactoe = new Tictactoe();
        $tictactoe->startGame("1", "Player1", "Player2");

        $tictactoe->movementGame("1", "Player1", 1);
        $tictactoe->movementGame("1", "Player2", 2);
        $tictactoe->movementGame("1", "Player1", 2);
    }

    public function testWinnerOpponent(): void
    {
        $tictactoe = new Tictactoe();
        $tictactoe->startGame("1", "Player1", "Player2");

        $tictactoe->movementGame("1", "Player1", 1);
        $tictactoe->movementGame("2", "Player2", 4);
        $tictactoe->movementGame("3", "Player1", 2);
        $tictactoe->movementGame("4", "Player2", 5);
        $tictactoe->movementGame("5", "Player1", 3);
    }

    public function testWinnerDefiant(): void
    {
        $tictactoe = new Tictactoe();
        $tictactoe->startGame("1", "Player1", "Player2");

        $tictactoe->movementGame("1", "Player1", 4);
        $tictactoe->movementGame("2", "Player2", 1);
        $tictactoe->movementGame("3", "Player1", 5);
        $tictactoe->movementGame("4", "Player2", 2);
        $tictactoe->movementGame("5", "Player1", 7);
        $tictactoe->movementGame("5", "Player2", 3);
    }

    public function testFinishedGame(): void
    {
        $tictactoe = new Tictactoe();
        $tictactoe->startGame("1", "Player1", "Player2");

        $tictactoe->movementGame("1", "Player1", 4);
        $tictactoe->movementGame("2", "Player2", 1);
        $tictactoe->movementGame("3", "Player1", 5);
        $tictactoe->movementGame("4", "Player2", 2);
        $tictactoe->movementGame("5", "Player1", 7);
        $tictactoe->movementGame("5", "Player2", 3);

        self::assertTrue($tictactoe->finishedGame());
    }
}