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
    // 트랜잭션
    $_mysqli->begin_transaction();

    // 변수 정리
    $arrPrize = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
    $arrUserCnt = array(5, 3, 6, 9, 13, 27, 4, 6, 22);
    $queryHaving = '';

    foreach ($arrPrize as $key => $value) {
        if ($value == 1) {
            $queryHaving = "OR MOD(COUNT(jc.jc_idx), 2) = 1 ";
        }

        $query = "
            SELECT
                g.g_idx, g.g_prize, g.g_fee, COUNT(jc.jc_idx)
            FROM game g 
            INNER JOIN join_contest jc 
                ON g.g_idx = jc.jc_game
            WHERE 1=1
                AND g.g_prize = {$value}
                AND g.result_report = 'complete'
                AND jc.result_report = 'complete'
            GROUP BY g.g_idx
            HAVING COUNT(jc.jc_idx) <= {$arrUserCnt[$key]}
                {$queryHaving}
        ";
        $result = $_mysqli->query($query);
        if (!$result) {
            $msg    = '';
            $code   = 501;
            throw new mysqli_sql_exception($msg, $code);
        }
        while ($db = $result->fetch_assoc()) {
            $gidx       = $db['g_idx'];
            $gprize     = $db['g_prize'];
            $gfee       = $db['g_fee'];

            //
            $sub_query  = "
                SELECT 
                    jc_idx, jc_gc_idx, jc_u_idx
                FROM join_contest
                WHERE 1=1
                    AND jc_game = {$gidx}
            ";
            $sub_result = $_mysqli->query($sub_query);
            if (!$sub_result) {
                $msg    = '';
                $code   = 502;
                throw new mysqli_sql_exception($msg, $code);
            }
            while ($sub_db = $sub_result->fetch_assoc()) {
                $jidx   = $sub_db['jc_idx'];
                $jgidx  = $sub_db['jc_gc_idx'];
                $juidx  = $sub_db['jc_u_idx'];
                echo "{$jidx} {$juidx}<br/>";

                // 참가 FP 반환
                $title  = '콘테스트 취소';
                give_fp($_mysqli, $juidx, $title, $gfee);

                // 결과
                $_query  = "
                    UPDATE join_contest SET
                        result_report = 'finished',
                        jc_result_update = NOW()
                    WHERE 1=1 
                        AND jc_idx = {$jidx}
                ";
                $_result = $_mysqli->query($_query);
                if (!$_result) {
                    $msg    = '';
                    $code   = 503;
                    throw new mysqli_sql_exception($msg, $code);
                }

                //
                $_sub_query = "
                    UPDATE game AS g
                    LEFT OUTER JOIN lineups_history AS lh
                        ON g.g_idx = lh.g_idx
                    SET
                        g.g_status = 4,
                        g.result_report = 'finished',
                        lh.result_report = 'finished'
                    WHERE 1=1
                        AND g.g_idx = {$gidx}                  
                ";
                $_sub_result    = $_mysqli->query($_sub_query);
                if (!$_sub_result) {
                    $msg    = '';
                    $code   = 504;
                    throw new mysqli_sql_exception($msg, $code);
                }
            }
        }
    } // foreach
    $_mysqli->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();

} catch (Exception $e) {
    $_mysqli->rollback();

} finally {
    echo '방폭(etc) 완료';
}
