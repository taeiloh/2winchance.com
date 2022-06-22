<?php
// config
require_once __DIR__ .'/../_inc/config.php';

// 클래스
require_once __DIR__ .'/../class/RankReward.php';
require_once __DIR__ .'/../class/Game.php';

try {
    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;
    check_login($_se_idx);

    // 파라미터
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;

    // 변수 정리
    $cate       = 20;
    $where      = '';
    $where      .= "
        AND g_status IN (0, 1)
    ";

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }
    //페이징
    /*
    $sql = "select count(*) from join_contest where 1=1 and jc_u_idx = '{$_se_idx}'{$where}";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 10;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함*/
    //페이징
    /*$sql  = "
                            SELECT
                                count(*)
                            FROM
                            (
                                SELECT
                                    jc_idx
                                FROM join_contest
                                WHERE 1=1
                                    AND jc_u_idx = {$_se_idx}
                            ) b INNER JOIN join_contest
                                ON join_contest.jc_idx = b.jc_idx
                            LEFT JOIN lineups
                                ON lu_idx = jc_lineups
                            LEFT JOIN game
                                ON g_idx = jc_game
                            LEFT JOIN game_category
                                ON gc_idx = g_sport
                            LEFT JOIN members
                                ON m_idx = lu_u_idx
                            WHERE 1=1
                                AND lu_u_idx = {$_se_idx}
                                {$where} ";

    $tresult = $_mysqli->query($sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 10;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함*/


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
    <script>
        function invite(cate, sub_menu, gidx, gdate) {
            var url = "<?=SSLWWW;?>/lobby/list.php?cate="+ cate +"&sub_menu="+ sub_menu +"&g_date="+ gdate +"&gidx="+ gidx;
            $("#share_url").val(url);

            copy_url();
        }
    </script>
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
    <div id="container">
        <!--content-->
        <div id="content">
            <!--sec-01-->
            <section class="sec sec-01 T0">
                <div class="contents-nav inner">
                    <?php
                    // nav
                    require_once __DIR__ .'/../common/nav_contests.php';
                    ?>
                </div>

                <div class="contents-cont inner">
                    <!--<div>
                        <input type="search" placeholder="콘테스트를 검색해주세요.">
                    </div>-->
                    <table class="contents-table upcomming-table">
                        <colgroup>
                            <col style="width:25%"/>
                            <col style="width:20%"/>
                            <col style="width:10%"/>
                            <col style="width:10%"/>
                            <col style="width:10%"/>
                            <col style="width:10%"/>
                            <col style="width:10%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th>콘테스트</th>
                            <th>경기시작 시간</th>
                            <th>총 상금</th>
                            <th>1등 상금</th>
                            <th>참여자 수</th>
                            <th>중복</th>
                            <th>상태</th>
                            <!--<th>
                                <button class="search-btn"></button>
                            </th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        /*
                        // 콘테스트
                        $query  = "
                            SELECT
                                join_contest.*,
                                game.*,
                                game_category.gc_name
                            FROM
                            (
                                SELECT
                                    jc_idx
                                FROM join_contest
                                WHERE 1=1
                                    AND jc_u_idx = {$_se_idx}
                            ) b INNER JOIN join_contest
                                ON join_contest.jc_idx = b.jc_idx
                            LEFT JOIN lineups
                                ON lu_idx = jc_lineups
                            LEFT JOIN game
                                ON g_idx = jc_game
                            LEFT JOIN game_category
                                ON gc_idx = g_sport
                            LEFT JOIN members
                                ON m_idx = lu_u_idx
                            WHERE 1=1
                                AND lu_u_idx = {$_se_idx}
                                {$where}
                            GROUP BY jc_game
                            ORDER BY g_date DESC, jc_result DESC
                        ";
                        */
                        // 콘테스트
                        $query  = "
                            SELECT
                                jc.*,
                                g.*
                            FROM join_contest jc
                            LEFT JOIN game g
                                ON jc.jc_game = g.g_idx
                            WHERE 1=1
                                AND jc_u_idx = {$_se_idx}
                                {$where}
                            ORDER BY jc_date DESC
                        ";
                        //p($query);
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }

                        while ($db = $result->fetch_assoc()) {
                            //p($db);
                            $rankReward     = new RankReward($db['g_size'], $db['g_fee'], $db['g_prize'], $db['g_entry']);
                            $total_reward   = number_format($rankReward->getTotal_reward());
                            $getFirst_place = number_format($rankReward->getFirst_place());

                            $gameInfo       = new Game($cate, $_mysqli);
                            $sub_menu       = $gameInfo->getSub_menu($db['g_prize']);
                            $g_date         = substr($db['g_date'], 0, 10);
                            echo <<<TR
                        <tr>
                            <td>{$db['g_name']}<span class="contest_num">G({$db['g_idx']})</span></td>
                            <td>{$db['g_date']}</td>
                            <td>{$total_reward}</td>
                            <td>{$getFirst_place}</td>
                            <td>{$db['g_entry']}/{$db['g_size']}</td>
                            <td>{$db['g_multi_max']}</td>
                            <td><button type="button" onclick="go_url('/draft/?edit=1&index={$db['g_idx']}&lu_idx={$db['jc_lineups']}')">수정</button></td>
                            <!-- <td><button type="button" onclick="invite({$cate}, {$sub_menu}, {$db['g_idx']}, '{$g_date}');"><img src="/images/ico_share_blue.svg" alt="공유하기">초대</button></td> -->
                        </tr>
TR;
                        }

                        if(empty($result->num_rows)) {
                            echo <<<TR
                         <tr>
                                <td colspan="7">대기중인 콘테스트가 없습니다.</td>
                         </tr>
TR;
                        }
                        ?>
                        <!--tr>
                            <td>{$db['g_name']}</td>
                            <td>{$arrGjson[0]['timezone_scheduled']}</td>
                            <td>{$db['g_prize']}</td>
                            <td>{$db['jc_prize']}</td>
                            <td>{$db['g_size']}</td>
                            <td>{$db['g_multi_max']}</td>
                            <td><button type="button">수정</button></td>
                            <td><button type="button"><img src="/images/ico_share_blue.svg" alt="공유하기">초대</button></td>
                        </tr-->
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?php
                //echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                ?>
<!--                <a href="javascript:void(0)" class="active" >1</a>-->
<!--                <a href="javascript:void(0)">2</a>-->
<!--                <a href="javascript:void(0)">3</a>-->
<!--                <a href="javascript:void(0)">4</a>-->
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
<input type="text" id="share_url" value="" style="display: none;"/>
</body>
</html>
