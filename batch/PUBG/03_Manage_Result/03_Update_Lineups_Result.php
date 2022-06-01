<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2019-01-07
 * Time: 오후 11:45
 */

//config
require __DIR__ .'/../../inc/config.php';

try {
    //변수 define
    $ymd            = date('Ymd');
    $data           = array();
    $result_date    = ''; //지정일만 정산 (2019-02-12)
    if (!empty($result_date)) {
        //정산 롤백시 이용
        $tb_game_whereQuery                     = "AND g_date BETWEEN '{$result_date} 00:00:00' AND '{$result_date} 23:59:59' ";
        $tb_nba_game_daily_schedule_whereQuery  = "AND result_report IN ('out_progress', 'finished') ";
        $tb_lineups_history_whereQuery          = "";

    } else {
        $tb_game_whereQuery                     = '';
        $tb_nba_game_daily_schedule_whereQuery  = "AND result_report = 'out_progress' ";
        $tb_lineups_history_whereQuery          = "AND result_status = 'U' ";
    }

    $log_folder = __DIR__ . '/log/lineups';
    $log_filename = "{$ymd}_Update_Lineups_Result.log";
    $log_path = $log_folder . '/' . $log_filename;
    $log_txt = "Start";
    write_log($log_path, $log_txt, "a");

    //변수 정리
    $season_year    = NBA_SEASON_YEAR;
    $season_type    = NBA_SEASON_TYPE;
    $season_id      = NBA_SEASON_ID; //년도별 시즌 id
    $league_alias   = 'PUBG';
    $league_id      = NBA_LEAGUE_ID;
    $content_type   = NBA_CONTENT_TYPE;

    //트랜잭션
    $_mysqli->begin_transaction();
    $_mysqli2->begin_transaction();

    //정산 가능한 contest 가져오기
    $query  = "
        SELECT * FROM game
        WHERE 1=1
          AND g_league_alias = 'PUBG'
          AND g_entry > 0
          AND g_date <= NOW()
          {$tb_game_whereQuery}
          AND result_report = 'out_progress'
        GROUP BY g_json
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if ($result) {
        $i      = 0;
        $rows   = $result->num_rows;

        while ($arrData = $result->fetch_assoc()) {
            $i++;
            progressBar($i, $rows);

            $g_json     = $arrData['g_json'];
            $arrG_Json  = json_decode($g_json);
            if (is_array($arrG_Json)) {
                foreach ($arrG_Json as $val) {
                    //p($val);
                    $sub_query  = "
                        SELECT * FROM nba_game_daily_schedule
                        WHERE 1=1
                          AND idx = {$val->idx}
                          AND game_status IN ('closed', 'postponed')
                          {$tb_nba_game_daily_schedule_whereQuery}
                    ";
                    //p($sub_query);
                    $sub_result = $_mysqli2->query($sub_query);
                    if ($sub_result) {
                        $arrSubData = $sub_result->fetch_assoc();

                        $log_txt        = "SUCCESS - [$i] SELECT nba_game_daily_schedule [idx = {$val->idx}]";
                        write_log($log_path, $log_txt, "a");
                    }

                    //변수 초기화
                    $game_id        = empty($arrSubData['game_id'])         ? ''    : $arrSubData['game_id'];
                    $home_id        = empty($arrSubData['home_id'])         ? ''    : $arrSubData['home_id'];
                    $away_id        = empty($arrSubData['away_id'])         ? ''    : $arrSubData['away_id'];
                    $home_alias     = empty($arrSubData['home_alias'])      ? ''    : $arrSubData['home_alias'];
                    $away_alias     = empty($arrSubData['away_alias'])      ? ''    : $arrSubData['away_alias'];
                    $home_points    = empty($arrSubData['home_points'])     ? 0     : $arrSubData['home_points'];
                    $away_points    = empty($arrSubData['away_points'])     ? 0     : $arrSubData['away_points'];
                    $game_status    = empty($arrSubData['game_status'])     ? ''    : $arrSubData['game_status'];

                    $sub_query  = "
                        INSERT INTO lineups_history_score
                          (gc_idx, standard_scheduled, league_id,
                          game_id, game_status,
                          home_id, away_id, home_name, away_name,
                          home_score, away_score, update_date)
                        VALUES
                          ({$arrData['g_sport']}, '{$val->standard_scheduled}', '{$league_id}',
                          '{$game_id}', '{$game_status}',
                          '{$home_id}', '{$away_id}', '{$home_alias}', '{$away_alias}',
                          {$home_points}, {$away_points}, NOW())
                        ON DUPLICATE KEY
                        UPDATE 
                          home_id = '{$home_id}',
                          away_id = '{$away_id}',
                          home_name = '{$home_alias}',
                          away_name = '{$away_alias}',
                          home_score = {$home_points},
                          away_score = {$away_points},
                          game_status = '{$game_status}',
                          update_date = NOW()
                    ";
                    //p($sub_query);
                    $sub_result = $_mysqli->query($sub_query);
                    if ($sub_result) {
                        $log_txt        = "SUCCESS - [$i] INSERT INTO lineups_history_score UPDATE";
                        write_log($log_path, $log_txt, "a");
                    }

                    //경기가 끝난 경우 lineups_history에 경기 점수 업데이트
                    if ($arrSubData['game_status'] == 'closed') {
                        $sub_query2     = "
                            SELECT * FROM lineups_history
                            WHERE 1=1
                              AND game_id = '{$game_id}'
                              {$tb_lineups_history_whereQuery}
                            GROUP BY game_id, player_id
                        ";
                        $sub_result2    = $_mysqli->query($sub_query2);
                        if ($sub_result2) {
                            $j      = 0;

                            while ($arrSubData2 = $sub_result2->fetch_assoc()) {
                                $j++;
                                $game_id        = empty($arrSubData2['game_id'])    ? ''    : $arrSubData2['game_id'];
                                $player_id      = empty($arrSubData2['player_id'])  ? ''    : $arrSubData2['player_id'];

                                //필요 정보 가져오기
                                $sub_query3     = "
                                    SELECT
                                       player_statistics_sp_points,
                                       player_statistics_sp_points_amounts,
                                       player_played,
                                       team_id
                                    FROM nba_game_result_player
                                    WHERE 1=1
                                      AND game_id = '{$game_id}'
                                      AND player_id = '{$player_id}'
                                ";
                                $sub_result3    = $_mysqli2->query($sub_query3);
                                if ($sub_result3) {
                                    $arrSubData3    = $sub_result3->fetch_assoc();

                                    $log_txt        = "SUCCESS - [$i][$j] SELECT nba_game_result_player [player_id = '{$player_id}']";
                                    write_log($log_path, $log_txt, "a");
                                }

                                //$arrSubData3 초기화
                                $player_statistics_sp_points            = !empty($arrSubData3['player_statistics_sp_points'])           ? $arrSubData3['player_statistics_sp_points']           : '{}';
                                $player_statistics_sp_points_amounts    = !empty($arrSubData3['player_statistics_sp_points_amounts'])   ? $arrSubData3['player_statistics_sp_points_amounts']   : 0;
                                $player_played                          = !empty($arrSubData3['player_played'])                         ? $arrSubData3['player_played']                         : 0;

                                $result_status      = 'F';
                                if ($player_statistics_sp_points == '{}') {
                                    $result_status      = 'C';
                                }

                                //업데이트
                                $sub_query3 = "
                                    UPDATE lineups_history
                                    SET
                                      player_result_json = '{$player_statistics_sp_points}',
                                      game_players_points = {$player_statistics_sp_points_amounts},
                                      player_played = {$player_played},
                                      result_status = '{$result_status}',
                                      result_report = 'complete',
                                      reg_update = NOW()
                                    WHERE 1=1
                                      AND game_id = '{$game_id}'
                                      AND player_id = '{$player_id}'
                                ";
                                $sub_result3    = $_mysqli->query($sub_query3);
                                if ($sub_result3) {
                                    $log_txt        = "SUCCESS - [$i][$j] UPDATE lineups_history [player_id = '{$player_id}']";
                                    write_log($log_path, $log_txt, "a");
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    //
    $query  = "
        SELECT g_idx FROM game
        WHERE 1=1
          AND g_league_alias = '{$league_alias}'
          AND g_entry > 0
          AND g_date <= NOW()
          {$tb_game_whereQuery}
          AND result_report = 'out_progress'
    ";
    $result = $_mysqli->query($query);
    if ($result) {
        while ($arrData = $result->fetch_assoc()) {
            $g_idx  = $arrData['g_idx'];

            $sub_query  = "
                UPDATE game
                SET
                  result_report = 'complete'
                WHERE 1=1
                  AND g_idx = {$g_idx}
            ";
            $sub_result = $_mysqli->query($sub_query);
            if ($sub_result) {
                $log_txt        = "SUCCESS - UPDATE game [g_idx = {$g_idx}]";
                write_log($log_path, $log_txt, "a");
            }

            $sub_query  = "
                UPDATE join_contest
                SET
                  jc_status = 0,
                  result_report = 'complete'
                WHERE 1=1
                  AND jc_game = {$g_idx}
            ";
            $sub_result = $_mysqli->query($sub_query);
            if ($sub_result) {
                $log_txt        = "SUCCESS - UPDATE join_contest [jc_game = {$g_idx}]";
                write_log($log_path, $log_txt, "a");
            }
        }
    }

    //커밋
    $_mysqli->commit();
    $_mysqli2->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();  //롤백
    $_mysqli2->rollback();  //롤백
    $log_txt        = "SQL ERROR: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} catch (Exception $e) {
    $_mysqli->rollback();  //롤백
    $_mysqli2->rollback();  //롤백
    $log_txt        .= "ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} finally {
    $log_txt        = "END";
    write_log($log_path, $log_txt, "a");
}
