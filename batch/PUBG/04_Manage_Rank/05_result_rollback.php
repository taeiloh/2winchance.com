<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2019-02-13
 * Time: 오전 6:57
 */

//config
require __DIR__ .'/../../inc/config.php';

try {
    //트랜잭션
    $_mysqli->begin_transaction();

    //변수 define
    $g_sport        = 1; //20190213 진경수 (NBA만 처리(game_category gc_idx))
    $ymd            = ''; //롤백할 날짜 (2019-02-12)

    //로그
    $log_folder     = __DIR__ . '/log/rollback';
    $log_filename   = "{$ymd}_result_rollback.log";
    $log_path       = $log_folder . '/' . $log_filename;
    $log_txt        = "Start";
    write_log($log_path, $log_txt, "a");

    //define
    $season_year    = NBA_SEASON_YEAR;
    $season_type    = NBA_SEASON_TYPE;
    $season_id      = NBA_SEASON_ID; //년도별 시즌 id
    $league_alias   = NBA_LEAGUE_ALIAS;
    $league_id      = NBA_LEAGUE_ID;
    $content_type   = NBA_CONTENT_TYPE;

    if (empty($ymd)) {
        echo 'Input ymd';
        exit;
    }

    //03 Result Lineups 롤백 (result_report = 'out_progress' 로 처리)
    $query  = "
        UPDATE game
        SET
          result_report = 'out_progress'
        WHERE 1=1
          AND g_sport = {$g_sport}
          AND g_league_alias = '{$league_alias}'
          AND g_entry > 0
          AND g_date BETWEEN '{$ymd} 00:00:00' AND '{$ymd} 23:59:59'
          AND result_report = 'finished'
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        throw new Exception('UPDATE error');
    }
    $log_txt        = "SUCCESS - UPDATE game SET result_report = 'out_progress'";
    write_log($log_path, $log_txt, "a");

    //롤백할 데이터를 가져온다.
    $query  = "
        SELECT
          a.g_idx,
          b.dh_u_idx, b.dh_amount, b.game_g_sport
        FROM game a INNER JOIN deposit_history b
        ON a.g_idx = b.game_idx
        WHERE 1=1
          AND a.g_sport = {$g_sport}
          AND g_league_alias = '{$league_alias}'
          AND a.g_date BETWEEN '{$ymd} 00:00:00' AND '{$ymd} 23:59:59'
          AND b.dh_pay_key IN ('contest_cancel', 'contest_result')
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        throw new Exception('SELECT error');
    }
    $log_txt        = "SUCCESS - SELECT";
    write_log($log_path, $log_txt, "a");

    while ($_data = $result->fetch_assoc()) {
        $_g_idx         = empty($_data['g_idx'])        ? 0     : $_data['g_idx'];
        $_dh_u_idx      = empty($_data['dh_u_idx'])     ? 0     : $_data['dh_u_idx'];
        $_dh_amount     = empty($_data['dh_amount'])    ? 0     : $_data['dh_amount'];
        $_game_g_sport  = empty($_data['game_g_sport']) ? 0     : $_data['game_g_sport'];

        //롤백 데이터 정의
        $_dh_pay_key    = 'contest_result_error';
        $_dh_content    = "Contest result error (G{$_g_idx})";
        $_dh_amount     = - $_dh_amount; //이미 지급된 골드 마이너스 처리

        //members.m_deposit 반영
        $_query = "
            UPDATE members
            SET
              m_deposit = m_deposit + {$_dh_amount}
            WHERE 1=1
              AND m_idx = {$_dh_u_idx}
            LIMIT 1
        ";
        //p($_query);
        $_result    = $_mysqli->query($_query);
        if (!$_result) {
            throw new Exception('UPDATE members error');
        }
        $log_txt        = "SUCCESS - [{$_g_idx}] [{$_dh_u_idx}] UPDATE members SET m_deposit = m_deposit + {$_dh_amount}";
        write_log($log_path, $log_txt, "a");

        //deposit_history 반영
        $_query = "
            INSERT INTO deposit_history
              (dh_u_idx, dh_amount, dh_paymethod, dh_pay_key, dh_content,
              dh_condition, dh_balance, dh_req_date, dh_res_date, game_idx,
              game_g_sport)
            VALUES
              ({$_dh_u_idx}, {$_dh_amount}, 0, '{$_dh_pay_key}', '{$_dh_content}',
              1, (SELECT m_deposit FROM members WHERE m_idx={$_dh_u_idx}), NOW(), NOW(), {$_g_idx},
              {$_game_g_sport})
        ";
        //p($_query);
        $_result    = $_mysqli->query($_query);
        if (!$_result) {
            throw new Exception('INSERT INTO deposit_history error');
        }
        $log_txt        = "SUCCESS - [{$_g_idx}] [{$_dh_u_idx}] INSERT INTO deposit_history ({$_dh_u_idx}, {$_dh_amount}, 0, '{$_dh_pay_key}', '{$_dh_content}', 1, (SELECT m_deposit FROM members WHERE m_idx={$_dh_u_idx}), NOW(), NOW(), {$_g_idx}, {$_game_g_sport})";
        write_log($log_path, $log_txt, "a");
    }

    //커밋
    $_mysqli->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        = "SQL ERROR: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} catch (Exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        .= "ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} finally {
    $log_txt        = "END";
    write_log($log_path, $log_txt, "a");
}
