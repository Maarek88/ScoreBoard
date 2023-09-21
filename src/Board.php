<?php

namespace ScoreBoard;

class Board
{
    private array $games = [];

    public function startGame(Team $homeTeam, Team $awayTeam): Game
    {
        $game = new Game($homeTeam, $awayTeam);

        $key = $this->findGameKey($game);

//        echo '-----------------------'.PHP_EOL;
//        var_dump($key);
//        var_dump($this->games);
//        echo '-----------------------'.PHP_EOL;

        assert(is_null($key));

        $this->games[] = $game;

        return $game;
    }

    public function updateScore(Game $game, int $homeScore, int $awayScore): void
    {
        $key = $this->findGameKey($game);

        assert(!is_null($key));

        $game->updateScore($homeScore, $awayScore);
    }

    public function finishGame(Game $game): void
    {
        $key = $this->findGameKey($game);

        assert(!is_null($key));
//        the above could be also:
//        if(is_null($key)){
//            return;
//        }

        unset($this->games[$key]);
    }

    private function findGameKey(Game $game): ?int
    {
        foreach ($this->games as $key => $g) {
            if ($g->getHomeTeam()->getName() === $game->getHomeTeam()->getName()
                && $g->getAwayTeam()->getName() === $game->getAwayTeam()->getName()) {
                return $key;
            }
        }

        return null;
    }

    public function summary(): string
    {
        $games = $this->games;

        usort(
            $games,
            fn(Game $a, Game $b) => ($a->getHomeScore() + $a->getAwayScore()) <=> ($b->getHomeScore(
                    ) + $b->getAwayScore())
        );

        krsort($games);

        $summary = '';
        $i = 1;

        /** @var Game $game */
        foreach ($games as $game) {
            $summary .= sprintf(
                "%d. %s %d - %s %d\n",
                $i++,
                $game->getHomeTeam()->getName(),
                $game->getHomeScore(),
                $game->getAwayTeam()->getName(),
                $game->getAwayScore(),
            );
        }

        return $summary;
    }
}