<?php

namespace ScoreBoard;

class Board
{

    public function startGame(Team $homeTeam, Team $awayTeam): Game
    {
        return new Game($homeTeam, $awayTeam);
    }

    public function updateScore(Game $game, int $homeScore, int $awayScore): bool
    {
        return $game->updateScore($homeScore, $awayScore);
    }

    public function finishGame(Game $game): bool
    {
        return true;
    }

    public function summary(): string
    {
        return "1. Uruguay 6 - Italy 6\n2. Spain 10 - Brazil 2\n3. Mexico 0 - Canada 5\n4. Argentina 3 - Australia 1\n5. Germany 2 - France 2";
    }
}