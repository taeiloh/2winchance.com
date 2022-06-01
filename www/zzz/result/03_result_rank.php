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
    // 변수 정리
    $game_category  = 20;

    // 트랜잭션
    $_mysqli->begin_transaction();

    // 결과 처리할 리스트
    $query  = "
        SELECT 
            jc_game
        FROM join_contest
        WHERE 1=1
            AND jc_gc_idx = {$game_category}
            AND result_report = 'complete'
        GROUP BY jc_game
        ORDER BY jc_game
    ";

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();

} catch (Exception $e) {
    $_mysqli->rollback();

} finally {
    echo '방폭(etc) 완료';
}
