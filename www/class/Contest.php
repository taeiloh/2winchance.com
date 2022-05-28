<?php
class Contest {
    public $uidx;
    public $gidx;

    public $mysqli;
    public $mysqli_game;

    function __construct($u_idx, $g_idx, $_mysqli)
    {
        $this->uidx     = $u_idx;
        $this->gidx     = $g_idx;

        $this->mysqli   = $_mysqli;
    }

    function getCntJoinContest() {
        $query  = "
            SELECT
                COUNT(jc_idx) AS CNT
            FROM join_contest
            WHERE 1=1 
                AND jc_u_idx = {$this->uidx}
                AND jc_game = {$this->gidx}
        ";
        $result = $this->mysqli->query($query);
        if (!$result) {

        }
        $db = $result->fetch_assoc();

        return $db['CNT'];
    }
}