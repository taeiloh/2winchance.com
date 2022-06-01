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
 * Date: 2018-03-14
 * Time: 오후 3:32
 */

//config
require __DIR__ .'/../../inc/config.php';

//변수
$gc_idx = 1; //20181029 진경수 (NBA만 처리(game_category gc_idx))
$title  = 'result_rank';

//변수 정리
$data = array();
$ymd = date('Ymd');

//로그
$log_folder = __DIR__ . '/log/rank';
$log_filename = "{$ymd}_result_rank.log";
$log_path = $log_folder . '/' . $log_filename;
$log_txt = "Start";
write_log($log_path, $log_txt, "a");

//결과 처리할 리스트
$qry    = "
    SELECT jc_game FROM join_contest 
    WHERE 1=1
        AND jc_gc_idx = {$gc_idx} 
        AND result_report = 'complete'   /* complete 일 때 처리 */  # EDIT /  User: Alex.kim / Date: 2018-06-26 16:54
    GROUP BY jc_game 
    ORDER BY jc_game 
";
//p($qry);
$res    = $_mysqli->query($qry);
if ($res) {

    while ($arrData = $res->fetch_assoc()) {
        $jc_game    = $arrData['jc_game'];

        //로그
        $log_txt        = "jc_game: {$jc_game}";
        write_log($log_path, $log_txt, "a");

        //
        $qry1    = "
            SELECT lu_u_idx, lu_idx, players_points FROM (
                SELECT
                  a.lu_u_idx, a.lu_idx, SUM(b.game_players_points) as players_points 
                FROM lineups a LEFT JOIN lineups_history b 
                ON a.lu_idx = b.lu_idx
                WHERE 1=1
                  AND a.lu_g_idx = {$jc_game}
                GROUP BY a.lu_u_idx, a.lu_idx
            ) AS T
            ORDER BY players_points DESC
        ";
        //p($qry1);
        $res1   = $_mysqli->query($qry1);
        if ($res1) {
            $cnt        = 0;
            $rank       = 0;
            $prize      = 0;

            while ($rankData = $res1->fetch_assoc()) {
                $cnt++;
                $lu_u_idx           = $rankData['lu_u_idx'];
                $lu_idx             = $rankData['lu_idx'];
                $players_points     = $rankData['players_points'];
                $old_points         = $players_points;

                if ($players_points != $old_points) {
                    $rank           = $cnt;
                } else {
                    $rank++;
                }

                //log
                $log_txt        = "SUCCESS - rank: {$rank}, lu_u_idx: {$lu_u_idx}, lu_idx: {$lu_idx}, players_points: {$players_points}";
                write_log($log_path, $log_txt, "a");

                //결과 테이블 반영
                $qry2 = "
                    UPDATE join_contest SET
                      jc_point = {$players_points},
                      jc_rank = {$rank},
                      jc_prize = {$prize},
                      result_report = 'calculate',    # ADD /  User: Alex.kim / Date: 2018-06-26 16:54
                      jc_result_update = NOW()
                    WHERE 1=1
                      AND jc_u_idx = {$lu_u_idx}
                      AND jc_game = {$jc_game}
                      AND jc_lineups = {$lu_idx}
                ";
                //p($qry2);
                $res2   = $_mysqli->query($qry2);
                if ($res2) {
                    //log
                    $log_txt        = "SUCCESS - UPDATE game [jc_u_idx = {$lu_u_idx}]";
                    write_log($log_path, $log_txt, "a");

                } else {
                    //log
                    $log_txt        = "ERROR - {$qry2} ";
                    write_log($log_path, $log_txt, "a");
                    exit;
                }

                $old_points = $players_points;
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

//log
$log_txt        = "END";
write_log($log_path, $log_txt, "a");
