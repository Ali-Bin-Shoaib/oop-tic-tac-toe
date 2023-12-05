<?php
require_once './Player.php';
class GameMove
{
    public int $x;
    public int $y;
    public Player $player;
    public function __construct(int $x, int $y, Player $player)
    {
        $this->x = $x;
        $this->y = $y;
        $this->player = $player;
    }
}
