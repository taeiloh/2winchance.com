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
    $round_seq      = 14;
    $game_category  = 20;

    // 트랜잭션
    $_mysqli->begin_transaction();

    // 게임 결과를 업데이트 할 콘테스트의 라인업 리스트를 가져온다.
    $query  = "
        SELECT 
            g_idx            
        FROM game g 
        WHERE 1=1
            AND g.g_round_seq = {$round_seq}
            AND g_entry > 0
        ORDER BY g.g_idx ASC
    ";
    p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        $msg    = '';
        $code   = 500;
        throw new mysqli_sql_exception($msg, $code);
    }
    while ($db = $result->fetch_assoc()) {
        // 콘테스트 정보에 점수 업데이트 및 랭킹 업데이트
        $sub_query  = "
            SELECT 
                lu_idx, m_idx, SUM(game_players_points) AS players_points
            FROM lineups_history 
            WHERE 1=1 
                AND g_idx = {$db['g_idx']}
            GROUP BY lu_idx, m_idx
            ORDER BY players_points DESC
        ";
        p($sub_query);
        $sub_result = $_mysqli->query($sub_query);
        if (!$sub_result) {
            $msg    = '';
            $code   = 501;
            throw new mysqli_sql_exception($msg, $code);
        }
        $rank       = 0;
        $rank_cnt   = 0;
        $old_points = null;
        while ($sub_db = $sub_result->fetch_assoc()) {
            $rank_cnt++;

            if ($sub_db['players_points'] != $old_points) {
                $rank   = $rank_cnt;
            }

            $_query     = "
                UPDATE join_contest SET
                    jc_point = {$sub_db['players_points']},
                    jc_rank = {$rank},
                    result_report = 'calculate',
                    jc_result_update = NOW()
                WHERE 1=1
                    AND jc_game = {$db['g_idx']}
                    AND jc_lineups = {$sub_db['lu_idx']}
                    AND jc_u_idx = {$sub_db['m_idx']}
            ";
            $_result    = $_mysqli->query($_query);
            if (!$_result) {
                $msg    = '';
                $code   = 502;
                throw new mysqli_sql_exception($msg, $code);
            }

            $old_points     = $sub_db['players_points'];
        }
    }

    $_mysqli->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();

} catch (Exception $e) {
    $_mysqli->rollback();

} finally {
    echo '랭킹 완료';
}
