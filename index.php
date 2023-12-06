<?php
require_once './Game.php';
require_once './Player.php';
require_once './GameMove.php';
// $game = new Game;
$player1 = new Player('ali');
$player2 = new Player('ahmed');
// $player3 = new Player('salem');
$gameId = $player1->createGame();
$player2->joinGame($player1->currentGame);

$player1->currentGame->showPlayers();

// $currentGame->addPlayer($player2);
// $game->addPlayer($player3);
$player1->currentGame->move(new GameMove(2, 2, $player1));
$player1->currentGame->move(new GameMove(0, 1, $player2));
$player1->currentGame->move(new GameMove(1, 2, $player1));
$player1->currentGame->move(new GameMove(2, 1, $player2));
$player1->currentGame->move(new GameMove(1, 1, $player1));
$player1->currentGame->move(new GameMove(0, 2, $player2));
$player1->currentGame->move(new GameMove(0, 0, $player1));
// $game->move(new GameMove(2, 0, $player2));
// $game->move(new GameMove(2, 1, $player2));
// $game->move(new GameMove(3, 2, $player2));
// var_dump($game->lastPlayer->username);