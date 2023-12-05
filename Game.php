<?php
require_once './Player.php';
require_once './GameStatus.php';
require_once './GameMove.php';
class Game
{
    public const N = 3;
    public array $board;
    public Player $player1, $player2;
    public GameStatue $state;
    public Player|null $lastPlayer;
    public int $movesCount;
    public function __construct()
    {
        $this->board = [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];
        $this->state = GameStatue::AWAITING_PLYERS;
        $this->lastPlayer = null;
        $this->movesCount = 0;
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
        $this->checkWin($gameMove->x, $gameMove->y);
        $this->showBoard();
        if ($this->state === GameStatue::FINISHED)
            echo "player {$this->lastPlayer->username} wins the game";
    }
    private function isValidPlayer(Player $player)
    {
        if (isset($this->player1)) {
            if ($this->player1 === $player)
                throw new Exception("You can't play with yourself.");
            $this->player2 = $player;
        } else {
            $this->player1 = $player;
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
    private function checkWin(int $x, int $y)
    {
        $symbol = $this->lastPlayer === $this->player1 ? 'X' : 'O';
        $isWin = true;
        if ($this->movesCount >= self::N + 2) {
            for ($i = $x; $i < self::N; $i++) {
                for ($j = 0; $j < self::N; $j++) {
                    if ($this->board[$x][$j] != $symbol) {
                        $isWin = false;
                        break;
                    }
                }
                if ($isWin) {
                    $this->state = GameStatue::FINISHED;
                    break;
                }
                $isWin = true;
                for ($j = 0; $j < self::N; $j++) {
                    if ($this->board[$j][$i] != $symbol) {
                        $isWin = false;
                        break;
                    }
                }
            }
            if (!$isWin) {
                if ($this->checkDiagonal($symbol)) {
                    $this->state = GameStatue::FINISHED;
                }
            }
        }
    }
    private function checkDiagonal(string $symbol): bool
    {
        for ($i = 0; $i < self::N; $i++)
            if ($this->board[$i][$i] != $symbol)
                return false;
        return true;
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
