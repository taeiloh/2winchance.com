<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-12-18
 * Time: 오전 5:01
 */

//config
require __DIR__ .'/../../inc/config.php';

try {
    // 파라미터
    //$date           = '2022-05-28'; // test

    $ymd            = date('Ymd');
    $today          = date('Y-m-d H:i:s');

    //로그
    $log_folder     = __DIR__ .'/log/contests';
    $log_filename   = "{$ymd}_Close_Contests.log";
    $log_path       = $log_folder .'/'. $log_filename;
    $log_txt        = " ";
    write_log($log_path, $log_txt, "a");
    $log_txt        = "=======================";
    write_log($log_path, $log_txt, "a");
    $log_txt        = "START";
    write_log($log_path, $log_txt, "a");

    //변수 정리
    $league_alias   = PUBG_LEAGUE_ALIAS;
    $content_type   = PUBG_CONTENT_TYPE;
    $sdate          = date('Y-m-d 00:00:00', time() + 60*30);
    $edate          = date('Y-m-d 23:59:59', time() + 60*30);
    //테스트
    if (!empty($date)) {
        $sdate          = "{$date} 00:00:00";
        $edate          = "{$date} 23:59:59";
    }

    //트랜잭션
    $_mysqli->begin_transaction();
    $_mysqli2->begin_transaction();

    //30분 후 시작하는 경기 조회
    $query  = "
        SELECT 
            MIN(timezone_scheduled) AS first_scheduled,
            MAX(timezone_scheduled) AS last_scheduled
        FROM pubg_game_daily_schedule
        WHERE 1=1
            AND timezone_scheduled BETWEEN '{$sdate}' AND '{$edate}'
    ";
    //p($query);
    $log_txt    = "SUCCESS - query:[{$query}]";
    write_log($log_path, $log_txt, "a");
    $result = $_mysqli2->query($query);
    if ($result) {
        $arrData            = $result->fetch_assoc();
        $first_scheduled    = $arrData['first_scheduled']; //첫 경기일시
        $last_scheduled     = $arrData['last_scheduled']; //끝 경기일시

        //첫 경기 시작일시가 30분 이내일 경우
        if (!empty($first_scheduled)) {
            $remain_time    = round((strtotime($first_scheduled) - strtotime($today)) / 60); //남은 시간(분)

            //log
            $log_txt    = "SUCCESS - FS:[{$first_scheduled}] / LS:[{$last_scheduled}] / RT:[{$remain_time}]";
            write_log($log_path, $log_txt, "a");

            if ($remain_time > 0 && $remain_time <= 30) {
                $first_date     = substr($first_scheduled, 0, 10);
                //print_r($first_date);

                //첫 경기 시작 전 30분에 당일 경기 마감
                $sub_query  = "
                    UPDATE pubg_game_daily_schedule
                    SET
                        game_status = 'live',
                        result_report = 'in_progress'
                    WHERE 1=1
                        AND DATE_FORMAT(timezone_scheduled, '%Y-%m-%d') = '{$first_date}'
                        AND game_status = 'scheduled'
                ";
                //print_r($query);
                $sub_result = $_mysqli2->query($sub_query);
                if ($sub_result) {
                    $sub_rows   = $_mysqli2->affected_rows;
                    $log_txt    = "SUCCESS - UPDATE pubg_game_daily_schedule [timezone_scheduled = '{$first_date}'] [{$sub_rows}]";
                    write_log($log_path, $log_txt, "a");

                } else {
                    $log_txt    = "FAIL - UPDATE pubg_game_daily_schedule [timezone_scheduled = '{$first_date}']";
                    write_log($log_path, $log_txt, "a");
                }

                //game, join_contest, lineups_history 경기 마감
                $sub_query  = "
                    UPDATE
                        game A
                    LEFT OUTER JOIN join_contest B
                    ON A.g_idx = B.jc_game
                    LEFT OUTER JOIN lineups_history C 
                    ON A.g_idx = C.g_idx
                    SET
                        A.g_status = 2,
                        A.result_report = 'in_progress',
                        B.jc_status = 0,
                        B.result_report = 'in_progress',
                        C.result_report = 'in_progress'
                    WHERE 1=1
                        AND DATE_FORMAT(A.g_date, '%Y-%m-%d') = '{$first_date}'
                        AND A.g_status = 0
                ";
                //p($sub_query);
                $sub_result = $_mysqli->query($sub_query);
                if ($sub_result) {
                    $sub_rows       = $_mysqli2->affected_rows;
                    $log_txt        = "SUCCESS - UPDATE game [g_date = '{$first_date}'] [{$sub_rows}]";
                    write_log($log_path, $log_txt, "a");

                } else {
                    $log_txt        = "FAIL - UPDATE game [g_date = '{$first_date}']";
                    write_log($log_path, $log_txt, "a");
                }
            }
        }

        //끝 경기 시작일시가 지난 경우
        if (!empty($last_scheduled)) {
            //log
            $log_txt    = "SUCCESS - FD:[{$first_scheduled}] / LS:[{$last_scheduled}] / TODAY:[{$today}]";
            write_log($log_path, $log_txt, "a");

            if ($last_scheduled <= $today) {
                $first_date     = substr($first_scheduled, 0, 10);
                //print_r($first_date);

                //
                $sub_query  = "
                    UPDATE pubg_game_daily_schedule
                    SET
                        game_status = 'closed',
                        result_report = 'out_progress'
                    WHERE 1=1
                        AND DATE_FORMAT(timezone_scheduled, '%Y-%m-%d') = '{$first_date}'
                        AND game_status = 'live'
                        AND result_report = 'in_progress'
                ";
                //p($sub_query);
                $sub_result = $_mysqli2->query($sub_query);
                if ($sub_result) {
                    $sub_rows       = $_mysqli2->affected_rows;
                    $log_txt        = "SUCCESS - UPDATE pubg_game_daily_schedule [timezone_scheduled = '{$first_date}'] [{$sub_rows}]";
                    write_log($log_path, $log_txt, "a");

                } else {
                    $log_txt        = "FAIL - UPDATE pubg_game_daily_schedule [timezone_scheduled = '{$first_date}']";
                    write_log($log_path, $log_txt, "a");
                }

                //game, join_contest, lineups_history 경기 마감
                $sub_query  = "
                    UPDATE
                        game A
                    LEFT OUTER JOIN join_contest B
                    ON A.g_idx = B.jc_game
                    LEFT OUTER JOIN lineups_history C 
                    ON A.g_idx = C.g_idx
                    SET
                        A.result_report = 'out_progress',
                        B.result_report = 'out_progress',
                        C.result_report = 'out_progress'
                    WHERE 1=1
                        AND DATE_FORMAT(A.g_date, '%Y-%m-%d') = '{$first_date}'
                        AND A.result_report = 'in_progress'
                ";
                //p($sub_query);
                $sub_result = $_mysqli->query($sub_query);
                if ($sub_result) {
                    $sub_rows       = $_mysqli2->affected_rows;
                    $log_txt        = "SUCCESS - UPDATE game [g_date = '{$first_date}'] [{$sub_rows}]";
                    write_log($log_path, $log_txt, "a");

                } else {
                    $log_txt        = "FAIL - UPDATE game [g_date = '{$first_date}']";
                    write_log($log_path, $log_txt, "a");
                }
            }
        }
    }

    //커밋
    $_mysqli->commit();
    $_mysqli2->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();  //롤백
    $_mysqli2->rollback();  //롤백
    $log_txt        = "SQL ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} catch (Exception $e) {
    $_mysqli->rollback();  //롤백
    $_mysqli2->rollback();   //롤백
    $log_txt        .= "ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} finally {
    $log_txt        = "END";
    write_log($log_path, $log_txt, "a");
}
