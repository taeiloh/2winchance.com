<?php

require __DIR__ .'/../_inc/config.php';

try {

    $jc_idx = isset($_POST['jc_idx']) ? $_POST['jc_idx'] : 0;
    $g_idx = isset($_POST['g_idx']) ? $_POST['g_idx'] : 0;
    $lu_idx = isset($_POST['lu_idx']) ? $_POST['lu_idx'] : 0;

    $query = "SELECT jc_u_idx from join_contest where 1=1 and jc_idx = '{$jc_idx}'";
    $result = $_mysqli->query($query);
    $arridx = $result->fetch_assoc();
    $another_idx = $arridx['jc_u_idx'];

    $query2 = "SELECT distinct(lu_idx) as lu_idx FROM lineups_history WHERE m_idx = '{$another_idx}' and g_idx = '{$g_idx}'";
    $result2 = $_mysqli->query($query2);
    $arridx2 = $result2->fetch_assoc();
    $another_g_idx = $arridx2['lu_idx'];


    $sub_query = "
                                                    SELECT
                                                        player_pos, player_name, player_result_json, game_players_points
                                                    FROM lineups_history
                                                    WHERE 1=1
                                                        AND m_idx = {$another_idx}
                                                        AND g_idx = $g_idx
                                                        AND lu_idx = {$another_g_idx}
                  ";
//p($sub_query);
    $sub_result = $_mysqli->query($sub_query);
    if (!$sub_result) {
    }
    $sum_team_score = 0;
    $sum_killed = 0;
    $sum_teamkilled = 0;
    $sum_selfkilled = 0;
    $sum_revived = 0;

    $pos = !empty($sub_db['player_pos']) ? ($sub_db['player_pos']) : "";

    $j = 0;
    while ($sub_db = $sub_result->fetch_assoc()) {
        //p($sub_db);
        $result_json = $sub_db['player_result_json'];
        $arrResult = json_decode($result_json, true);
        $name = $sub_db['player_name'];
        $point = !empty($sub_db['game_players_points']) ? ($sub_db['game_players_points']) : 0;
        //p($arrResult);
        for ($i = 0; $i < 5; $i++) {
            $arrResult[$i]['TEAM_SCORE'] = 0;
            $arrResult[$i]['KILLED'] = 0;
            $arrResult[$i]['TEAMKILLED'] = 0;
            $arrResult[$i]['SELFKILLED'] = 0;
            $arrResult[$i]['REVIVED'] = 0;
        }
        $j++;
        //p($sub_db);
        if (($sub_db['player_pos'] == 'OD' or $sub_db['player_pos'] == 'TL') and $j < 5) {
            $pos = '오더';
        } else if (($sub_db['player_pos'] == 'ST' or $sub_db['player_pos'] == 'R') and $j < 5) {
            $pos = '정찰';
        } else if (($sub_db['player_pos'] == 'TW' or $sub_db['player_pos'] == 'GR') and $j < 5) {
            $pos = '포탑';
        } else if (($sub_db['player_pos'] == 'RR' or $sub_db['player_pos'] == 'AR') and $j < 5) {
            $pos = '돌격';
        } else {
            $pos = '유틸';
        }
        $sum_team_score = $arrResult[0]['TEAM_SCORE'] + $arrResult[1]['TEAM_SCORE'] + $arrResult[2]['TEAM_SCORE'] + $arrResult[3]['TEAM_SCORE'] + $arrResult[4]['TEAM_SCORE'];
        $sum_killed = $arrResult[0]['KILLED'] + $arrResult[1]['KILLED'] + $arrResult[2]['KILLED'] + $arrResult[3]['KILLED'] + $arrResult[4]['KILLED'];
        $sum_teamkilled = $arrResult[0]['TEAMKILLED'] + $arrResult[1]['TEAMKILLED'] + $arrResult[2]['TEAMKILLED'] + $arrResult[3]['TEAMKILLED'] + $arrResult[4]['TEAMKILLED'];
        $sum_selfkilled = $arrResult[0]['SELFKILLED'] + $arrResult[1]['SELFKILLED'] + $arrResult[2]['SELFKILLED'] + $arrResult[3]['SELFKILLED'] + $arrResult[4]['SELFKILLED'];
        $sum_revived = $arrResult[0]['REVIVED'] + $arrResult[1]['REVIVED'] + $arrResult[2]['REVIVED'] + $arrResult[3]['REVIVED'] + $arrResult[4]['REVIVED'];

        echo <<<TR
<tr>
                                                    <td>{$pos}</td>
                                                    <td>{$sub_db['player_name']}</td>
                                                    <td>G($g_idx)</td>
                                                    <td class="hover">
                                                        <p>팀순위({$sum_team_score}) 킬수({$sum_killed}) 팀킬({$sum_teamkilled}) 자살({$sum_selfkilled}) 부활({$sum_revived})</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <table>
                                                                     <tr>
                                                                        <th>팀 순위</th>
                                                                        <td>{$arrResult[0]['TEAM_SCORE']}</td>
                                                                        <td>{$arrResult[1]['TEAM_SCORE']}</td>
                                                                        <td>{$arrResult[2]['TEAM_SCORE']}</td>
                                                                        <td>{$arrResult[3]['TEAM_SCORE']}</td>
                                                                        <td>{$arrResult[4]['TEAM_SCORE']}</td>
                                                                        <td>= {$sum_team_score}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th>킬수</th>
                                                                        <td>{$arrResult[0]['KILLED']}</td>
                                                                        <td>{$arrResult[1]['KILLED']}</td>
                                                                        <td>{$arrResult[2]['KILLED']}</td>
                                                                        <td>{$arrResult[3]['KILLED']}</td>
                                                                        <td>{$arrResult[4]['KILLED']}</td>
                                                                        <td>= {$sum_killed}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th>팀킬</th>
                                                                        <td>{$arrResult[0]['TEAMKILLED']}</td>
                                                                        <td>{$arrResult[1]['TEAMKILLED']}</td>
                                                                        <td>{$arrResult[2]['TEAMKILLED']}</td>
                                                                        <td>{$arrResult[3]['TEAMKILLED']}</td>
                                                                        <td>{$arrResult[4]['TEAMKILLED']}</td>
                                                                        <td>= {$sum_selfkilled}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th>자살</th>
                                                                        <td>{$arrResult[0]['SELFKILLED']}</td>
                                                                        <td>{$arrResult[1]['SELFKILLED']}</td>
                                                                        <td>{$arrResult[2]['SELFKILLED']}</td>
                                                                        <td>{$arrResult[3]['SELFKILLED']}</td>
                                                                        <td>{$arrResult[4]['SELFKILLED']}</td>
                                                                        <td>= {$sum_selfkilled}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th>부활</th>
                                                                        <td>{$arrResult[0]['REVIVED']}</td>
                                                                        <td>{$arrResult[1]['REVIVED']}</td>
                                                                        <td>{$arrResult[2]['REVIVED']}</td>
                                                                        <td>{$arrResult[3]['REVIVED']}</td>
                                                                        <td>{$arrResult[4]['REVIVED']}</td>
                                                                        <td>= {$sum_revived}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th colspan="6">총점 (전투력)</th>
                                                                        <td>= {$sub_db['game_players_points']}</td>
                                                                     </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                <td>{$sub_db['game_players_points']}</td>
                                                </tr>

TR;

    }
}
catch (Exception $e) {

}
?>
