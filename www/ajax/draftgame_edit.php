<?php
// config
require_once __DIR__ . '/../_inc/config.php';

// 세션
$u_idx      = $_SESSION['_se_idx'];

// 파라미터 정리
//p($_REQUEST);
$edit       = filter_input(INPUT_POST, 'edit');
$idx        = filter_input(INPUT_POST, 'id');
$lu_idx     = filter_input(INPUT_POST, 'lu_idx');
$coin       = filter_input(INPUT_POST, 'coin');
$category   = filter_input(INPUT_POST, 'category');
$game       = filter_input(INPUT_POST, 'game');
$player     = filter_input(INPUT_POST, 'player', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

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

try {
//트랜잭션
    $_mysqli->begin_transaction();

    //기존 라인업 지우기
    $del_query  = "
        DELETE FROM lineups_history
        WHERE 1=1
          AND lu_idx = {$lu_idx}
    ";
    $del_result = $_mysqli->query($del_query);
    if (!$del_result) {
        $_mysqli->rollback();
        echo 500;
        exit;
    }

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
            lu_idx = {$lu_idx},
            m_idx = $u_idx, 
            gc_idx = $category, 
            g_idx = $game, 
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

    $_mysqli->commit();
    echo 100;

} catch (Exception $e) {
    $_mysqli->rollback();
    p($e);
}
