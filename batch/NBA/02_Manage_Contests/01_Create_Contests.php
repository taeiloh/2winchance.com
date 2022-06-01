<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-12-18
 * Time: 오전 2:22
 */

/**
 * Edit: Alex.Kim
 * Date: 2019-04-18
 * Time: 오전 11:27
 * 변경사항: 
    - GMT(0) -> GMT(-5)로 스케줄 변경
       > standard_scheduled -> timezone_scheduled
    - 컨테스트 방 생성일 변수 추가 (고정,유동)
    - g_json 값 없을 경우 예외처리
*/

//config
require __DIR__ .'/../../inc/config.php';

try {
    $ymd            = date('Ymd');

    //로그
    $log_folder     = __DIR__ .'/log/contests';
    $log_filename   = "{$ymd}_Create_Contests.log";
    $log_path       = $log_folder .'/'. $log_filename;
    $log_txt        = "Start";
    write_log($log_path, $log_txt, "a");

    //옵션 값이 있을 경우에만 실행
    if (isset($argv[1])){
    
        //변수 정리
        //$day            = 6;         #컨테스트 방 생성일 설정(고정) _ [0(Today) 1(tomorrow) ~]
        $day              = $argv[1];  #컨테스트 방 생성일 설정(유동) _ 명령행 옵션으로 설정 예)php 03_Create_Contests_timezone_scheduled.php 6
        $g_type           = 'public';
        $g_type2          = 'multiplayer';
        $slots_value      = 20;
        $league_alias     = NBA_LEAGUE_ALIAS;
        $content_type     = NBA_CONTENT_TYPE;
        $DateTimeZone_Set = NBA_TIMEZONE_SET;
        $admin_id         = 0;


        //방 만들 날짜
        $sdate          = date('Y-m-d 00:00:00', strtotime("{$day} day"));
        $edate          = date('Y-m-d 23:59:59', strtotime("{$day} day"));

        //생성할 요일
        $schedule_week  = date('l', strtotime($sdate));

        //트랜잭션
        $_mysqli->begin_transaction();


        //league idx 값 구하기
        $query  = "
            SELECT 
              gc_idx 
            FROM
              game_category 
            WHERE gc_name = '{$league_alias}'
        ";
        //print_r($query);
        $result = $_mysqli->query($query);
        $arrData = $result->fetch_assoc();
        $gc_idx = $arrData['gc_idx'];


        //가장 빠른 경기 시작시간 구하기
        $query  = "
            SELECT
                MIN(timezone_scheduled) AS timezone_scheduled
            FROM
                {$content_type}_game_daily_schedule
            WHERE 1=1
                AND game_status = 'scheduled'
                AND league_alias = '{$league_alias}'
                AND timezone_scheduled BETWEEN '{$sdate}' AND '{$edate}'

        ";
        //print_r($query);
        $result = $_mysqli2->query($query);
        if ($result) {
            $rows   = $result->num_rows;

            if ($rows > 0) {
                $arrData    = $result->fetch_assoc();
                $g_date     = $arrData['timezone_scheduled'];
            }
        }

        //경기 정보 구하기
        $query  = "
            SELECT
                idx,
                standard_scheduled,
                timezone_scheduled,
                game_id,
                home_id,
                away_id,
                home_name,
                away_name,
                home_alias,
                away_alias
            FROM
                {$content_type}_game_daily_schedule
            WHERE 1=1
                AND league_alias = '{$league_alias}'
                AND timezone_scheduled BETWEEN '{$sdate}' AND '{$edate}'
                AND game_status = 'scheduled'
            ORDER BY timezone_scheduled ASC
        ";
        //print_r($query);
        $result = $_mysqli2->query($query);
        if ($result) {
            $rows   = $result->num_rows;
            if ($rows > 0) {
                $arrGameInfo    = array();
                while ($arrData = $result->fetch_assoc()) {
                    array_push($arrGameInfo, $arrData);
                }
                $g_json = json_encode($arrGameInfo);
                //print_r($g_json);
            }else{
                // g_json 값 없을시 예외처리
                $log_txt = "No g_json value. - [{$sdate}-{$edate}]";
                write_log($log_path, $log_txt, "a");
                echo "\n############################################################\n";
                echo "No g_json value. - [{$sdate}-{$edate}]";
                echo "\n############################################################\n";                
                exit;
            }
        }

        //등록할 콘테스트 조회
        $query  = "
            SELECT 
                A.game_type,
                A.schedule_week,
                A.game_name,
                A.entry,
                A.fee,
                A.multi,
                A.gmod,
                B.category_value AS g_prize
            FROM create_game_contest_name A 
            LEFT OUTER JOIN create_game_contest_category B
            ON A.gmod = B.category_name
            WHERE 1=1
                AND A.game_type = '{$content_type}'
                AND A.schedule_week = '{$schedule_week}'
                AND A.slots_check = {$slots_value}
                AND B.table_filed_name = 'g_prize'
            ORDER BY game_name ASC
        ";
        //print_r($query);
        $result = $_mysqli3->query($query);
        if ($result) {
            $rows   = $result->num_rows;
            $cnt    = 0;

            if ($rows > 0) {
                $i      = 0;

                while ($arrData = $result->fetch_assoc()) {
                    //중복 등록 방지
                    $sub_query  = "
                        SELECT
                            COUNT(1) AS CNT
                        FROM game
                        WHERE 1=1
                            AND g_sport        = {$gc_idx}
                            AND g_fee          = {$arrData['fee']}
                            AND g_multi_max    = {$arrData['multi']}
                            AND g_prize        = {$arrData['g_prize']}
                            AND g_name         = '{$arrData['game_name']}'
                            AND g_date         = '{$g_date}'
                            AND g_league_alias = '{$league_alias}'
                            AND g_json         = '{$g_json}'
                            AND g_status       = 0
                    ";
                    //print_r($sub_query);
                    $sub_result = $_mysqli->query($sub_query);
                    if ($sub_result) {
                        $data   = $sub_result->fetch_assoc();
                        $cnt    = empty($data['CNT']) ? 0 : $data['CNT'];
                    }

                    if ($cnt == 0) {
                        $i++;
                        progressBar($i, $rows);

                        $sub_query = "
                            INSERT INTO game SET
                                g_sport        = {$gc_idx},
                                g_size         = {$arrData['entry']},
                                g_entry        = 0,
                                g_fee          = {$arrData['fee']},
                                g_multi_max    = {$arrData['multi']},
                                g_prize        = {$arrData['g_prize']},
                                g_type         = '{$g_type}',
                                g_type2        = '{$g_type2}',
                                g_name         = '{$arrData['game_name']}',
                                g_u_idx        = {$admin_id},
                                g_date         = '{$g_date}',
                                g_timezone     = '{$DateTimeZone_Set}',
                                g_league_alias = '{$league_alias}',
                                g_json         = '{$g_json}',
                                g_status       = 0,
                                g_repay        = 0,
                                g_c_date       = NOW()
                        ";
                        //print_r($sub_query);
                        $sub_result = $_mysqli->query($sub_query);
                        if ($sub_result) {
                            //등록 성공
                            $log_txt = "SUCCESS - [$i] INSERT INTO game [g_name = {$arrData['game_name']}]";
                            write_log($log_path, $log_txt, "a");
                        }
                    }
                }
            }
        }
        //커밋
        $_mysqli->commit();

    }else{
        // 옵션 없을 경우 
        $log_txt = "No options.";
        write_log($log_path, $log_txt, "a");
        echo "\n############################################################\n";
        echo "No options.";
        echo "\n";
        echo "ex) php ".$_SERVER["PHP_SELF"].' 1  [0(Today) 1(tomorrow) ~]';
        echo "\n############################################################\n";
        exit;
    }

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        = "SQL ERROR: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} catch (Exception $e) {
    $_mysqli->rollback();   //롤백
    $log_txt        .= "ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} finally {
    $log_txt        = "END";
    write_log($log_path, $log_txt, "a");
}
