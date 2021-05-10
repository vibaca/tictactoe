<?php

namespace App\Game\Domain;

include('Game.php');
include('Movement.php');

class Tictactoe implements Game
{
    private $id;
    private $defiantId;
    private $opponentId;
    /** @var Movement[] */
    private $movements;
    private $lastPlayer;
    private $winner;
    private $isTie;
    private $winnerLines;

    private function __construct(GameId $id, playerId $defiantId, playerId $opponentId)
    {
        $this->id = $id;
        $this->defiantId = $defiantId;
        $this->opponentId = $opponentId;
        $this->movements = [];
        $this->winner = null;
        $this->isTie = false;

        $this->winnerLines[] = [1, 2, 3];
        $this->winnerLines[] = [4, 5, 6];
        $this->winnerLines[] = [7, 8, 9];
        $this->winnerLines[] = [1, 4, 7];
        $this->winnerLines[] = [2, 5, 8];
        $this->winnerLines[] = [3, 6, 9];
        $this->winnerLines[] = [1, 5, 9];
        $this->winnerLines[] = [3, 5, 7];

    }

    public static function startGame(GameId $id, playerId $defiantId, playerId $opponentId): Game
    {
        return new self($id, $defiantId, $opponentId);
    }

    /**
     * @throws \App\Game\Domain\CannotMoveWhenIsNotTurn
     * @throws \App\Game\Domain\CannotMoveIntoSamePosition
     */
    public function move(playerId $playerId, int $position): void
    {
        if ($this->movements) {
            $this->ensureValidTurn($playerId);
            $this->ensureValidMove($position);
        }

        $movement = new Movement($playerId, $position);
        $this->movements[$position] = $movement;
        $this->lastPlayer = $playerId;

        if (count($this->movements) > 4) {
            $winner = $this->winner();
            if ($winner) {
                $this->finish($winner);
            }
        }

        if (count($this->movements) == 9) {
            $this->finish(null);
        }
    }

    public function finish(?playerId $winner): void
    {
        if ($winner) {
            $this->winner = $winner;
            $this->isTie = false;
            return;
        }

        $this->isTie = true;
    }

    public function winnerLines(): array
    {
        return $this->winnerLines;
    }

    public function winner(): ?playerId
    {
        foreach ($this->winnerLines() as $line) {
            $movementA = $this->movements[$line[0]];
            $movementB = $this->movements[$line[1]];
            $movementC = $this->movements[$line[2]];
//            if ($movementA->player()->equals($movementB->player()) && $movementA->player()->equals($movementC->player())){
            if ($movementA && $movementB && $movementC
                && $movementA->player() == $movementB->player()
                && $movementA->player() == $movementC->player()
            ) {
                $this->finish($movementA->player());
                return $this->winner;
            }
        }

        return null;
    }

    public function ensureValidTurn(playerId $player): void
    {
        if ($player == $this->lastPlayer) {
            throw new CannotMoveWhenIsNotTurn($player);
        }
    }

    public function ensureValidMove(int $move): void
    {
        $position = $this->movements[$move];
        if($position) {
            throw new CannotMoveIntoSamePosition($move);
        }
    }

    public function id(): gameId
    {
        return $this->id;
    }

    public function defiantId(): playerId
    {
        return $this->defiantId;
    }

    public function opponentId(): playerId
    {
        return $this->opponentId;
    }

    public function isFinished(): bool
    {
        return $this->isTie || $this->winner != null;
    }

    public function isTie(): bool
    {
        return $this->isTie;
    }

    public function movements(): array
    {
        return $this->movements;
    }
}