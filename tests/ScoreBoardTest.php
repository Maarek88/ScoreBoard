<?php

namespace ScoreBoard\Test;

use PHPUnit\Framework\TestCase;
use ScoreBoard\Board;
use ScoreBoard\Game;
use ScoreBoard\Team;

/**
 * @coversNothing
 */
class ScoreBoardTest extends TestCase
{
    public function testTeam(): void
    {
        $team = new Team();

        $this->assertTrue(true);
    }

    public function testGame(): void
    {
        $game = new Game();

        $this->assertTrue(true);
    }

    public function testBoard(): void
    {
        $board = new Board();

        $this->assertTrue(true);
    }

    public function testBoardStartGame(): void
    {
        $board = new Board();
        $game = $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));

        $this->assertTrue(true);
    }

    public function testBoardUpdateScore(): void
    {
        $board = new Board();

        $game = $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));

        $board->updateScore($game, 1, 0);

        $this->assertTrue(true);
    }

    public function testBoardFinishGame(): void
    {
        $board = new Board();

        $game = $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));

        $board->finishGame($game);

        $this->assertTrue(true);
    }

    public function testBoardSummary(): void
    {
        $matches = [
            ['Mexico', 'Canada', '0', '5'],
            ['Spain', 'Brazil', '10', '2'],
            ['Germany', 'France', '2', '2'],
            ['Uruguay', 'Italy', '6', '6'],
            ['Argentina', 'Australia', '3', '1'],
        ];

        $board = new Board();
        foreach ($matches as $match) {
            $game = $board->startGame(new Team($match[0]), new Team($match[1]));
            $board->updateScore($game, $match[2], $match[3]);
        }

        $this->assertTrue(true);
    }
}