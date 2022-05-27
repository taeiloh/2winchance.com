<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;
    check_login($_se_idx);
    // 변수 정리
    $where      = '';

    $page = !empty($_GET['page']) ? $_GET['page'] : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    $sql ="select count(*) FROM lineups a 
                            LEFT JOIN game b
                                ON a.lu_g_idx = b.g_idx
                            WHERE 1=1
                              AND a.lu_u_idx = {$_se_idx}
                            ORDER BY a.lu_idx DESC";
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
    p($e);
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
                    <ul>
                        <li class="active"><a href="javascript:void(0)">ALL</a></li>
                        <li class="active"><a href="javascript:void(0)">대기</a></li>
                        <li class="active"><a href="javascript:void(0)">LIVE</a></li>
                        <li class="active"><a href="javascript:void(0)">결과</a></li>
                    </ul>
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
                            ORDER BY a.lu_idx DESC
                            LIMIT {$from_record}, {$rows}
                        ";
                            //p($query);
                            $result = $_mysqli->query($query);
                            if (!$result) {

                            }
                            while ($db = $result->fetch_assoc()) {
                                $i++;
                                //p($db);
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

                                $sub_query2 = "
                                SELECT 50000-sum(player_salary) as left_salary, b.g_date FROM lineups a
                                LEFT JOIN game b 
                                    ON b.g_idx = a.lu_g_idx
                                LEFT JOIN lineups_history c 
                                    ON c.lu_idx = a.lu_idx
                                WHERE 1=1
                                    AND c.lu_idx = {$db['lu_idx']}
                            ";
                                $sub_result2 = $_mysqli->query($sub_query2);

                                $sub_db3 = $sub_result2->fetch_assoc();

                                switch($sub_db2['g_league_alias']){
                                    CASE 'PUBG':
                                        $img_src = "../images/pubg_logo.png";
                                        $game_img_src = '../images/img_30multi_50.png';
                                    CASE 'NBA':
                                        $img_src = "../images/pubg_logo.png";
                                        $game_img_src = '../images/img_30multi_50.png';
                                }

                                echo <<<LI
                        <li class="edit">
                            <a href="javascript:void(0)" class="active">
                                <div class="game-thumb" style="background-image: url('$game_img_src')">
                                    <div class="subject">
                                    <img src="$img_src" alt="pubg_logo">
                                    </div>
                                </div>
                                <div class="contest-desc lineUP">
                                    <div class="conts-desc-l">
                                        <div class="contest-ico">
                                             <img src="../images/item2.png" alt="임시">

                                        </div>
                                        <dl>
                                            <dt class="contest-schedule">{$sub_db2['g_date']}</dt>
                                            <dt class="contest-title">{$sub_db2['g_name']}</dt>
                                            <dd class="contest-detail">
                                                <ul>
                                                    <li><img src="../images/ico_pin.svg" class="mR5" alt="위치">LAS</li>
                                                    <li>{$sub_db2['g_size']}</li>
                                                    <li>1,254 Slots</li>
                                                </ul>
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="current-price">
                                        <p>PRIZE</p>
                                        <span>{$sub_db2['g_fee']}</span>
                                    </div>
                                </div>
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
                                    <td>{$sub_db3['left_salary']}</td>
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
                                while ($sub_db = $sub_result->fetch_assoc()) {
                                    //p($sub_db);

                                    echo <<<TR
                                <tr>
                                    <td>{$sub_db['player_pos']}</td>
                                    <td>{$sub_db['player_name']}</td>
                                    <td></td>
                                    <td>$ {$sub_db['player_salary']}</td>
                                </tr>                                
TR;
                                }
                                ?>
                                <tr>
                                    <td colspan="4" class="game-total">
                                        <div>
                                            <ul>
                                                <li><p>기대 상금</p><span>702</span></li>
                                                <li><p>총 상금</p><span class="fc-yellow">702</span></li>
                                                <li><p>수정 시간</p><span><?=$sub_db3['g_date']?></span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                </table>
                                </li>
                                <?php
                            }
                        }

                        $result->free();
                        $sub_result->free();
                        ?>
                    </ul>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?php
                echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
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