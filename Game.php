    <?php
    require_once './Player.php';
    require_once './GameStatus.php';
    require_once './GameMove';
    class Game
    {
        private array $board = [];
        public Player $player1, $player2;
        public GameStatue $state;
        public function __construct()
        {
            $this->board = [
                ['X', '', ''],
                ['', 'O', ''],
                ['', '', 'X']
            ];
            $this->state = GameStatue::AWAITING_PLYERS;
        }
        public function addPlayer(Player $player): void
        {
            if ($this->state !== GameStatue::AWAITING_PLYERS) {
                throw new Exception('Can not add more than tow players in a game.');
            }
            
            if (isset($this->player1)) {
                $this->player2 = $player;
            } else {
                $this->player1 = $player;
            }
            if (isset($this->player1) && isset($this->player2))
                $this->state = GameStatue::IN_PLAY;
        }
        public function move(GameMove $gameMove): void
        {
            

        }
        public function showBoard()
        {
            // $table=new Table();
            echo '<table border="1">';
            foreach ($this->board as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td width='20' height='25' style='text-align:center'>$cell</td>";
                }
                echo "</tr>";
            }
            echo '</table>';
        }
    }
