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

// 클래스
require_once __DIR__ .'/../../class/RankReward.php';

try {
    // 파라미터 정리
    $ymd        = !empty($_GET['ymd'])      ? $_GET['ymd']      : '';

    // 변수 정리
    $round_seq      = 17;
    $game_category  = 20;

    // 트랜잭션
    $_mysqli->begin_transaction();

    $query  = "
        SELECT 
            g_idx, g_size, g_fee, g_prize, g_entry
        FROM game g 
        WHERE 1=1
            AND g.g_round_seq = {$round_seq}
            AND g.g_entry > 0
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
        $rankReward = new RankReward($db['g_size'], $db['g_fee'], $db['g_prize'], $db['g_entry']);
        //p($rankReward);
        $rewardInfo = $rankReward->getReward_info($db['g_prize'], 'array');
        p($rewardInfo);

        foreach ($rewardInfo as $key=>$value) {
            if ($value['limit']==1) {
                $sub_query = "
                    UPDATE join_contest SET
                        jc_prize = {$value['reward']},
                        result_report = 'finished',
                        jc_result_update = NOW()
                    WHERE 1=1 
                        AND jc_game = {$db['g_idx']}
                        AND jc_rank <= {$value['rank']}
                ";
            } else {
                $sub_query = "
                    UPDATE join_contest SET
                        jc_prize = {$value['reward']},
                        result_report = 'finished',
                        jc_result_update = NOW()
                    WHERE 1=1 
                        AND jc_game = {$db['g_idx']}
                    ORDER BY jc_rank ASC
                    LIMIT {$value['limit']}
                ";
            }
            p($sub_query);
            $sub_result = $_mysqli->query($sub_query);
            if (!$result) {
                $msg    = '';
                $code   = 501;
                throw new mysqli_sql_exception($msg, $code);
            }
        }
    }

    // 콘테스트 완료 처리
    $query  = "
        UPDATE game SET 
            g_status = 3
        WHERE 1=1
            AND g_round_seq = {$round_seq}
            AND g_entry > 0
    ";
    $result = $_mysqli->query($query);
    if (!$result) {
        $msg    = '';
        $code   = 502;
        throw new mysqli_sql_exception($msg, $code);
    }

    $_mysqli->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();

} catch (Exception $e) {
    $_mysqli->rollback();

} finally {
    echo '상금 지급 완료';
}
