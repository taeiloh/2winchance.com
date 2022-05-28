<?php
class Game {
    public $cate;
    public $mysqli;

    function __construct($cate, $_mysqli)
    {
        $this->cate     = $cate;
        $this->mysqli   = $_mysqli;
    }

    function getListGame($sdate='', $edate='') {
        // 변수 정리
        $rtnArr     = array();
        if(empty($sdate)) {
            $sdate  = date('Y-m-d');
        }
        if(empty($edate)) {
            $edate  = date('Y-m-d');
        }

        $query  = "
            SELECT
                *
            FROM game
            WHERE 1=1
                AND g_sport = {$this->cate}
                AND g_status != 3 
                AND DATE_SUB(g_date, INTERVAL 5 HOUR) >= '{$sdate} 00:00:00' 
                AND DATE_SUB(g_date, INTERVAL 5 HOUR) <= '{$edate} 23:59:59'
            ORDER BY g_sort DESC, RAND()
        ";
        //p($query);
        $result = $this->mysqli->query($query);
        if (!$result) {

        }
        while($db = $result->fetch_assoc()) {
            array_push($rtnArr, $db);
        }

        return $rtnArr;
    }
}