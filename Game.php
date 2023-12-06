<?php
require_once './Player.php';
require_once './GameStatus.php';
require_once './GameMove.php';
class Game
{
    private const N = 3;
    private string $gameId;
    private array $board;
    private Player $player1, $player2;
    private GameStatue $state;
    private GameResult|null $gameResult;
    private Player|null $lastPlayer;
    private Player|null $winner;
    private Player|null $loser;
    private int $movesCount;
    public function __construct()
    {
        $this->board = [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];
        $this->state = GameStatue::AWAITING_PLYERS;
        $this->gameResult = null;
        $this->lastPlayer = null;
        $this->winner = null;
        $this->loser = null;
        $this->movesCount = 0;
        $this->gameId = uniqid();
    }
    public function addPlayer(Player $player): void
    {
        if ($this->state !== GameStatue::AWAITING_PLYERS)
            throw new Exception('Can not add more than tow players in a game.');

        $this->isValidPlayer($player);

        if (isset($this->player1) && isset($this->player2)) {
            $this->state = GameStatue::IN_PLAY;
        }
    }
    public function move(GameMove $gameMove): void
    {
        if ($this->state !== GameStatue::IN_PLAY)
            throw new Exception('Game is finished.');
        $this->checkIsValidPlayer($gameMove->player);
        $this->checkIsValidMove($gameMove->x, $gameMove->y);
        $this->makeAMove($gameMove);
        if ($this->checkWin($gameMove->x, $gameMove->y, $gameMove->player)) {
            $this->state = GameStatue::FINISHED;
            // $this->gameResult = GameResult::WIN;
        }
        if ($this->state === GameStatue::FINISHED) {
            $this->winner = $gameMove->player;
            $this->loser = $this->player1 === $gameMove->player ? $this->player1 : $this->player2;
        }
        $this->showBoard();
        // if ($this->state === GameStatue::FINISHED)
        //     echo "player {$this->lastPlayer->username} wins the game";

        $this->movesCount++;
    }
    private function isValidPlayer(Player $player)
    {
        if (isset($this->player1)) {
            if ($this->player1 === $player)
                throw new Exception("You can't play with yourself.");
            $this->player2 = $player;
            $this->player2->id = uniqid();
        } else {
            $this->player1 = $player;
            $this->player1->id = uniqid();
        }
    }
    private function checkIsValidMove(int $x, int $y)
    {
        if ($x >= self::N || $y >= self::N || !empty($this->board[$x][$y]))
            throw new Exception("Invalid Move! " . var_dump(json_encode(["x" => $x, "y" => $y])));
    }
    private function checkIsValidPlayer(Player $player)
    {
        if (isset($this->lastPlayer) && $this->lastPlayer === $player)
            throw new Exception("{$player->username} try to make two moves.");
    }
    private function makeAMove(GameMove $gameMove)
    {
        if ($gameMove->player === $this->player1)
            $this->board[$gameMove->x][$gameMove->y] = 'X';
        elseif ($gameMove->player === $this->player2)
            $this->board[$gameMove->x][$gameMove->y] = 'O';
        else
            throw new Exception("Invalid player for this game. Player:{$gameMove->player->username}.");
        $this->lastPlayer = $gameMove->player;
        $this->movesCount++;
    }
    private function checkWin(int $x, int $y, $player)
    {
        $symbol = $this->lastPlayer === $this->player1 ? 'X' : 'O';
        $flag = false;
        if ($this->movesCount >= self::N + 2) {
            if ($this->checkHorizontal($x, $symbol)) {
                $this->state = GameStatue::FINISHED;
                $flag = true;
            }
            if ($this->checkVertical($y, $symbol)) {
                $this->state = GameStatue::FINISHED;
                $flag = true;
            }
            if ($this->checkDiagonal($symbol)) {
                $this->state = GameStatue::FINISHED;
                $flag = true;
            }
            // if ($flag) {
            //     $this->winner = $player;
            //     $this->loser = $this->player1 === $player ? $this->player1 : $this->player2;
            // }
        }
        return $flag;
    }
    private function checkDiagonal($symbol)
    {
        return  $this->checkDiagonalRtl($symbol) ? true : $this->checkDiagonalLtr($symbol);
    }
    private function checkDiagonalRtl(string $symbol): bool
    {
        for ($i = 0; $i < self::N; $i++)
            if ($this->board[$i][(self::N - 1) - $i] != $symbol)
                return false;

        return true;
    }
    private function checkDiagonalLtr(string $symbol): bool
    {
        for ($i = 0; $i < self::N; $i++)
            if ($this->board[$i][$i] != $symbol)
                return false;
        return true;
    }
    private function checkHorizontal(int $x, string $symbol): bool
    {
        for ($i = 0; $i < self::N; $i++)
            if ($this->board[$x][$i] != $symbol)
                return false;
        return true;
    }
    private function checkVertical(int $y, string $symbol): bool
    {
        for ($i = 0; $i < self::N; $i++)
            if ($this->board[$i][$y] != $symbol)
                return false;
        return true;
    }
    private function checkDraw($currentMovesCount)
    {
        if ($currentMovesCount === 9)
            $this->gameResult = GameResult::DRAW;
    }
    public function getGameId(){
        return $this->gameId;
    }
    public function showPlayers()
    {
        // echo 'game id'.$this->gameId;
        print_r([$this->player1->username, $this->player2->username]);
    }
    public function showBoard()
    {
        echo '<table border="1">';
        foreach ($this->board as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo '<td width="20" height="25" style="text-align:center;">' . $cell . '</td>';
            }
            echo "</tr>";
        }
        echo '</table>';
    }
}
