<?php
class Game {
    public $cate;
    public $mysqli;

    function __construct($cate, $_mysqli)
    {
        $this->cate     = $cate;
        $this->mysqli   = $_mysqli;
    }

    // 게임 리스트
    function getListGame($sdate='', $edate='', $limit=0) {
        // 변수 정리
        $rtnArr     = array();
        $queryLimit = '';
        if(empty($sdate)) {
            $sdate  = date('Y-m-d');
        }
        if(empty($edate)) {
            $edate  = date('Y-m-d');
        }

        if ($limit) {
            $queryLimit  = "LIMIT {$limit}";
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
            {$queryLimit}
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

    // 콘테스트 화면 서브 메뉴 구하기
    function getSub_menu($g_prize) {
        $sub_menu   = 0;

        switch ($g_prize) {
            case 0:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                $sub_menu   = 2;
                break;
            case 1:
                $sub_menu   = 6;
                break;
            case 7:
                $sub_menu   = 3;
                break;
            case 8:
                $sub_menu   = 4;
                break;
            case 9:
                $sub_menu   = 5;
                break;
        }

        return $sub_menu;
    }
}