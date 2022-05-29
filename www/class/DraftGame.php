<?php
class DraftGame {
    public $gidx;
    public $luidx;
    public $mysqli;
    public $mysqli_game;

    public $se_idx  = 0;

    function __construct($gidx, $luidx, $_mysqli, $_mysqli_game) {
        $this->gidx         = $gidx;
        $this->luidx        = $luidx;
        $this->mysqli       = $_mysqli;
        $this->mysqli_game  = $_mysqli_game;

        if (!empty($_SESSION['_se_idx'])) {
            $this->se_idx   = $_SESSION['_se_idx'];
        }
    }

    function getGc_pos($cate_name) {
        $query  = "
            SELECT
                gc_pos
            FROM game_category
            WHERE 1=1
                AND gc_name=''
        ";
        $result = $this->mysqli->query($query);
        if (!$result) {

        }
        $db     = $result->fetch_assoc();
        p($db);
    }

    function getListLineup() {
        $rtnArr = array();
        $query  = "
            SELECT
            *
            FROM lineups_history
            WHERE 1=1
                AND m_idx = {$this->se_idx}
                AND g_idx = {$this->gidx}
                AND lu_idx = {$this->luidx}
            ORDER BY idx ASC
        ";
        $result = $this->mysqli->query($query);
        if (!$result) {

        }
        while ($db = $result->fetch_assoc()) {
            $sub_query  = "
                SELECT 
                    idx, team_alias 
                FROM pubg_team_profile_player
                WHERE 1=1 
                    AND player_id = '{$db['player_id']}'
                LIMIT 1
            ";
            $sub_result = $this->mysqli_game->query($sub_query);
            if (!$sub_result) {

            }
            $sub_db = $sub_result->fetch_assoc();
            $player_idx = !empty($sub_db['idx'])    ? $sub_db['idx']    : 0;
            $team_alias = !empty($sub_db['team_alias'])    ? $sub_db['team_alias']    : '';

            $db['player_idx']   = $player_idx;
            $db['team_alias']   = $team_alias;
            array_push($rtnArr, $db);
        }

        return $rtnArr;
    }
}
