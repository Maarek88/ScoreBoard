<?php

namespace ScoreBoard;

class Board
{
    private GameCollection $games;

    public function __construct()
    {
        $this->games = new GameCollection();
    }

    /**
     * @throws \Exception
     */
    public function startGame(Team $homeTeam, Team $awayTeam): Game
    {
        $game = new Game($homeTeam, $awayTeam);

        $key = $this->findGameKey($game);

        assert(is_null($key));

        $this->games->add($game);

        return $game;
    }

    /**
     * @throws \Exception
     */
    public function updateScore(Game $game, int $homeScore, int $awayScore): void
    {
        $key = $this->findGameKey($game);

        assert(!is_null($key));

        $game->updateScore($homeScore, $awayScore);
    }

    /**
     * @throws \Exception
     */
    public function finishGame(Game $game): void
    {
        $key = $this->findGameKey($game);

        assert(!is_null($key));

        $this->games->remove($key);
    }

    /**
     * @throws \Exception
     */
    private function findGameKey(Game $game): ?int
    {
        $games = $this->games->getIterator();
        foreach ($games as $key => $g) {
            if ($g->getHomeTeam()->getName() === $game->getHomeTeam()->getName()
                && $g->getAwayTeam()->getName() === $game->getAwayTeam()->getName()) {
                return $key;
            }
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function summary(): string
    {
        $games = (array)$this->games->getIterator();

        usort($games, fn(Game $a, Game $b): int =>
            (($b->getHomeScore() + $b->getAwayScore()) <=> ($a->getHomeScore() + $a->getAwayScore())) * 10 +
            ($b->getCreatedAt() <=> $a->getCreatedAt())
        );

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