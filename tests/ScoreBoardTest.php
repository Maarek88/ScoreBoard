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
    private function getFile(string $fileName): ?string
    {
        return file_get_contents(__DIR__ . '/' . $fileName);
    }

    public function testTeam(): void
    {
        $team = new Team('testTeamName');

        $this->assertEquals('testTeamName', $team->getName());
    }

    public function testGame(): void
    {
        $game = new Game(new Team('testHomeTeam'), new Team('testAwayTeam'));

        $this->assertEquals('testHomeTeam', $game->getHomeTeam()->getName());
        $this->assertEquals('testAwayTeam', $game->getAwayTeam()->getName());
        $this->assertEquals(0, $game->getHomeScore());
        $this->assertEquals(0, $game->getAwayScore());
    }

    public function testGameUpdateScore(): void
    {
        $game = new Game(new Team('testHomeTeam'), new Team('testAwayTeam'));
        $game->updateScore(1, 0);

        $this->assertEquals(1, $game->getHomeScore());
        $this->assertEquals(0, $game->getAwayScore());
    }

    public function testGameUpdateScoreValidation(): void
    {
        $this->expectException(\AssertionError::class);

        $game = new Game(new Team('testHomeTeam'), new Team('testAwayTeam'));
        $game->updateScore(-1, -5);
    }

    public function testBoardStartGame(): void
    {
        $board = new Board();
        $game = $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));

        $this->assertEquals('testHomeTeam', $game->getHomeTeam()->getName());
        $this->assertEquals(0, $game->getHomeScore());
        $this->assertEquals('testAwayTeam', $game->getAwayTeam()->getName());
        $this->assertEquals(0, $game->getAwayScore());
    }

    public function testBoardStartGameAlreadyExists(): void
    {
        $this->expectException(\AssertionError::class);

        $board = new Board();

        $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));

        $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));
    }

    public function testBoardUpdateScore(): void
    {
        $board = new Board();

        $game = $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));
        $board->updateScore($game, 1, 0);

        $this->assertEquals(1, $game->getHomeScore());
        $this->assertEquals(0, $game->getAwayScore());
    }

    public function testBoardFinishGame(): void
    {
        $board = new Board();

        $game = $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));
        $result1 = $this->getFile('testSummary3.txt');
        $this->assertEquals($result1, $board->summary());

        $board->finishGame($game);
        $this->assertEquals('', $board->summary());
    }

    public function testBoardFinishGameNotExists(): void
    {
        $this->expectException(\AssertionError::class);

        $board = new Board();
        $game = $board->startGame(new Team('testHomeTeam'), new Team('testAwayTeam'));

        $board->finishGame($game);
        $board->finishGame($game);
    }

    public function testBoardSummary1(): void
    {
        $matches = [
            ['Mexico', 'Canada', '0', '5'],
            ['Spain', 'Brazil', '10', '2'],
            ['Germany', 'France', '2', '2'],
            ['Uruguay', 'Italy', '6', '6'],
            ['Argentina', 'Australia', '3', '1'],
        ];

        $result = $this->getFile('testSummary1.txt');

        $board = new Board();
        foreach ($matches as $match) {
            $game = $board->startGame(new Team($match[0]), new Team($match[1]));
            $board->updateScore($game, $match[2], $match[3]);
        }

        $this->assertEquals($result, $board->summary());
    }

    public function testBoardSummary2(): void
    {
        $matches = [
            ['Mexico', 'Canada', '0', '5'],
            ['Uruguay', 'Italy', '6', '6'],
            ['Argentina', 'Australia', '3', '1'],
            ['Spain', 'Brazil', '10', '2'],
            ['Germany', 'France', '2', '2'],
        ];

        $result = $this->getFile('testSummary2.txt');

        $board = new Board();
        foreach ($matches as $match) {
            $game = $board->startGame(new Team($match[0]), new Team($match[1]));
            $board->updateScore($game, $match[2], $match[3]);
        }

        $this->assertEquals($result, $board->summary());
    }
}