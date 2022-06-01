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
 * Date: 2018-01-30
 * Time: 오전 5:17
 */

/**
 * 크론잡 돌리는 순서
 * result_room_blowup.php       방폭 파일(1인 참여방)
 * result_room_blowup_etc.php   방폭 파일(조건 미달방)
 * result_rank.php              등수 반영하는 파일
 * result_update.php            등수에 맞게 골드 보상하는 파일
 */

//todo-me 경기 결과 데이터 유무 파악 필요

//cli 체크
if (php_sapi_name() != 'cli') {
    exit;
}

//config
require __DIR__ .'/../../inc/config.php';

//변수
$gc_idx = 1; //20181029 진경수 (NBA만 처리(game_category gc_idx))
$title  = 'result_update';

//로그
$txt    = '=== 시작 ===';
cron_log($title, $txt);

//class_result_game.php
//make_rank_table()
try {
    $q  = "
      SELECT jc_game, jc_gc_idx FROM join_contest
      WHERE 1=1
        AND jc_gc_idx = {$gc_idx} 
        AND result_report = 'calculate'      /* EDIT /  User: Alex.kim / Date: 2018-06-26 16:54 */
      GROUP BY jc_game
      ORDER BY jc_game
    ";
    //p($q);
    $r  = mysqli_query($conn, $q);
    if ($r) {
        while ($arrData = mysqli_fetch_assoc($r)) {
            $jc_game    = $arrData['jc_game'];
            $jc_gc_idx  = $arrData['jc_gc_idx'];
            cron_log($title, "[SELECT join_contest] jc_game: {$jc_game}, jc_gc_idx: {$jc_gc_idx}");

            //
            /*$qry1   = "
                SELECT join_contest.*, game.*, members.m_name
                FROM join_contest LEFT JOIN lineups on lu_idx = jc_lineups
                LEFT JOIN game on g_idx = jc_game
                LEFT JOIN members on m_idx = jc_u_idx
                WHERE 1=1
                  AND jc_game={$jc_game}
                  AND jc_status=3
                ORDER BY jc_rank
            ";*/
            $qry1   = "
                SELECT a.*, b.*, c.m_name
                FROM join_contest a LEFT JOIN game b on a.jc_game = b.g_idx 
                LEFT JOIN members c on a.jc_u_idx = c.m_idx  
                WHERE 1=1
                  AND a.jc_game = {$jc_game} 
                  AND a.result_report = 'calculate'
                ORDER BY a.jc_rank
            ";
            //p($qry1);
            $res1   = $_mysqli->query($qry1);
            if ($res1) {
                //변수 정리
                $jc_u_idx   = array();
                $jc_idx     = array();
                $g_sport    = array();
                $count      = $res1->num_rows;
                cron_log($title, "[SELECT join_contest, game, members] count: {$count}");

                for ($i = 0; $i < $count; $i++) {
                    $arr = mysqli_fetch_assoc($res1);
                    $count_rank = 0;
                    if ($i == 0) {
                        $class_rank = new RankReward($arr['g_size'], $arr['g_fee'], $arr['g_prize'], $arr['g_entry']); //2018-06-11 진경수 (g_entry 추가)
                        // 전체 반복해야 할 회수 가져오기
                        if (is_array($class_rank->make_rank_arr())) {
                            foreach ($class_rank->make_rank_arr() as $value) {
                                $count_rank = $count_rank + $value['rank'];
                            }
                        }
                    }
                    if ($i == $count_rank) {
                        break;
                    } else {
                        $jc_u_idx[$i]   = $arr['jc_u_idx'];
                        $jc_idx[$i]     = $arr['jc_idx'];
                        $g_sport[$i]    = $arr['g_sport'];
                    }
                }//for

                $for_count  = 0;
                $init_count = 0;
                //p($class_rank->make_rank_arr());
                //p($jc_u_idx);
                //p($jc_idx);
                if (is_array($class_rank->make_rank_arr())) {
                    foreach ($class_rank->make_rank_arr() as $value) {
                        $for_count = $init_count + $value['limit'];

                        for ($i = $init_count; $i < $for_count; $i++) {
                            if ($jc_u_idx[$i]) {
                                $coin = $value['reward'];
                                cron_log($title, "[foreach] i: {$i}, coin: {$coin}");
                                //p($coin);

                                //회원 머니 차감
                                $qry2 = "
                                  SELECT m_deposit FROM members
                                  WHERE 1=1
                                    AND m_idx = {$jc_u_idx[$i]}
                                ";
                                //p($qry_get_gold);
                                $res2 = mysqli_query($conn, $qry2);
                                if ($res2) {
                                    $arr_get_gold = mysqli_fetch_array($res2);
                                    $now_gold = digitMath($arr_get_gold[0], $coin, 'plus');
                                    cron_log($title, "[SELECT members]");

                                    //트랜잭션 시작
                                    mysqli_begin_transaction($conn);

                                    //회원 테이블 갱신
                                    $qry3 = "
                                        UPDATE members SET
                                          m_deposit = {$now_gold}
                                        WHERE 1=1
                                          AND m_idx= {$jc_u_idx[$i]}
                                    ";
                                    //p($qry3);
                                    $res3 = mysqli_query($conn, $qry3);
                                    if ($res3) {
                                        cron_log($title, "[UPDATE members] jc_u_idx: {$jc_u_idx[$i]}, now_gold: {$now_gold}");

                                        //리워드 히스토리
                                        $qry4 = "
                                            INSERT INTO deposit_history SET
                                                dh_u_idx     = {$jc_u_idx[$i]},
                                                dh_amount    = {$coin},
                                                dh_paymethod = 0,
                                                dh_pay_key   = 'contest_result',
                                                dh_content   = 'Contest reward (G{$jc_game})',
                                                dh_balance   = {$now_gold},
                                                dh_condition = 1,
                                                dh_req_date  = '{$today}',
                                                dh_res_date  = '{$today}',
                                                game_idx     = '{$jc_game}',
                                                game_g_sport = '{$jc_gc_idx}'
                                        ";
                                        //p($qry4);
                                        $res4 = mysqli_query($conn, $qry4);
                                        if ($res4) {
                                            cron_log($title, "[INSERT deposit_history] dh_u_idx: {$jc_u_idx[$i]}, dh_content: Contest reward (G{$jc_game})");

                                            //결과 테이블 반영 (# EDIT /  User: Alex.kim / Date: 2018-06-26 16:54)
                                            $qry5 = "
                                                UPDATE
                                                    game AS A
                                                  LEFT OUTER JOIN join_contest AS B
                                                    ON A.g_idx = B.jc_game
                                                  LEFT OUTER JOIN lineups_history AS C
                                                    ON B.jc_game = C.g_idx
                                                SET
                                                 A.g_status      = 3,
                                                 A.result_report = 'finished',
                                                 B.jc_prize      = {$value['reward']},
                                                 B.result_report = 'finished',
                                                 C.result_report = 'finished'
                                                WHERE 1 = 1
                                                  AND B.jc_idx  = {$jc_idx[$i]}
                                                  AND B.jc_game = {$jc_game}
                                            ";
                                            //p($qry5);
                                            $res5 = mysqli_query($conn, $qry5);
                                            if ($res5) {
                                                cron_log($title, "[UPDATE join_contest] jc_idx: {$jc_idx[$i]}, jc_prize: {$value['reward']}");
                                                //커밋
                                                mysqli_commit($conn);

                                            } else {
                                                //롤백
                                                mysqli_rollback($conn);

                                                cron_log($title, "DB Error: {$qry5}");
                                                error_log('result_update.php : ' . $qry5, 1, 'alex.kim@edranetworks.com');
                                            }

                                        } else {
                                            //롤백
                                            mysqli_rollback($conn);

                                            cron_log($title, "DB Error: {$qry4}");
                                            error_log('result_update.php : ' . $qry4, 1, 'alex.kim@edranetworks.com');
                                        }

                                    } else {
                                        //롤백
                                        mysqli_rollback($conn);

                                        cron_log($title, "DB Error: {$qry3}");
                                        error_log('result_update.php : ' . $qry3, 1, 'alex.kim@edranetworks.com');
                                    }

                                } else {
                                    cron_log($title, "DB Error: {$qry2}");
                                    error_log('result_update.php : ' . $qry2, 1, 'alex.kim@edranetworks.com');
                                }

                            }

                        }//for
                        $init_count = $for_count;
                        //등수밖 인원은 상태만 업데이트 (# EDIT /  User: Alex.kim / Date: 2018-06-26 16:54)                        
                        $qry6 = "     
                            UPDATE
                                game AS A
                              LEFT OUTER JOIN join_contest AS B
                                ON A.g_idx = B.jc_game
                              LEFT OUTER JOIN lineups_history AS C
                                ON B.jc_game = C.g_idx
                            SET
                             A.g_status         = 3,
                             A.result_report    = 'finished',
                             B.result_report    = 'finished',
                             B.jc_result_update = NOW(),
                             C.result_report    = 'finished'
                            WHERE 1 = 1
                              AND B.jc_prize = 0
                              AND B.jc_game = {$jc_game}
                              AND B.result_report = 'calculate'
                        ";                        
                        $res6 = mysqli_query($conn, $qry6);
                        if ($res6) {
                            cron_log($title, "[UPDATE join_contest] jc_game: {$jc_game}");
                        }

                    }//foreach
                }

            } else {

            }

        } //while

    } else {

    }

} catch (Exception $e) {
    cron_log($title, "Exception: {$e->getMessage()}");
}

cron_log($title, "=== 끝 ===");
