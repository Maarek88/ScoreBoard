<?php

namespace ScoreBoard;

class Game
{
    private Team $homeTeam;

    private Team $awayTeam;

    private int $homeScore;

    private int $awayScore;

    public function __construct(Team $homeTeam, Team $awayTeam)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->homeScore = 0;
        $this->awayScore = 0;
    }

    public function updateScore(int $homeScore, int $awayScore): bool
    {
        $this->homeScore = $homeScore;
        $this->awayScore = $awayScore;

        return true;
    }
}