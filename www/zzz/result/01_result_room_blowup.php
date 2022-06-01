<?php
/**
 * 20220531 진경수 (방폭)
 * 콘테스트 참여자가 1명 이하인 경우
 *
 * 크론잡 순서
 * 01_result_room_blowup.php 방폭 (1인 참여)
 * 02_result_room_blowup_etc.php 방폭 (조건 미달)
 * 03_result_rank.php 등수 반영
 *
 * 크론잡 순서
 * 01_result_room_blowup.php 방폭 (1인 참여)
 * 02_result_room_blowup_etc.php 방폭 (조건 미달)
 * 03_result_rank.php 등수 반영
 *
 */

// config
require_once __DIR__ .'/../_inc/config.php';

try {
    $query  = "
        SELECT 
        *
        FROM game a 
        INNER JOIN join_contest jc
            ON a.g_idx = jc.jc_game
        WHERE 1=1
            
    ";

} catch (Exception $e) {

}