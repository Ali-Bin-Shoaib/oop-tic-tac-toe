    <?php
    class Game
    {
        private array $board = [];
        public const length = 3;
        public function __construct()
        {
            $this->board = [
                ['', '', ''],
                ['', '', ''],
                ['', '', '']
            ];
        }
        public function showBoard()
        {
            // $table=new Table();
            echo '<table>';
            foreach ($this->board as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>$cell </td>";
                }
                echo "</tr>";
                echo '</table>';
            }
        }
    }
