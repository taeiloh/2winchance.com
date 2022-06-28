<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 파라미터

    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;
    check_login($_se_idx);
    // 변수 정리
    $where      = '';

    $where      .= "
        AND g_status = 2
    ";
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }
    //페이징
/*    $sql = "select count(*) from join_contest where 1=1 and jc_u_idx = '{$_se_idx}'{$where}";
    $tresult = mysqli_query($_mysqli, $sql);
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
                    <table class="contents-table live-table">
                        <colgroup>
                            <col style="width:25.142%">
                            <col style="width:16.572%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
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

                        //현재 honor 포인트 중 가장 큰 잔액을 가져오는 QUERY
                        $balancequery = "SELECT MAX(balance) as balance
                        FROM honor_point_history
                        where m_idx = {$_se_idx};
                        ";
                        $resultbalance = $_mysqli->query($balancequery);
                        $dbb = $resultbalance->fetch_assoc();
                        $balance = $dbb['balance'];

                        if (!$result) {
                        }
                        while ($db = $result->fetch_assoc()) {
                            //p($db);
                            $i = 0;
                            $arrGjson = json_decode($db['g_json'], true);
                            $gamename = $db['g_name'];
                            $jc_game = $db['jc_game'];
                            $g_idx = $db['g_idx'];
                            //p($arrGjson);
                            $i++;
                            //$no = $total_count - ($i + ($page - 1) * $rows);
                            $gamename2 = "콘테스트참가 (G{$g_idx})";

                            echo <<<TR
                        <tr>
                            <td>{$db['g_name']}<span class="contest_num">G({$db['g_idx']})</span></td>
                            <td>{$arrGjson[0]['timezone_scheduled']}</td>
                            <td>{$db['g_prize']}</td>
                            <td>{$db['jc_prize']}</td>
                            <td>{$db['g_size']}</td>
                            <td>{$db['g_multi_max']}</td>
                            <!--<td><button type="button">수정</button></td>-->
<!--                            <td><button type="button"><img src="../images/ico_share_blue.svg" alt="공유하기">초대</button></td>-->
                            <td>
                            </td>
                        </tr>
TR;
                            $selectquery = "SELECT count(g_idx) as cnt from honor_point_history WHERE 1=1 and m_idx = $_se_idx and g_idx = $jc_game";
                            $result2 = $_mysqli->query($selectquery);
                            $db2 = $result2->fetch_assoc();
                            $g_idxcount = $db2['cnt'];

                            //p($selectquery);

                            if($g_idxcount < 1)
                            {
                                $insertquery = "
                            INSERT INTO honor_point_history
                            (m_idx, content, point,g_idx, balance) VALUES ($_se_idx, '$gamename2', 0 ,$jc_game, $balance)";
                                $_mysqli->query($insertquery);
                                $g_idxcount = 0;
                            }
                        }


                        if(empty($result->num_rows)) {
                            echo <<<TR
                         <tr>
                                <td colspan="7">LIVE 중인 콘테스트가 없습니다.</td>
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
                <?php
                //echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                ?>
               <!-- <a href="javascript:void(0)" class="active">1</a>
                <a class="" href="javascript:void(0)">2</a>
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