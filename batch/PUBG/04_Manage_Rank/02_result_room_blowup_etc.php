<?php
/**
  * User: Alex.kim / Date: 2018-06-26 16:54
  * result_report : 최종 체크 필드 (마감, 결과, 정산)
      1. in_progress  = 마감된          상태
      2. out_progress = 결과처리    예정 상태
      3. complete     = 결과처리    완료 상태
      4. calculate    = 정산처리    예정 상태
      5. finished     = 결과및 정산 완료 상태 
*/
  
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-06-07
 * Time: 오전 3:16
 */

/**
 * 방폭
 * - 정산 대상 유저가
 * - Double Ups 4명 이하 (g_prize 7)
 * - XXX 6명 이하 (g_prize 8)
 * - X10 23명 이하 (g_prize 9)
 */

//config
require __DIR__ .'/../../inc/config.php';

//변수 정리
$data = array();
$ymd = date('Ymd');

//로그
$log_folder = __DIR__ . '/log/rank';
$log_filename = "{$ymd}_result_room_blowup_etc.log";
$log_path = $log_folder . '/' . $log_filename;
$log_txt = "Start";
write_log($log_path, $log_txt, "a");

//변수
$arrPrize   = array(1, 2, 3, 4, 5, 6, 7, 8, 9); //class_rank_reward.php make_rank_arr() 참고
$arrUserCnt = array(5, 3, 6, 9, 13, 27, 4, 6, 22);

foreach ($arrPrize as $key=>$value) {
    //50/50인 경우에는 5명 이하 또는 홀수일 때 방폭
    if ($value == 1) {
        $qry    = "
            SELECT a.g_idx, a.g_prize, a.g_fee, COUNT(b.jc_idx) FROM game a
            INNER JOIN join_contest b
            ON a.g_idx = b.jc_game
            WHERE 1=1
              AND a.result_report = 'complete'  /* complete 일 때 처리 */  # EDIT /  User: Alex.kim / Date: 2018-06-26 16:54
              AND a.g_prize = {$value}
              AND b.result_report = 'complete'  /* complete 일 때 처리 */  # EDIT /  User: Alex.kim / Date: 2018-06-26 16:54
            GROUP BY g_idx
            HAVING
              COUNT(b.jc_idx) <= {$arrUserCnt[$key]}
              OR MOD(COUNT(b.jc_idx), 2) = 1
        ";
    } else {
        $qry    = "
            SELECT a.g_idx, a.g_prize, a.g_fee, COUNT(b.jc_idx) FROM game a
            INNER JOIN join_contest b
            ON a.g_idx = b.jc_game
            WHERE 1=1
              AND a.result_report = 'complete'  /* end 일 때 처리 */
              AND a.g_prize = {$value}
              AND b.result_report = 'complete' /* complete 일 때 처리 */
            GROUP BY g_idx
            HAVING COUNT(b.jc_idx) <= {$arrUserCnt[$key]}
        ";
    }
    //p($qry);
    $res = $_mysqli->query($qry);
    if ($res) {
        while ($arrData1    = $res->fetch_assoc()) {
            $g_idx      = $arrData1['g_idx'];
            $g_prize    = $arrData1['g_prize'];
            $g_fee      = $arrData1['g_fee'];

            //log
            $log_txt        = "SUCCESS - g_idx: {$g_idx}, g_prize: {$g_prize}, g_fee: {$g_fee} ";
            write_log($log_path, $log_txt, "a");

            $qry1 = "
                SELECT jc_idx, jc_gc_idx, jc_u_idx FROM join_contest
                WHERE 1=1
                  AND jc_game = {$g_idx}
            ";
            $res1 = $_mysqli->query($qry1);
            if ($res1) {
                while ($arrData2 = $res1->fetch_assoc()) {
                    //트랜잭션
                    $_mysqli->begin_transaction();

                    $jc_idx = $arrData2['jc_idx'];
                    $jc_gc_idx = $arrData2['jc_gc_idx'];
                    $jc_u_idx = $arrData2['jc_u_idx'];

                    //log
                    $log_txt        = "SUCCESS - jc_idx: {$jc_idx}, jc_u_idx: {$jc_u_idx} ";
                    write_log($log_path, $log_txt, "a");

                    //게임 참가비용 돌려주기
                    $qry2 = "
                        SELECT m_deposit FROM members
                        WHERE 1=1
                          AND m_idx = {$jc_u_idx}
                    ";
                    $res2 = $_mysqli->query($qry2);
                    if ($res2) {
                        $arr_get_gold = $res2->fetch_array();
                        $now_gold = digitMath($arr_get_gold[0], $g_fee, 'plus');

                        //log
                        $log_txt        = "SUCCESS - now_gold: {$now_gold} ";
                        write_log($log_path, $log_txt, "a");

                        //회원 테이블 갱신
                        $qry3 = "
                            UPDATE members SET
                              m_deposit = {$now_gold}
                            WHERE 1=1
                              AND m_idx= {$jc_u_idx}
                        ";
                        //p($qry3);
                        $res3 = $_mysqli->query($qry3);
                        if ($res3) {
                            //리워드 히스토리
                            $qry4 = "
                                INSERT INTO deposit_history SET
                                    dh_u_idx     = {$jc_u_idx},
                                    dh_amount    = {$g_fee},
                                    dh_paymethod = 0,
                                    dh_pay_key   = 'contest_cancel',
                                    dh_content   = 'Contest Cancel (G{$g_idx})',
                                    dh_balance   = {$now_gold},
                                    dh_condition = 1,
                                    dh_req_date  = NOW(),
                                    dh_res_date  = NOW(),
                                    game_idx     = '{$g_idx}',
                                    game_g_sport = '{$jc_gc_idx}'
                            ";
                            //p($qry4);
                            $res4 = $_mysqli->query($qry4);
                            if ($res4) {
                                //결과 테이블 반영
                                $qry5 = "
                                    UPDATE join_contest SET
                                      result_report    = 'finished',
                                      jc_result_update = NOW()
                                    WHERE 1=1
                                      AND jc_idx={$jc_idx}
                                ";
                                $res5 = $_mysqli->query($qry5);
                                if ($res5) {
                                    //취소 처리
                                    /*
                                    $qry6   = "
                                        UPDATE game SET
                                          g_status = 4,
                                        WHERE 1=1
                                          AND g_idx={$g_idx}
                                    ";
                                    */
                                    # ADD /  User: Alex.kim / Date: 2018-06-26 16:54
                                    $qry6   = "
                                        UPDATE 
                                          game AS A 
                                         LEFT OUTER JOIN
                                          lineups_history AS B 
                                         ON A.g_idx = B.g_idx 
                                         SET A.g_status      = 4,
                                             A.result_report = 'finished',
                                             B.result_report = 'finished' 
                                        WHERE A.g_idx = {$g_idx}
                                    ";
                                    $res6   = $_mysqli->query($qry6);
                                    if ($res6) {
                                        //커밋
                                        $_mysqli->commit();

                                        //log
                                        $log_txt        = "SUCCESS - UPDATE game [g_idx = {$g_idx}]";
                                        write_log($log_path, $log_txt, "a");

                                    } else {
                                        //롤백
                                        $_mysqli->rollback();
                                        //log
                                        $log_txt        = "ERROR - {$qry6} ";
                                        write_log($log_path, $log_txt, "a");
                                        exit;
                                    }

                                } else {
                                    //롤백
                                    $_mysqli->rollback();
                                    //log
                                    $log_txt        = "ERROR - {$qry5} ";
                                    write_log($log_path, $log_txt, "a");
                                    exit;
                                }

                            } else {
                                //롤백
                                $_mysqli->rollback();
                                //log
                                $log_txt        = "ERROR - {$qry4} ";
                                write_log($log_path, $log_txt, "a");
                                exit;
                            }

                        } else {
                            //롤백
                            $_mysqli->rollback();
                            //log
                            $log_txt        = "ERROR - {$qry3} ";
                            write_log($log_path, $log_txt, "a");
                            exit;
                        }

                    } else {
                        //롤백
                        $_mysqli->rollback();
                        //log
                        $log_txt        = "ERROR - {$qry2} ";
                        write_log($log_path, $log_txt, "a");
                        exit;
                    }
                }

            } else {
                //log
                $log_txt        = "ERROR - {$qry1} ";
                write_log($log_path, $log_txt, "a");
                exit;
            }
        }

    } else {
        //log
        $log_txt        = "ERROR - {$qry} ";
        write_log($log_path, $log_txt, "a");
        exit;
    }
}

//log
$log_txt        = "END";
write_log($log_path, $log_txt, "a");
