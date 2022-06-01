<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-12-18
 * Time: 오전 11:19
 */

//config
require __DIR__ .'/../../inc/config.php';

try {
    //변수 정리
    $data = array();
    $ymd = date('Ymd');

    $log_folder = __DIR__ . '/log/summary';
    $log_filename = "{$ymd}_Update_Db_Summary.log";
    $log_path = $log_folder . '/' . $log_filename;
    $log_txt = "Start";
    write_log($log_path, $log_txt, "a");

    //변수 정리
    $season_year    = NBA_SEASON_YEAR;
    $season_type    = NBA_SEASON_TYPE;
    $season_id      = NBA_SEASON_ID; //년도별 시즌 id
    $league_alias   = NBA_LEAGUE_ALIAS;
    $league_id      = NBA_LEAGUE_ID;
    $content_type   = NBA_CONTENT_TYPE;

    //트랜잭션
    $_mysqli2->begin_transaction();

    //끝난 경기 game_id 가져오기
    $query  = "
        SELECT * FROM pubg_game_daily_schedule
        WHERE 1=1
            AND result_report = 'out_progress'
    ";
    p($query);
    $result = $_mysqli2->query($query);
    if ($result) {
        $i      = 0;
        $rows   = $result->num_rows;

        while ($arrData = $result->fetch_assoc()) {
            $i++;
            progressBar($i, $rows);

            //변수 정리
            $game_id        = $arrData['game_id'];
            $home_id        = $arrData['home_id'];
            $home_name      = $arrData['home_name'];
            $home_alias     = $arrData['home_alias'];
            $away_id        = $arrData['away_id'];
            $away_name      = $arrData['away_name'];
            $away_alias     = $arrData['away_alias'];

            //json 파일
            $json_folder    = __DIR__ . '/json/summary';
            $json_filename  = "{$game_id}.json";
            $json_path      = $json_folder . '/' . $json_filename;

            $json_data      = file_get_contents($json_path);
            $json           = json_decode($json_data, true);
            //print_r($json);

            $data['season_id']      = $season_id;
            $data['league_id']      = $league_id;
            $data['league_alias']   = $league_alias;
            $data['game_id']        = $json['id'];
            $data['game_status']    = $json['status'];
            $data['standard_scheduled']  = date('Y-m-d H:i:s', strtotime($json['scheduled']));
            $data['duration']       = empty($json['duration']) ? '00:00:00' : $json['duration'];
            $data['quarter']        = $json['quarter'];

            $data['home_id']        = $_mysqli2->real_escape_string($json['home']['id']);
            $data['home_name']      = $_mysqli2->real_escape_string($json['home']['name']);
            $data['home_points']    = empty($json['home']['points']) ? 0 : $json['home']['points'];
            $data['home_bonus']     = empty($json['home']['bonus']) ? 0 : $json['home']['bonus'];
            $data['home_scoring']   = $_mysqli2->real_escape_string(json_encode($json['home']['scoring']));

            $data['away_id']        = $_mysqli2->real_escape_string($json['away']['id']);
            $data['away_name']      = $_mysqli2->real_escape_string($json['away']['name']);
            $data['away_points']    = empty($json['away']['points']) ? 0 : $json['away']['points'];
            $data['away_bonus']     = empty($json['away']['bonus']) ? 0 : $json['away']['bonus'];
            $data['away_scoring']   = $_mysqli2->real_escape_string(json_encode($json['away']['scoring']));

            //game_result
            $sub_query  = "
                SELECT * FROM pubg_game_result
                WHERE 1=1
                    AND game_id = '{$game_id}'
            ";
            p($sub_query);
            $sub_result = $_mysqli2->query($sub_query);
            if ($sub_result) {
                //데이터가 없는 경우 등록
                $sub_rows   = $sub_result->num_rows;

                if ($sub_rows == 0) {
                    //game_result 등록
                    $sub_query  = "
                        INSERT INTO pubg_game_result
                            (season_id, season_type, league_id, league_alias,
                            game_id, game_status, standard_scheduled, duration,
                            quarter, home_name, home_id, home_points,
                            home_bonus, home_scoring, away_name, away_id,
                            away_points, away_bonus, away_scoring, update_date) 
                        VALUES 
                            ('{$season_id}', '{$season_type}', '{$league_id}', '{$league_alias}',
                            '{$game_id}', '{$data['game_status']}', '{$data['standard_scheduled']}', '{$data['duration']}',
                            '{$data['quarter']}', '{$data['home_name']}', '{$data['home_id']}', '{$data['home_points']}',
                            '{$data['home_bonus']}', '{$data['home_scoring']}', '{$data['away_name']}', '{$data['away_id']}',
                            '{$data['away_points']}', '{$data['away_bonus']}', '{$data['away_scoring']}', NOW())
                    ";
                    p($sub_query);
                    $sub_result = $_mysqli2->query($sub_query);
                    if ($sub_result) {
                        $log_txt        = "SUCCESS - [{$i}] INSERT INTO nba_game_result []";
                        write_log($log_path, $log_txt, "a");
                    }

                    $sub_query  = "
                        UPDATE pubg_game_daily_schedule
                        SET
                            home_points = {$data['home_points']},
                            away_points = {$data['away_points']}
                        WHERE 1=1
                            AND game_id = '{$game_id}'
                    ";
                    //p($sub_query);
                    $sub_result = $_mysqli2->query($sub_query);
                    if ($sub_result) {
                        $log_txt        = "SUCCESS - [{$i}] UPDATE nba_game_daily_schedule [game_id = {$game_id}]";
                        write_log($log_path, $log_txt, "a");
                    }
                }
            }

            //game_result_player
            //p($json);
            for ($tmp=0; $tmp<2; $tmp++) {
                if ($tmp == 0) {
                    $team_type          = 'home';
                    $team_alias         = $home_alias;
                    $match_team_type    = $away_alias;

                } else {
                    $team_type          = 'away';
                    $team_alias         = $away_alias;
                    $match_team_type    = $home_alias;
                }
                $team_id    = $json[$team_type]['id'];


                if (is_array($json[$team_type]['players'])) {
                    foreach ($json[$team_type]['players'] as $val) {
                        $full_name          = $_mysqli2->real_escape_string($val['full_name']);

                        //p($val);
                        if (!empty($val['played'])) {
                            $player_played  = 1;
                        } else {
                            $player_played  = 0;
                        }
                        if (!empty($val['active'])) {
                            $player_active  = 1;
                        } else {
                            $player_active  = 0;
                        }

                        //선수 포인트
                        $arrStatistics      = $val['statistics'];
                        $minutes            = empty($arrStatistics['minutes'])          ? ''    : $arrStatistics['minutes'];
                        $field_goals_made   = empty($arrStatistics['field_goals_made']) ? 0     : $arrStatistics['field_goals_made'];
                        $field_goals_att    = empty($arrStatistics['field_goals_att'])  ? 0     : $arrStatistics['field_goals_att'];
                        $three_points_made  = empty($arrStatistics['three_points_made'])? 0     : $arrStatistics['three_points_made'];
                        $three_points_att   = empty($arrStatistics['three_points_att']) ? 0     : $arrStatistics['three_points_att'];
                        $two_points_made    = empty($arrStatistics['two_points_made'])  ? 0     : $arrStatistics['two_points_made'];
                        $two_points_att     = empty($arrStatistics['two_points_att'])   ? 0     : $arrStatistics['two_points_att'];
                        $rebounds           = empty($arrStatistics['rebounds'])         ? 0     : $arrStatistics['rebounds'];
                        $assists            = empty($arrStatistics['assists'])          ? 0     : $arrStatistics['assists'];
                        $turnovers          = empty($arrStatistics['turnovers'])        ? 0     : $arrStatistics['turnovers'];
                        $steals             = empty($arrStatistics['steals'])           ? 0     : $arrStatistics['steals'];
                        $blocks             = empty($arrStatistics['blocks'])           ? 0     : $arrStatistics['blocks'];
                        $personal_fouls     = empty($arrStatistics['personal_fouls'])   ? 0     : $arrStatistics['personal_fouls'];
                        $points             = empty($arrStatistics['points'])           ? 0     : $arrStatistics['points'];

                        //점수 계산
                        $opp                = $match_team_type;
                        $mpg                = $minutes;
                        $fgm_fga            = $field_goals_made + $field_goals_att;
                        $tpm_tpa            = $three_points_made + $three_points_att;
                        $ftm_fta            = $two_points_made + $two_points_att;
                        $pts                = $fgm_fga + $tpm_tpa + $ftm_fta;
                        $reb                = $rebounds;
                        $ast                = $assists;
                        $blk                = $blocks;
                        $stl                = $steals;
                        $pf                 = $personal_fouls;
                        $to                 = $turnovers;
                        $ppg                = $field_goals_made + ($three_points_made * 3) + ($two_points_made * 2);

                        //json 만들기
                        $arrSummary         = array();
                        $arrSummary['summary']  = array(
                            'opp'       => $opp,
                            'mpg'       => $mpg,
                            'fgm_fga'   => $fgm_fga,
                            '3pm-3pa'   => $tpm_tpa,
                            'ftm-fta'   => $ftm_fta,
                            'pts'       => $pts,
                            'reb'       => $reb,
                            'ast'       => $ast,
                            'blk'       => $blk,
                            'stl'       => $stl,
                            'pf'        => $pf,
                            'to'        => $to,
                            'ppg'       => $ppg
                        );
                        $player_statistics_summary  = urldecode(json_encode($arrSummary));

                        //더블 포인트 체크
                        $double_counts  = 0;
                        if ($points > 10) {
                            $double_counts++;
                        }
                        if ($rebounds > 10) {
                            $double_counts++;
                        }
                        if ($assists > 10) {
                            $double_counts++;
                        }
                        if ($steals > 10) {
                            $double_counts++;
                        }
                        if ($blocks > 10) {
                            $double_counts++;
                        }
                        if ($double_counts > 2) {
                            $double     = NBA_TRIPLE_DOUBLE;
                        } else if ($double_counts > 1) {
                            $double     = NBA_DOUBLE_DOUBLE;
                        } else {
                            $double     = 0;
                        }
                        $db_points      = $points * NBA_POINTS;
                        $db_tpm         = $three_points_made * NBA_THREE_POINTS_MADE;
                        $db_rebounds    = $rebounds * NBA_REBOUNDS;
                        $db_assists     = $assists * NBA_ASSISTS;
                        $db_steals      = $steals * NBA_STEALS;
                        $db_blocks      = $blocks * NBA_BLOCKS;
                        $db_turnovers   = $turnovers * NBA_TURNOVERS;
                        $db_double      = $double_counts;
                        $player_statistics_sp_points_amounts    = $db_points + $db_tpm + $db_rebounds + $db_assists + $db_steals + $db_blocks + $db_turnovers + $db_double;

                        //json 만들기
                        $arrSp_points   = array();
                        $arrSp_points['sp_points']   = array(
                            'points'            => $points,
                            'three_points_made' => $three_points_made,
                            'rebounds'          => $rebounds,
                            'assists'           => $assists,
                            'steals'            => $steals,
                            'blocks'            => $blocks,
                            'turnovers'         => $db_turnovers,
                            'double_counts'     => $double_counts
                        );
                        $player_statistics_sp_points    = urldecode(json_encode($arrSp_points));

                        //DB
                        $sub_query  = "
                            INSERT INTO pubg_game_result_player
                              (season_id, league_id, league_alias, season_type,
                              game_id, game_status, standard_scheduled,
                              team_type, team_id, team_alias,
                              player_id, player_name, primary_position, player_played,
                              player_active, player_statistics_summary, player_statistics_sp_points, player_statistics_sp_points_amounts,
                              update_date)
                            VALUES
                              ('{$data['season_id']}', '{$data['league_id']}', '{$data['league_alias']}', '{$season_type}',
                              '{$data['game_id']}', '{$data['game_status']}', '{$data['standard_scheduled']}',
                              '{$team_type}', '{$team_id}', '{$team_alias}',
                              '{$val['id']}', '{$full_name}', '{$val['primary_position']}', {$player_played}, 
                              {$player_active}, '{$player_statistics_summary}', '{$player_statistics_sp_points}', '{$player_statistics_sp_points_amounts}', 
                              now())
                            ON DUPLICATE KEY
                            UPDATE 
                              season_id = '{$data['season_id']}',
                              league_id = '{$data['league_id']}',
                              league_alias = '{$data['league_alias']}',
                              season_type = '{$season_type}',
                              game_id = '{$data['game_id']}',
                              game_status = '{$data['game_status']}',
                              standard_scheduled = '{$data['standard_scheduled']}',
                              team_type = '{$team_type}',
                              team_id = '{$team_id}',
                              team_alias = '{$team_alias}',
                              player_id = '{$val['id']}',
                              player_name = '{$full_name}',
                              primary_position = '{$val['primary_position']}',
                              player_played = {$player_played},
                              player_active = {$player_active},
                              player_statistics_summary = '{$player_statistics_summary}',
                              player_statistics_sp_points = '{$player_statistics_sp_points}',
                              player_statistics_sp_points_amounts = '{$player_statistics_sp_points_amounts}',
                              update_date = now()
                        ";
                        //p($sub_query);
                        $sub_result = $_mysqli2->query($sub_query);
                        if ($sub_result) {
                            $log_txt        = "SUCCESS - [{$i}] INSERT INTO nba_game_result_player UPDATE";
                            write_log($log_path, $log_txt, "a");
                        }

                        //tem_profile_player 업데이트
                        $sub_query  = "
                            UPDATE pubg_team_profile_player
                            SET
                              player_point = (
                                SELECT 
                                  ROUND(AVG(player_statistics_sp_points_amounts), 2)
                                FROM pubg_game_result_player
                                WHERE 1=1
                                  AND player_id = '{$val['id']}'
                                  AND season_id = '{$data['season_id']}'
                                  AND league_id = '{$data['league_id']}'
                              )
                            WHERE 1=1
                              AND player_id = '{$val['id']}'
                        ";
                        //p($sub_query);
                        $sub_result = $_mysqli2->query($sub_query);
                        if ($sub_result) {
                            $log_txt        = "SUCCESS - [{$i}] UPDATE pubg_team_profile_player [player_id = {$val['id']}]";
                            write_log($log_path, $log_txt, "a");
                        }
                    }
                }
            }

        }
    }

    //평균값 업데이트
    $query  = "
        SELECT player_id, ROUND(AVG(player_statistics_sp_points_amounts), 2) as player_amounts_average 
        FROM pubg_game_result_player
        WHERE 1=1
            AND league_id = '{$league_id}'
        GROUP BY player_id
    ";
    $result= $_mysqli2->query($query);
    if ($result) {
        while ($_arrData = $result->fetch_assoc()) {
            $sub_query  = "
                UPDATE pubg_team_profile_player
                SET
                  player_point = {$_arrData['player_amounts_average']}
                WHERE 1=1
                  AND player_id = '{$_arrData['player_id']}'
            ";
            $sub_result = $_mysqli2->query($sub_query);
            if ($sub_result) {
                $log_txt        = "SUCCESS - UPDATE nba_game_result_player [player_id = {$_arrData['player_id']}]";
                write_log($log_path, $log_txt, "a");
            }
        }
    }

    //시즌 평균 업데이트
    $query  = "
        SELECT player_id FROM pubg_team_profile_player
    ";
    $result = $_mysqli2->query($query);

    if ($result) {
        $i      = 0;
        $rows   = $result->num_rows;

        while ($_arrData = $result->fetch_assoc()) {
            $i++;
            progressBar($i, $rows);

            //현재 시즌
            $sub_query  = "
                SELECT 
                  player_id, seasons_year, seasons_teams_total
                FROM pubg_team_profile_player_seasons
                WHERE 1=1
                  AND seasons_year = {$season_year}
                  AND player_id = '{$_arrData['player_id']}'
            ";
            $sub_result = $_mysqli2->query($sub_query);
            $_rst       = $sub_result->fetch_assoc();
            //p($_rst);exit;
            $_arrRst    = (array) json_decode($_rst['seasons_teams_total']);

            //이전 시즌
            $last_seasons_year  = $season_year - 1;
            $sub_query  = "
                SELECT 
                  player_id, seasons_year, seasons_teams_total
                FROM pubg_team_profile_player_seasons
                WHERE 1=1
                  AND seasons_year = {$last_seasons_year}
                  AND player_id = '{$_arrData['player_id']}'
            ";
            $sub_result = $_mysqli2->query($sub_query);
            $_lst       = $sub_result->fetch_assoc();
            //p($_lst);exit;
            $_arrLst    = (array) json_decode($_lst['seasons_teams_total']);

            //데이터셋
            //regular_season
            $rst_games_played           = isset($_arrRst['games_played'])      ? $_arrRst['games_played']         : 0;
            $rst_minutes                = isset($_arrRst['minutes'])           ? $_arrRst['minutes']              : 0;
            $rst_field_goals_made       = isset($_arrRst['field_goals_made'])  ? $_arrRst['field_goals_made']     : 0;
            $rst_field_goals_att        = isset($_arrRst['field_goals_att'])   ? $_arrRst['field_goals_att']      : 0;
            $rst_two_points_made        = isset($_arrRst['two_points_made'])   ? $_arrRst['two_points_made']      : 0;
            $rst_two_points_att         = isset($_arrRst['two_points_att'])    ? $_arrRst['two_points_att']       : 0;
            $rst_three_points_made      = isset($_arrRst['three_points_made']) ? $_arrRst['three_points_made']    : 0;
            $rst_three_points_att       = isset($_arrRst['three_points_att'])  ? $_arrRst['three_points_att']     : 0;
            $rst_rebounds               = isset($_arrRst['rebounds'])          ? $_arrRst['rebounds']             : 0;
            $rst_assists                = isset($_arrRst['assists'])           ? $_arrRst['assists']              : 0;
            $rst_turnovers              = isset($_arrRst['turnovers'])         ? $_arrRst['turnovers']            : 0;
            $rst_steals                 = isset($_arrRst['steals'])            ? $_arrRst['steals']               : 0;
            $rst_blocks                 = isset($_arrRst['blocks'])            ? $_arrRst['blocks']               : 0;
            $rst_foulouts               = isset($_arrRst['foulouts'])          ? $_arrRst['foulouts']             : 0;
            $rst_points                 = isset($_arrRst['points'])            ? $_arrRst['points']               : 0;

            //last_season
            $lst_games_played           = isset($_arrLst['games_played'])      ? $_arrLst['games_played']         : 0;
            $lst_minutes                = isset($_arrLst['minutes'])           ? $_arrLst['minutes']              : 0;
            $lst_field_goals_made       = isset($_arrLst['field_goals_made'])  ? $_arrLst['field_goals_made']     : 0;
            $lst_field_goals_att        = isset($_arrLst['field_goals_att'])   ? $_arrLst['field_goals_att']      : 0;
            $lst_two_points_made        = isset($_arrLst['two_points_made'])   ? $_arrLst['two_points_made']      : 0;
            $lst_two_points_att         = isset($_arrLst['two_points_att'])    ? $_arrLst['two_points_att']       : 0;
            $lst_three_points_made      = isset($_arrLst['three_points_made']) ? $_arrLst['three_points_made']    : 0;
            $lst_three_points_att       = isset($_arrLst['three_points_att'])  ? $_arrLst['three_points_att']     : 0;
            $lst_rebounds               = isset($_arrLst['rebounds'])          ? $_arrLst['rebounds']             : 0;
            $lst_assists                = isset($_arrLst['assists'])           ? $_arrLst['assists']              : 0;
            $lst_turnovers              = isset($_arrLst['turnovers'])         ? $_arrLst['turnovers']            : 0;
            $lst_steals                 = isset($_arrLst['steals'])            ? $_arrLst['steals']               : 0;
            $lst_blocks                 = isset($_arrLst['blocks'])            ? $_arrLst['blocks']               : 0;
            $lst_foulouts               = isset($_arrLst['foulouts'])          ? $_arrLst['foulouts']             : 0;
            $lst_points                 = isset($_arrLst['points'])            ? $_arrLst['points']               : 0;

            //regular
            $regular_season_total               = array();
            $regular_season_total['gp']         = round($rst_points, 2);
            $regular_season_total['mpg']        = round($rst_minutes, 2);
            $regular_season_total['fgm-fga']    = round(($rst_field_goals_made  + $rst_field_goals_att), 2);
            $regular_season_total['3pm-3pa']    = round(($rst_three_points_made + $rst_three_points_att), 2);
            $regular_season_total['ftm-fta']    = round(($rst_two_points_made   + $rst_two_points_att), 2);
            $regular_season_total['reb']        = round($rst_rebounds);
            $regular_season_total['ast']        = round($rst_assists);
            $regular_season_total['blk']        = round($rst_blocks);
            $regular_season_total['stl']        = round($rst_steals);
            $regular_season_total['pf']         = round($rst_foulouts);
            $regular_season_total['to']         = round($rst_turnovers);
            if (empty($rst_games_played)) {
                $regular_season_total['ppg']    = 0;

            } else {
                $regular_season_total['ppg']        = round(($rst_points / $rst_games_played), 2);
            }

            $regular_season_average             = array();
            $regular_season_average['gp']       = 0;
            if (empty($rst_games_played)) {
                $regular_season_average['mpg']      = 0;
                $regular_season_average['fgm-fga']  = 0;
                $regular_season_average['3pm-3pa']  = 0;
                $regular_season_average['ftm-fta']  = 0;
                $regular_season_average['reb']      = 0;
                $regular_season_average['ast']      = 0;
                $regular_season_average['blk']      = 0;
                $regular_season_average['stl']      = 0;
                $regular_season_average['pf']       = 0;
                $regular_season_average['to']       = 0;
                $regular_season_average['ppg']      = 0;

            } else {
                $regular_season_average['mpg']      = round(($rst_minutes   / $rst_games_played), 2);
                $regular_season_average['fgm-fga']  = round((($rst_field_goals_made + $rst_field_goals_att) / $rst_games_played), 2);
                $regular_season_average['3pm-3pa']  = round((($rst_three_points_made + $rst_three_points_att) / $rst_games_played), 2);
                $regular_season_average['ftm-fta']  = round((($rst_two_points_made   + $rst_two_points_att) / $rst_games_played), 2);
                $regular_season_average['reb']      = round(($rst_rebounds  / $rst_games_played), 2);
                $regular_season_average['ast']      = round(($rst_assists   / $rst_games_played), 2);
                $regular_season_average['blk']      = round(($rst_blocks    / $rst_games_played), 2);
                $regular_season_average['stl']      = round(($rst_steals    / $rst_games_played), 2);
                $regular_season_average['pf']       = round(($rst_foulouts  / $rst_games_played), 2);
                $regular_season_average['to']       = round(($rst_turnovers / $rst_games_played), 2);
                $regular_season_average['ppg']      = round(($rst_points / $rst_games_played), 2);
            }

            //last
            $last_season_total                      = array();
            $last_season_total['gp']                = round($lst_points);
            $last_season_total['mpg']               = round($lst_minutes);
            $last_season_total['fgm-fga']           = round(($lst_field_goals_made  + $lst_field_goals_att), 2);
            $last_season_total['3pm-3pa']           = round(($lst_three_points_made + $lst_three_points_att), 2);
            $last_season_total['ftm-fta']           = round(($lst_two_points_made   + $lst_two_points_att), 2);
            $last_season_total['reb']               = round($lst_rebounds);
            $last_season_total['ast']               = round($lst_assists);
            $last_season_total['blk']               = round($lst_blocks);
            $last_season_total['stl']               = round($lst_steals);
            $last_season_total['pf']                = round($lst_foulouts);
            $last_season_total['to']                = round($lst_turnovers);
            if (empty($lst_games_played)) {
                $last_season_total['ppg']           = 0;

            } else {
                $last_season_total['ppg']           = round(($lst_points / $lst_games_played), 2);
            }

            $last_season_average                    = array();
            $last_season_average['gp']              = 0;
            if (empty($lst_games_played)) {
                $last_season_average['mpg']         = 0;
                $last_season_average['fgm-fga']     = 0;
                $last_season_average['3pm-3pa']     = 0;
                $last_season_average['ftm-fta']     = 0;
                $last_season_average['reb']         = 0;
                $last_season_average['ast']         = 0;
                $last_season_average['blk']         = 0;
                $last_season_average['stl']         = 0;
                $last_season_average['pf']          = 0;
                $last_season_average['to']          = 0;
                $last_season_average['ppg']         = 0;

            } else {
                $last_season_average['mpg']         = round(($lst_minutes   / $lst_games_played), 2);
                $last_season_average['fgm-fga']     = round((($lst_field_goals_made  + $lst_field_goals_att) / $lst_games_played), 2);
                $last_season_average['3pm-3pa']     = round((($lst_three_points_made + $lst_three_points_att) / $lst_games_played), 2);
                $last_season_average['ftm-fta']     = round((($lst_two_points_made   + $lst_two_points_att) / $lst_games_played), 2);
                $last_season_average['reb']         = round(($lst_rebounds  / $lst_games_played), 2);
                $last_season_average['ast']         = round(($lst_assists   / $lst_games_played), 2);
                $last_season_average['blk']         = round(($lst_blocks    / $lst_games_played), 2);
                $last_season_average['stl']         = round(($lst_steals    / $lst_games_played), 2);
                $last_season_average['pf']          = round(($lst_foulouts  / $lst_games_played), 2);
                $last_season_average['to']          = round(($lst_turnovers / $lst_games_played), 2);
                $last_season_average['ppg']         = round(($lst_points / $lst_games_played), 2);
            }

            //informally
            $informally         = array();
            if (empty($rst_games_played)) {
                $informally['mpg']  = 0;
                $informally['ppg']  = 0;
                $informally['rpg']  = 0;
                $informally['apg']  = 0;
                $informally['bpg']  = 0;

            } else {
                $informally['mpg']  = round(($rst_minutes   / $rst_games_played), 2);
                $informally['ppg']  = round((($rst_field_goals_made  + $rst_field_goals_att) + ($rst_three_points_made + $rst_three_points_att) + (($rst_two_points_made   + $rst_two_points_att)) / $rst_games_played), 2);
                $informally['rpg']  = round(($rst_rebounds  / $rst_games_played), 2);
                $informally['apg']  = round(($rst_assists   / $rst_games_played), 2);
                $informally['bpg']  = round(($rst_blocks    / $rst_games_played), 2);
            }

            //group
            $_group                             = array();
            $_group['informally']               = $informally;
            $_group['regular_season_total']     = $regular_season_total;
            $_group['regular_season_average']   = $regular_season_average;
            $_group['last_season_total']        = $last_season_total;
            $_group['last_season_average']      = $last_season_average;

            $player_statistics_season           = urldecode(json_encode($_group));

            //DB 업데이트
            $sub_query  = "
                UPDATE pubg_team_profile_player
                SET
                  player_statistics_season = '{$player_statistics_season}'
                WHERE 1=1
                  AND player_id = '{$_arrData['player_id']}' 
            ";
            $sub_result = $_mysqli2->query($sub_query);
            if ($sub_result) {
                $log_txt        = "SUCCESS - [{$i}] UPDATE nba_team_profile_player [player_id = {$_arrData['player_id']}]";
                write_log($log_path, $log_txt, "a");
            }
        }
    }

    //커밋
    $_mysqli2->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli2->rollback();  //롤백
    $log_txt        = "SQL ERROR: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} catch (Exception $e) {
    $_mysqli2->rollback();  //롤백
    $log_txt        .= "ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} finally {
    $log_txt        = "END";
    write_log($log_path, $log_txt, "a");
}
