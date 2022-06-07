<?php
// config
require_once __DIR__ . '/../_inc/config.php';

// 파라미터 정리
//p($_REQUEST);exit;
$idx        = filter_input(INPUT_POST, 'id');
$coin       = filter_input(INPUT_POST, 'coin');
$category   = filter_input(INPUT_POST, 'category');
$game       = filter_input(INPUT_POST, 'game');
$player     = filter_input(INPUT_POST, 'player', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

// 세션
$u_idx      = $_SESSION['_se_idx'];

// 변수
$today      = date('Y-m-d H:i:s');
$count      = count($player);

// 현재 엔트리에 이상 없는지 체크할 것
$qry_chk_entry      = "
  SELECT
    g_size, g_entry, g_date, g_multi_max, g_fee 
  FROM game
  WHERE 1=1
    AND g_idx = {$game}
";
//p($qry_chk_entry);
$result_chk_entry   = $_mysqli->query($qry_chk_entry);
$arr_chk_entry      = $result_chk_entry->fetch_array();

$count_size         = $arr_chk_entry[0];
$count_entry        = $arr_chk_entry[1];
$g_date             = date("y-m-d",strtotime($arr_chk_entry[2]));
$g_multi_max        = $arr_chk_entry[3];

if ($count_entry >= $count_size) {
    echo 507;
    exit;
}

//골드가 부족한 경우
$query  = "
    SELECT m_fp_balance FROM members
    WHERE 1=1
      AND m_idx = {$u_idx}
";
//p($query);
$result = $_mysqli->query($query);
$deposit    = 0;
if ($result) {
    $arrDB      = $result->fetch_array();
    //p($arrDB);exit;
    $deposit    = $arrDB['m_fp_balance'];
}

if ($deposit < $arr_chk_entry['g_fee']) {
    echo 411;
    exit;
}

//multi_max 체크
$query  = "
    SELECT COUNT(1) AS CNT FROM lineups
    WHERE 1=1
      AND lu_u_idx = {$u_idx}
      AND lu_g_idx = {$game}
";
//p($query);
$result = $_mysqli->query($query);
$join_cnt   = 0;
if ($result) {
    $arrDB      = $result->fetch_assoc();
    $join_cnt   = $arrDB['CNT'];
    //p($join_cnt);
}

if ($g_multi_max <= $join_cnt) {
    echo 412;
    exit;
}

try {
//트랜잭션
    $_mysqli->begin_transaction();

// 라인업 입력 (향후에는 기존 라이업을 가져왔는지 여부를 체크해서 분기 시킬 것)
    $qry_line = "
      INSERT INTO lineups
        (lu_u_idx, lu_gc_idx, lu_g_idx)
      VALUES
        ({$u_idx}, {$category}, {$game})
    ";
    //p($qry_line);
    $result_line = $_mysqli->query($qry_line);
    if (!$result_line) {
        $_mysqli->rollback();
        echo 501;
        exit;
    }

    $saveIdx = $_mysqli->insert_id;

// 라인업 히스토리에 선수 데이터 넣기
    for ($i = 0; $i < $count; $i++) {
        $arr = get_player_info($_mysqli_game, $player[$i]['player_id'], $category);
        //p($arr);exit;
        //
        switch ($category) {
            case 1:
            case 8:
                $name   = $arr['full_name'];
                $pos    = chg_pos($category, $arr['primary_position']);
                break;
            case 2:
                $name   = $arr['player_first_name'] . ' ' . $arr['player_last_name'];
                $pos    = chg_pos($category, $arr['player_primary_position']);
                break;
            case 3:
                $name   = $arr['player_nickname'];
                $pos    = chg_pos($category, $arr['player_primary_position']);
                break;
            case 4:
            case 5:
            case 7:
                $name   = $arr['full_name'];
                $pos    = chg_pos($category, $arr['primary_position']);
                break;
            case 20:
                $name   = $arr['abbr_name'];
                $pos    = chg_pos($category, $arr['primary_position']);
                break;
        }
        $name = $_mysqli->real_escape_string($name);

        //
        $qry_lh = "
          INSERT INTO lineups_history SET
            lu_idx = {$saveIdx},
            m_idx = {$u_idx}, 
            gc_idx = {$category}, 
            g_idx = {$game}, 
            g_date = '{$g_date}', 
            game_id = '{$player[$i]['game_id']}', 
            player_id = '{$arr['player_id']}', 
            player_name = '{$name}', 
            player_pos = '{$pos}', 
            player_team_id = '{$arr['team_id']}', 
            player_salary = {$arr['player_salary']}, 
            reg_date = now();
        ";
        //p($qry_lh);
        $result_lh = $_mysqli->query($qry_lh);
        if (!$result_lh) {
            $_mysqli->rollback();
            //p($qry_lh);
            echo 502;
            exit;
        }
    }

    $qry_join = "insert into join_contest ";
    $qry_join .= "(jc_u_idx, jc_gc_idx, jc_game, jc_lineups, jc_date) ";
    $qry_join .= "values ";
    $qry_join .= "($u_idx, $category, $game, $saveIdx, '$today') ";
    //p($qry_join);
    $result_join = $_mysqli->query($qry_join);

    if (!$result_join) {
        $_mysqli->rollback();
        //error_log($qry_join);
        echo 503;
        exit;
    }

//회원 머니 차감
    $qry_get_gold = "select m_fp_balance from members where m_idx = {$u_idx}";
    //p($qry_get_gold);
    $result_get_gold = $_mysqli->query($qry_get_gold);

    if (!$result_get_gold) {
        $_mysqli->rollback();
        echo 504;
        exit;

    } else {
        $arr_get_gold = $result_get_gold->fetch_array();
//    $now_gold = bcsub($arr_get_gold[0], $coin);
        $now_gold = digitMath($arr_get_gold[0], $arr_chk_entry['g_fee'], 'minus');
    }
/*
    $qry = "update members set ";
    $qry .= "m_fp_balance = $now_gold ";
    $qry .= "where m_idx= $u_idx ";
    //p($qry);
    $result = $_mysqli->query($qry);

    if (!$result) {
        $_mysqli->rollback();
        echo 505;
        exit;
    }
    */
/*
    // 로그에 쌓음
    $qry_log = "insert into deposit_history set ";
    $qry_log .= "dh_u_idx = $u_idx, ";
    $qry_log .= "dh_amount = -$coin, ";
    $qry_log .= "dh_paymethod = 0, ";
    $qry_log .= "dh_pay_key = 'join_contest', ";
    $qry_log .= "dh_content = 'Join the contest (G{$game})', ";
    $qry_log .= "dh_balance = $now_gold, ";
    $qry_log .= "dh_condition = 1, ";
    $qry_log .= "dh_req_date = '$today', ";
    $qry_log .= "dh_res_date = '$today', ";
    $qry_log .= "game_idx = '$game', ";
    $qry_log .= "game_g_sport = '$category' ";
    //p($qry_log);

    $result_log = $_mysqli->query($qry_log);
    if (!$result_log) {
        $_mysqli->rollback();
        echo 506;
        exit;
    }*/

//게임 참여 카운트 추가
    $qry_game = "update game set ";
    $qry_game .= "g_entry = g_entry + 1 ";
    $qry_game .= "where g_idx= $game ";
    //p($qry_game);
    $result_game = $_mysqli->query($qry_game);

    if ($result_game) {
        //FP 지급
        $fp_content     = "콘테스트참가 (G{$game})";
        $fp             = -$arr_chk_entry['g_fee'];
        $trigger_type   = 'join_contest';
        $trigger_idx    = $game;
        give_fp($_mysqli, $u_idx, $fp_content, $fp, $trigger_type, $trigger_idx);

        $_mysqli->commit();
        echo 100;

    } else {
        $_mysqli->rollback();
        echo 507;
    }

} catch (Exception $e) {
    $_mysqli->rollback();
    p($e);
}
