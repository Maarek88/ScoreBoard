<?php

namespace ScoreBoard;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class GameCollection implements IteratorAggregate
{
    /** @var string[] */
    private array $games = [];

    public function add(Game $game): void
    {
        $this->games[] = $game;
    }

    public function remove(int $key): void
    {
        unset($this->games[$key]);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->games);
    }
}