    <?php
    class Game
    {
        private array $board = [];
        // public const length = 3;
        public function __construct()
        {
            $this->board = [
                ['X', '', ''],
                ['', 'O', ''],
                ['', '', 'X']
            ];
        }
        public function addPlayer(): void
        {
        }
        public function showBoard()
        {
            // $table=new Table();
            echo '<table border="1">';
            foreach ($this->board as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>$cell </td>";
                }
                echo "</tr>";
            }
            echo '</table>';
        }
    }
