<?php
// config
require_once __DIR__ . '/../_inc/config.php';

try {
    // 파라미터 정리
    $cate       = 20;
    $g_idx      = !empty($_POST['index'])       ? $_POST['index']       : 0;
    //$g_idx      = 24824;

    // 쿼리
    $query  = "
        SELECT * FROM game 
        LEFT JOIN game_category
        ON gc_idx = g_sport 
        WHERE 1=1
            AND g_idx = {$g_idx}
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {

    }
    $db     = $result->fetch_assoc();
    $g_json = $db['g_json'];

    // 변수 정리
    $teamPlayers    = array();
    $arrTeam        = json_decode($g_json, true);
    //p($arrTeam);
    $cntTeam        = count($arrTeam);

    $j  = 0;
    for ($i=0; $i<$cntTeam; $i++) {
        $query  = "
            SELECT
                *
                ,0 AS fppg
            FROM pubg_team_profile_player a
            WHERE 1=1
          ORDER BY team_name ASC, full_name ASC
        ";
        //p($query);
        $result = $_mysqli_game->query($query);
        if (!$result) {

        }
        while ($db = $result->fetch_assoc()) {
            //p($db);
            $teamPlayers[$j]['game_id']     = $arrTeam[$i]['game_id'];
            $teamPlayers[$j]['player_id']   = $db;
            $j++;
        }
    }

    // 선수
    $cntTeamPlayers     = count($teamPlayers);

    $rows   = array();
    for ($i=0; $i<$cntTeamPlayers; $i++) {
        $point          = round($teamPlayers[$i]['player_id']['player_point']);
        $salary         = $teamPlayers[$i]['player_id']['player_salary'];

        $position2      = '';
        $player_img_s   = '';
        $player_img_l   = '';
        $position       = $teamPlayers[$i]['player_id']['primary_position'];
        $position2      = $teamPlayers[$i]['player_id']['position'];
        if($position=='TL') {
            $position_kr    = '오더';
        } else if($position=='R') {
            $position_kr    = '정찰';
        } else if($position=='GR') {
            $position_kr    = '포탑';
        } else if($position=='AR') {
            $position_kr    = '돌격';
        }

        // 작은 따옴표 처리할것
        $t_name         = $teamPlayers[$i]['player_id']['team_name'];
        $p_f_name       = "";
        $p_l_name       = $teamPlayers[$i]['player_id']['abbr_name'];
        $t_alias        = $teamPlayers[$i]['player_id']['team_alias'];

        //선수 통계
        $player_statistics_season   = $teamPlayers[$i]['player_id']['player_statistics_season'];

        $fppg           = !empty($teamPlayers[$i]['player_id']['fppg']) ? $teamPlayers[$i]['player_id']['fppg'] : 0;

        $rows[$i] = array(
            $position,
            $position,
            $p_f_name,
            $p_l_name,
            $t_name,
            $point,
            $salary,
            $position,
            $teamPlayers[$i]['game_id'],
            $teamPlayers[$i]['player_id']['idx'],
            $teamPlayers[$i]['player_id']['player_salary'],
            $p_f_name,
            $p_l_name,
            $t_alias,
            $teamPlayers[$i]['player_id']['player_id'],
            'pubg',
            $position2,
            $player_statistics_season,
            $player_img_s,
            $player_img_l,
            $fppg,
            $position_kr
        );
    }

    //p($teamPlayers);
    echo json_encode($rows);

} catch (Exception $e) {

}