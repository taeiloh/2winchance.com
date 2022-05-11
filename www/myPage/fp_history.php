<?php
require_once __DIR__ .'/../_inc/config.php';

//로그인 체크
//check_login();

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try{

    //파라미터 정리
    $page       = !empty($_GET['page'])     ? $_GET['page']     : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    //페이징
    $sql = "select count(*) from fantasy_point_history where 1=1";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 5;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    //db
    $query ="
        SELECT
            created_at, fph_content, fph_point, fph_balance
        FROM fantasy_point_history
        WHERE 1=1
        ORDER BY created_at DESC
        LIMIT {$from_record}, {$rows}
    ";

    $result = $_mysqli->query($query);

}catch (mysqli_sql_exception $e){
    $arrRtn['code']     = $e->getCode();
    $arrRtn['msg']      = $e->getMessage();
    echo json_encode($arrRtn);
} catch (Exception $e){
    $arrRtn['code']     = $e->getCode();
    $arrRtn['msg']      = $e->getMessage();
    echo json_encode($arrRtn);
} finally {

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
            <section class="sec sec-01 T0 myAcct">
                <?php
                //header
                require_once __DIR__ . '/../common/category.php';
                ?>
<!--                <div class="category inner">-->
<!--                    <ul>-->
<!--                        <li><a href="javascript:void(0)">MY ACCOUNT</a></li>-->
<!--                        <li><a href="javascript:void(0)">1 : 1 HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">CASH HISTORY</a></li>-->
<!--                        <li class="active"><a href="javascript:void(0)">FP HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">HOW TO PLAY</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="contents-cont inner">
                    <table class="contents-table cash-table fp-page">
                        <colgroup>
                            <col style="width:25%">
                            <col style="width:25%">
                            <col style="width:25%">
                            <col style="width:25%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th><a href="javascript:void(0);">DATE</a></th>
                            <th><a href="javascript:void(0);">CONTENT</a></th>
                            <th><a href="javascript:void(0);">FP</a></th>
                            <th><a href="javascript:void(0);">BALANCE</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php




                        ?>





                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <a href="javascript:void(0)">1</a>
                <a class="active" href="javascript:void(0)">2</a>
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