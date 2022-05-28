<?php
class DraftGame {
    public $gidx;
    public $mysqli;

    function __construct($gidx, $_mysqli) {
        $this->gidx     = $gidx;
        $this->mysqli   = $_mysqli;
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
}
