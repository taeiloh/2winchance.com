<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2019-03-11
 * Time: 오후 9:57
 */

/**
 * 방폭
 * g_idx가 일치하는 방
 */

//config
require __DIR__ .'/../../inc/config.php';

//변수 정리
$data       = array();
$ymd        = date('Ymd');
$game_index = 1045; //방폭할 방 아이디

if (empty($game_index) || !is_numeric($game_index)) {
    //log
    $log_txt        = "ERROR - game_index: {$game_index} ";
    write_log($log_path, $log_txt, "a");
    exit;
}

//로그
$log_folder     = __DIR__ . '/log/rank';
$log_filename   = "{$ymd}_result_room_blowup_gidx.log";
$log_path       = $log_folder . '/' . $log_filename;
$log_txt        = "Start";
write_log($log_path, $log_txt, "a");

//
$qry    = "
    SELECT a.g_idx, a.g_prize, a.g_fee, b.jc_idx, b.jc_gc_idx, b.jc_u_idx FROM game a
    INNER JOIN join_contest b
    ON a.g_idx = b.jc_game
    WHERE 1=1 
      AND a.g_idx = {$game_index}
";
//p($qry);
$res = $_mysqli->query($qry);
if ($res) {
    while ($arrData = $res->fetch_assoc()) {
        //트랜잭션
        $_mysqli->begin_transaction();

        $g_idx      = $arrData['g_idx'];
        $g_prize    = $arrData['g_prize'];
        $g_fee      = $arrData['g_fee'];
        $jc_idx     = $arrData['jc_idx'];
        $jc_gc_idx  = $arrData['jc_gc_idx'];
        $jc_u_idx   = $arrData['jc_u_idx'];
        //log
        $log_txt        = "SUCCESS - g_idx: {$g_idx}, g_prize: {$g_prize}, g_fee: {$g_fee}, jc_idx: {$jc_idx}, jc_u_idx: {$jc_u_idx} ";
        write_log($log_path, $log_txt, "a");

        //게임 참가비용 돌려주기
        $qry2   = "
            SELECT m_deposit FROM members
            WHERE 1=1
              AND m_idx = {$jc_u_idx}
        ";
        $res2   = $_mysqli->query($qry2);
        if ($res2) {
            $arr_get_gold   = $res2->fetch_array();
            $now_gold       = digitMath($arr_get_gold[0], $g_fee, 'plus');

            //log
            $log_txt        = "SUCCESS - now_gold: {$now_gold} ";
            write_log($log_path, $log_txt, "a");

            //회원 테이블 갱신
            $qry3   = "
                UPDATE members SET
                  m_deposit = {$now_gold}
                WHERE 1=1
                  AND m_idx= {$jc_u_idx}
            ";
            //p($qry3);
            $res3   = $_mysqli->query($qry3);
            if ($res3) {
                //리워드 히스토리
                $qry4   = "
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
                $res4   = $_mysqli->query($qry4);
                if ($res4) {
                    //결과 테이블 반영
                    $qry5   = "
                        DELETE FROM join_contest
                        WHERE 1=1
                          AND jc_idx={$jc_idx}
                        LIMIT 1
                    ";
                    $res5   = $_mysqli->query($qry5);
                    if ($res5) {
                        //log
                        $log_txt        = "SUCCESS - DELETE FROM join_contest [jc_idx = {$jc_idx}] ";
                        write_log($log_path, $log_txt, "a");

                        //취소 처리
                        /*
                        $qry6   = "
                            UPDATE game SET
                              g_status      = 4
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
                            SET
                              /*A.g_status      = 4,
                              A.result_report = 'finished',*/
                              A.g_entry = 0,
                              B.result_report = 'finished' 
                            WHERE A.g_idx = {$g_idx}
                        ";
                        $res6   = $_mysqli->query($qry6);
                        if ($res6) {
                            //커밋
                            $_mysqli->commit();

                            //log
                            $log_txt        = "SUCCESS - UPDATE game [g_idx = {$g_idx}] ";
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
    $log_txt        = "ERROR - {$qry} ";
    write_log($log_path, $log_txt, "a");
    exit;
}

//log
$log_txt        = "END";
write_log($log_path, $log_txt, "a");
