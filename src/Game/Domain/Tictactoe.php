<?php

namespace App\Game\Domain;
use App\Game\Domain\Game;
use App\Game\Domain\Player;
use App\Game\Domain\CannotMoveWhenIsNotTurn;
use App\Game\Domain\CannotMoveIntoSamePosition;

include('Game.php');
include('Movement.php');
include('Player.php');

class Tictactoe implements Game
{
    private $id;
    private $defiantId;
    private $opponentId;
    private $startedGame;
    private $finishedGame;
    private $movements;

    public function startGame(string $id,  string $defiantId, string $opponentId): void
    {
        $this->id = $id;
        $this->defiantId = $defiantId;
        $this->opponentId = $opponentId;
        $this->startedGame = true;
        $this->movements = [];
    }

    public function finishGame(): void
    {
        $this->finishedGame = true;
    }

    /**
     * @throws \App\Game\Domain\CannotMoveWhenIsNotTurn
     * @throws \App\Game\Domain\CannotMoveIntoSamePosition
     */
    public function movementGame(string $moveId, string $player, int $move): void
    {
        if($this->movements) {
            $this->turn($player);
            $this->move($move);
        }

        $movement = new Movement($moveId, $player, $move);
        $this->movements[$moveId] = $movement;

        $winner = $this->winner();

        if($winner)
        {
            $this->finishGame();
        }

        echo $winner;
    }

    public function winnerMovements(): array
    {
        //$winnerMovements = [[1,2,3],[4,5,6],[7,8,9],[1,4,7],[2,5,8],[3,6,9],[1,5,9],[3,5,7]];
        $winnerMovements[0] = [1,2,3];
        $winnerMovements[1] = [4,5,6];
        $winnerMovements[2] = [7,8,9];
        $winnerMovements[3] = [1,4,7];
        $winnerMovements[4] = [2,5,8];
        $winnerMovements[5] = [3,6,9];
        $winnerMovements[6] = [1,5,9];
        $winnerMovements[7] = [3,5,7];

        return $winnerMovements;
    }

    public function winner(): ?string
    {
        $winnerMovements = $this->winnerMovements();
        $movements = $this->movements;

        foreach ($winnerMovements as $winnerMove) {
            $winnerX = 0;
            $winnerY = 0;
            foreach ($winnerMove as $win) {
                foreach ($movements as $movement) {
                    $move = $movement->move();

                    if ($win == $move) {
                        $player = $movement->player();
                        if ($player == $this->defiantId()) {
                            $winnerX += 1;
                        }
                        if ($player == $this->opponentId()) {
                            $winnerY += 1;
                        }

                        if($winnerX == 3) {
                            return "The winner is: " . $this->defiantId();
                        }

                        if($winnerY == 3) {
                            return "The winner is: " . $this->opponentId();
                        }
                    }
                }
            }
        }

        return null;
    }

    public function turn($player): void
    {
        foreach($this->movements as $movement) {
            $lastPlayer = $movement->player();
        }

        if($player == $lastPlayer)
        {
            throw new CannotMoveWhenIsNotTurn($player);
        }
    }

    public function move($move): void
    {
        foreach($this->movements as $Movement) {
            if($move == $Movement->move())
            {
                throw new CannotMoveIntoSamePosition($move);
            }
        }
    }

    public function id(): string
    {
        return $this->id;
    }

    public function defiantId(): string
    {
        return $this->defiantId;
    }

    public function opponentId(): string
    {
        return $this->opponentId;
    }

    public function startedGame(): bool
    {
        return $this->startedGame;
    }

    public function finishedGame(): bool
    {
        return $this->finishedGame;
    }

    public function movements(): array
    {
        return $this->movements;
    }
}

//$game = new Tictactoe();
//$player = new Player();
//
//$game->startGame("1", "Player1", "Player2");
//$game->finishGame();
//$game->movementGame(1, "Player1", 1);
//$game->movementGame(2, "Player2", 2);