<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 세션 정리
    //p($_SESSION);
    $_se_idx    = !empty($_SESSION['_se_idx'])  ? $_SESSION['_se_idx']  : 0;

    // 파라미터 정리
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    $sub        = !empty($_GET['sub'])      ? $_GET['sub']      : 'upcoming';

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    // 변수 정리
    $where      = '';

    if($sub=='upcoming') {
        $where  .= "
            AND b.g_status IN (0, 1)
        ";
        $liClass    = 'edit';

    } else if($sub=='live') {
        $where  .= "
            AND b.g_status = 2
        ";
        $liClass    = 'live';

    } else if($sub=='finish') {
        $where  .= "
            AND b.g_status = 3
        ";
        $liClass    = 'finish';

    }

    // 로그인 체크
    check_login($_se_idx);

    $sql ="
        SELECT
            count(*)
        FROM lineups a
        LEFT JOIN game b
            ON a.lu_g_idx = b.g_idx
        WHERE 1=1
            AND a.lu_u_idx = {$_se_idx}{$where}
        ORDER BY a.lu_idx DESC
    ";
    //p($sql);
    $result11 = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($result11);
    $total_count = $row1[0]; //전체갯수
    $rows = 6;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    $dbb = $result11->fetch_assoc();

    $sql2 = "SELECT * FROM lineups a LEFT JOIN game b
            ON b.g_idx = a.lu_g_idx LEFT JOIN lineups_history c
           ON c.lu_idx = a.lu_idx WHERE 1=1 AND c.lu_idx = {$dbb['lu_idx']}";

    $result12 = $_mysqli->query($sql2);
} catch (Exception $e) {
    /*p($e);*/
}
?>
<!doctype html>
<html lang="ko">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>

<!--//head-->

<body>
<div id="wrap" class="sub">
    <!--header-->
    <header id="header">
        <?php
        //header
        require_once __DIR__ .'/../common/header.php';
        ?>
    </header>
    <!--//header-->

    <!--container-->
    <<div id="container">
        <!--content-->
        <div id="content">
            <!--sec-01-->
            <section class="sec sec-01 T0 B0">
                <div class="line-up-nav inner">
                    <?php
                    include_once __DIR__ .'/../common/lineups_sub_menu.php';
                    ?>
                </div>
                <div class="inner">
                    <ul class="contest-list lineup-list">
                        <?php
                        if($total_count > 0){
                            $i=0;
                            $query  = "
                                SELECT a.*
                                FROM lineups a
                                LEFT JOIN game b
                                    ON a.lu_g_idx = b.g_idx
                                WHERE 1=1
                                  AND a.lu_u_idx = {$_se_idx}
                                    {$where}
                                ORDER BY a.lu_idx DESC
                                LIMIT {$from_record}, {$rows}
                            ";
                            //p($query);
                            $result = $_mysqli->query($query);
                            if (!$result) {

                            }
                            while ($db = $result->fetch_assoc()) {
                                //p($db);
                                $i++;
                                $sub_query  = "
                                    SELECT * FROM lineups a
                                    LEFT JOIN game b
                                        ON b.g_idx = a.lu_g_idx
                                    LEFT JOIN lineups_history c
                                        ON c.lu_idx = a.lu_idx
                                    WHERE 1=1
                                        AND c.lu_idx = {$db['lu_idx']}
                                ";
                                //p($sub_query);
                                $sub_result = $_mysqli->query($sub_query);

                                $sub_db2 = $sub_result->fetch_assoc();
                                //p($sub_db2);

                                $sub_query2 = "
                                    SELECT 50000-sum(player_salary) as left_salary, b.g_date FROM lineups a
                                    LEFT JOIN game b
                                        ON b.g_idx = a.lu_g_idx
                                    LEFT JOIN lineups_history c
                                        ON c.lu_idx = a.lu_idx
                                    WHERE 1=1
                                        AND c.lu_idx = {$db['lu_idx']}
                                ";
                                //p($sub_query2);
                                $sub_result2 = $_mysqli->query($sub_query2);

                                $sub_db3 = $sub_result2->fetch_assoc();

                                //p($sub_db2);
                                $img_n  = str_replace('/', '', $sub_db2['g_name']);
                                $img_n  = str_replace('%', '', $img_n);
                                switch($sub_db2['g_league_alias']){
                                    CASE 'PUBG':
                                        $img_src = "/images/ico_pubg.png";
                                        $game_img_src = '/images/PUBG/output/'. $img_n .'.jpg';
                                        break;
                                    CASE 'NBA':
                                        $img_src = "/images/ico_pubg.png";
                                        $game_img_src = '/images/img_30multi_50.png';
                                        break;
                                }

                                $left_salary    = number_format($sub_db3['left_salary']);

                                $title      = utf8_substr($sub_db2['g_name'], 0, 24);
                                $reward     = $sub_db2['g_size'] * $sub_db2['g_fee'] * (100 - COMMISSION) / 100;
                                $reward     = number_format($reward);

                                // 상태
                                if ($sub_db2['g_status']==0 || $sub_db2['g_status']==1) {
                                    $link       = "/draft/?edit=1&index={$sub_db2['g_idx']}&lu_idx={$sub_db2['lu_idx']}";
                                    $liClass    = 'edit';
                                    $editTitle  = '<span class="line-up-badge btnPush">수정</span>';
                                    $cursor = '';
                                } else if ($sub_db2['g_status']==2) {
                                    $link       = 'javascript:void(0);';
                                    $liClass    = 'live';
                                    $editTitle  = 'LIVE';
                                    $cursor = '';
                                } else if ($sub_db2['g_status']==3) {
                                    $link       = 'javascript:void(0);';
                                    $liClass    = 'finished';
                                    $editTitle  = '<span class="line-up-badge" >결과</span>';
                                    $cursor = 'style="cursor: default;"';
                                }

                                echo <<<LI
                        <li class="{$liClass}">
                            <a href="{$link}" {$cursor} class="active" title="{$sub_db2['g_name']}">
                                <div class="game-thumb" style="background-image: url('{$game_img_src}')">
                                    <div class="subject">
                                    <img src="{$img_src}" alt="pubg_logo"/>
                                    </div>
                                </div>
                                <div class="contest-desc lineUP">
                                    <div class="conts-desc-l">
                                        <dl>
                                            <dt class="contest-schedule">{$sub_db2['g_date']}</dt>
                                            <dt class="contest-title">{$title}</dt>
                                            <dd class="contest-detail">
                                                <ul>
                                                    <li>{$reward} FP</li>
                                                    <li>{$sub_db2['g_fee']} FP</li>
                                                    <li>{$sub_db2['g_entry']}/{$sub_db2['g_size']}</li>
                                                </ul>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                {$editTitle}
                            </a>
                            <table class="entries-table">
                                <thead>
                                <tr>
                                    <th>참가자 수</th>
                                    <th>잔여 연봉</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{$sub_db2['g_entry']}</td>
                                    <td>{$left_salary}</td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="line-up-table">
                                <thead>
                                <tr>
                                    <th>포지션</th>
                                    <th>이름</th>
                                    <th>구단</th>
                                    <th>연봉</th>
                                </tr>
                                </thead>
                                <tbody>
LI;

                                if (!$sub_result) {
                                }
                                $sub_result->data_seek(0);
                                while ($sub_db = $sub_result->fetch_assoc()) {
                                    //p($sub_db);
                                    if($sub_db['player_pos']=='TL') {
                                        $pos_kr = '오더';
                                    } else if($sub_db['player_pos']=='R') {
                                        $pos_kr = '정찰';
                                    } else if($sub_db['player_pos']=='GR') {
                                        $pos_kr = '포탑';
                                    } else if($sub_db['player_pos']=='AR') {
                                        $pos_kr = '돌격';
                                    } else {
                                        $pos_kr = '유틸';
                                    }
                                    $salary     = number_format($sub_db['player_salary']);

                                    $reward     = $sub_db2['g_size'] * $sub_db2['g_fee'] * (100 - COMMISSION) / 100;

                                    $player_name    = utf8_substr($sub_db['player_name'], 0, 5);

                                    // 팀 정보
                                    $_query = "
                                        SELECT
                                            team_alias
                                        FROM pubg_team_profile_player
                                        WHERE 1=1
                                            AND player_id = '{$sub_db['player_id']}'
                                        LIMIT 1
                                    ";
                                    //p($_query);
                                    $_result = $_mysqli_game->query($_query);
                                    if (!$_result) {

                                    }
                                    $_db    = $_result->fetch_assoc();
                                    $team_name = !empty($_db['team_alias'])  ? $_db['team_alias']    : '';

                                    echo <<<TR
                                <tr>
                                    <td>{$pos_kr}</td>
                                    <td>{$player_name}</td>
                                    <td>{$team_name}</td>
                                    <td>$ {$salary}</td>
                                </tr>
TR;
                                }
                                $sub_result->free();
                                ?>
                                <tr>
                                    <td colspan="4" class="game-total">
                                        <div>
                                            <ul>
                                                <li><p>기대 상금</p><span><?=number_format($reward);?></span></li>
                                                <li><p>총 상금</p><span class="fc-yellow"><?=number_format($reward);?> FP</span></li>
                                                <li><p>수정 시간</p><span><?=$sub_db2['reg_date']?></span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                </table>
                                </li>
                                <?php
                            }
                            $result->free();
                        }
                        ?>
                    </ul>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?php

                echo paging2($page,$total_page,5,$sub,"{$_SERVER['SCRIPT_NAME']}?sub={$sub}&page=");
                ?>
                <!--<a href="javascript:void(0)" class="active" >1</a>
                <a href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">3</a>
                <a href="javascript:void(0)">4</a>-->
            </div>
        </div>
        <!--//content-->
    </div>
    <!--//container-->

    <!--footer-->
    <footer id="footer">
        <?php
        //footer
        require_once __DIR__ .'/../common/footer.php';
        ?>
    </footer>
    <!--//footer-->
</div>
</body>
</html>
