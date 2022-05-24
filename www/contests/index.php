<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 파라미터

    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;

    // 변수 정리
    $where      = '';

    $where      .= "
        AND (g_status = 0 OR g_status = 1)
    ";

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
                    <table class="contents-table upcomming-table">
                        <colgroup>
                            <col style="width:25.142%">
                            <col style="width:16.572%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:5.524%">
                            <col style="width:5.524%">
                            <col style="width:5.524%">
                            <col style="width:25.142%">
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
                            <th>
                                <input type="search" placeholder="콘테스트를 검색해주세요.">
                                <button class="search-btn"></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
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
                        //p($query);
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            //p($db);

                            $arrGjson   = json_decode($db['g_json'], true);
                            //p($arrGjson);
                            echo <<<TR
                        <tr>
                            <td>{$db['g_name']}</td>
                            <td>{$arrGjson[0]['timezone_scheduled']}</td>
                            <td>{$db['g_prize']}</td>
                            <td>{$db['jc_prize']}</td>
                            <td>{$db['g_size']}</td>
                            <td>{$db['g_multi_max']}</td>
                            <td><button type="button">수정</button></td>
                            <td><button type="button"><img src="../images/ico_share_blue.svg" alt="공유하기">초대</button></td>
                        </tr>
TR;

                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <a href="javascript:void(0)" class="active" >1</a>
                <a href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">3</a>
                <a href="javascript:void(0)">4</a>
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