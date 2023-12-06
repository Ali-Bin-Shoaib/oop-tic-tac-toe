<?php
require_once './Game.php';
class Player
{
    public string $id;

    public Game $currentGame;
    public string $username;
    function __construct(string $username)
    {
        $this->username = $username;
    }

    public function createGame()
    {
        $this->currentGame = new Game();
        $this->currentGame->addPlayer($this);
        return $this->currentGame->getGameId();
    }
    public function joinGame(Game $game)

    {
        $this->currentGame = $game;
        $game->addPlayer($this);
    }
}
