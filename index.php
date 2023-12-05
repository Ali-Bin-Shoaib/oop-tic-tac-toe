<?php
require_once './Game.php';
require_once './Player.php';
$game = new Game;
$game->showBoard();
$player1 = new Player('ali');
$player2 = new Player('salem');
$game->addPlayer($player1);
$game->addPlayer($player2);
print_r($game->player1);
var_dump($game->state);
