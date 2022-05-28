<?php
class PlayerInfo {
    public $cate;
    public $g_id;
    public $p_id;

    // db
    public $mysqli;
    public $mysqli_game;

    function __construct($cate, $g_id, $p_id, $_mysqli, $_mysqli_game)
    {
        $this->cate         = $cate;
        $this->g_id         = $g_id;
        $this->p_id         = $p_id;

        $this->mysqli       = $_mysqli;
        $this->mysqli_game  = $_mysqli_game;
    }

    function getDetail() {
        $table  = "{$this->cate}_team_profile_player";

        if($this->cate == 'pubg') {
            $query  = "
                SELECT
                    * 
                FROM {$table}
                WHERE 1=1
                    AND player_id = '{$this->p_id}'
                LIMIT 1
            ";
            //p($query);
            $result = $this->mysqli_game->query($query);
            if (!$result) {

            }
            $db = $result->fetch_assoc();
        }

        return $db;
    }
}