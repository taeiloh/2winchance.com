<?php
/**
 * 20220531 진경수 (방폭)
 * x2 4명 이하 (g_prize 7)
 * x3 6명 이하 (g_prize 8)
 * x10 23명 이하 (g_prize 9)
 *
 * 크론잡 순서
 * 01_result_room_blowup.php 방폭 (1인 참여)
 * 02_result_room_blowup_etc.php 방폭 (조건 미달)
 * 03_result_rank.php 등수 반영
 *
 */

// config
require_once __DIR__ .'/../../_inc/config.php';

try {
    // 파라미터 정리
    $ymd        = !empty($_GET['ymd'])      ? $_GET['ymd']      : '';

    // 변수 정리
    $round_seq      = 25;
    $game_category  = 20;

    // 트랜잭션
    $_mysqli->begin_transaction();

    // 게임 결과를 업데이트 할 콘테스트의 라인업 리스트를 가져온다.
    $query  = "
        SELECT 
            lh.idx, lh.player_id            
        FROM game g 
        INNER JOIN lineups_history lh
            ON g.g_idx = lh.g_idx
        WHERE 1=1
            AND g.g_round_seq = {$round_seq}
        ORDER BY g.g_idx ASC, lh.idx ASC
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        $msg    = '';
        $code   = 500;
        throw new mysqli_sql_exception($msg, $code);
    }
    while ($db = $result->fetch_assoc()) {
        // 해당 라인업 선수의 경기 결과 점수를 가져온다.
        $sub_query = "
            SELECT 
                PLAYER_SEQ, 
                SUM(TEAM_SCORE) AS SUM_TEAM_SCORE,
                SUM(KILLED) AS SUM_KILLED,
                SUM(TEAMKILLED) AS SUM_TEAMKILLED,
                SUM(SELFKILLED) AS SUM_SELFKILLED,
                SUM(REVIVED) AS SUM_REVIVED
            FROM PLAYER_RESULT 
            WHERE 1=1
                AND ROUNDS_SEQ = {$round_seq}
                AND PLAYER_SEQ = {$db['player_id']}
            GROUP BY PLAYER_SEQ
        ";
        //p($sub_query);
        $sub_result = $_mysqli->query($sub_query);
        if (!$sub_result) {
            $msg    = '';
            $code   = 501;
            throw new mysqli_sql_exception($msg, $code);
        }
        $sub_db     = $sub_result->fetch_assoc();
        if (!empty($sub_db)) {
            $players_points     = $sub_db['SUM_TEAM_SCORE'] + $sub_db['SUM_KILLED'] + $sub_db['SUM_TEAMKILLED'] + $sub_db['SUM_SELFKILLED'] + $sub_db['SUM_REVIVED'];
            $result_json        = json_encode($sub_db);
        } else {
            $players_points     = 0;
            $result_json        = json_encode("");
        }
        //p($game_players_points);
        //p($result_json);

        // 라인업 리스트에 경기 결과 점수를 업데이트 한다.
        $sub_query  = "
            UPDATE lineups_history SET
                game_players_points = {$players_points},
                player_result_json = '{$result_json}',
                result_report = 'complete'
            WHERE 1=1
                AND idx = {$db['idx']};
        ";
        p($sub_query);
        $sub_result = $_mysqli->query($sub_query);
        if (!$sub_result) {
            $msg    = '';
            $code   = 502;
            throw new mysqli_sql_exception($msg, $code);
        }
    }

    $_mysqli->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();

} catch (Exception $e) {
    $_mysqli->rollback();

} finally {
    echo '경기결과 라인업 업데이트 완료';
}
