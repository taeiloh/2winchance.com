<?php
require_once __DIR__ .'/../_inc/config.php';
require_once __DIR__ .'/../_inc/paging.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);

if (!$idx) {

    $url    = $_SERVER['REQUEST_URI'];

    $msg    = '로그인 페이지로 이동합니다.';

    $url    = '/login/index.php?rtnUrl='. $url;

    alertReplace($msg, $url);

    exit;

}
try {
    //파라미터 정리
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    //변수 정리
    $size           = PAGING_SIZE;
    $offset         = ($page - 1) * $size;
    $scale          = PAGING_SCALE;
    $where          = '';

    // db
    $query  = "
        select 
              dh_idx, DATE_FORMAT(dh_req_date,'%Y-%m-%d %h:%i:%s') AS regdate, dh_content,
               dh_condition, dh_amount, dh_balance, dh_pay_key, dh_deposit,dh_cash_type
        from deposit_history
        WHERE dh_u_idx = '{$idx}'
        order by dh_idx desc
        LIMIT {$offset}, {$size}
    ";


    $result_cash = $_mysqli->query($query);

    //캐시잔액
    $query2 = "
        SELECT sum(dh_amount) as total_amount FROM deposit_history
        WHERE 1 AND dh_u_idx = '{$idx}'
    ";
    $result2 = $_mysqli->query($query2);
    $_arrAmount = $result2->fetch_array();

    //print $total_amount;

    $sub_result     = $_mysqli->query("SELECT Count(*) AS total from deposit_history where dh_u_idx='{$idx}'");
    $sub_dbarray    = $sub_result->fetch_array();
    $total          = $sub_dbarray['total'];
    $sub_result->free();

    //페이징
    $_pg    = new PAGING($total, $page, $size, $scale);


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
<!--                        <li class="active"><a href="javascript:void(0)">CASH HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">FP HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">게임 가이드</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="contents-cont inner">
                    <table class="contents-table cash-table">
                        <colgroup>
                            <col style="width:25%">
                            <col style="width:25%">
                            <!--col style="width:10%"-->
                            <col style="width:20%">
                            <col style="width:12%">
                            <col style="width:10%">
                            <col style="width:12%">
                        </colgroup>
                        <thead>
                        <tr class="filter">
                            <th><a href="javascript:void(0);">일자</a></th>
                            <th>내용</th>
                            <!--th><a href="javascript:void(0);">거래ID</a></th-->
                            <th><a href="javascript:void(0);">결제 정보</a></th>
                            <th><a href="javascript:void(0);">금액(KRW)</a></th>
                            <th><a href="javascript:void(0);">캐시</a></th>
                            <th><a href="javascript:void(0);">캐시 잔액</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($total > 0){
                            $total_amount1=0;
                            while ($dbgold = $result_cash->fetch_assoc()) {
                                $tid = empty(!$dbgold['dh_pay_key']) ? $dbgold['dh_pay_key'] : '';
                                $amount = empty(!$dbgold['dh_amount']) ? $dbgold['dh_amount'] : '';
                                $total_amount = !empty($_arrAmount['total_amount']) ? $_arrAmount['total_amount'] : 0;
                                $total_amount=$total_amount-$total_amount1;
                                echo <<<TR
                        <tr>
                            <td class="Fgray">{$dbgold['regdate']}</td>
                            <td>{$dbgold['dh_content']}</td>
                            <!--td>{$tid}</td-->
                            <td>{$dbgold['dh_cash_type']}</td>
                            <td>{$dbgold['dh_deposit']}</td>
                            <td>{$amount}</td>
                            <td>{$total_amount}</td>
                        </tr>
TR;
                                $total_amount1 +=$amount;
                            }
                        }else {
                            echo <<<TR
                         <tr>
                                <td colspan="7">등록된 게시글이 없습니다.</td>
                         </tr>
TR;
                        }

                        ?>

<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>Join the contest (G55362)</td>-->
<!--                            <td>Join</td>-->
<!--                            <td>spo - bit</td>-->
<!--                            <td>-</td>-->
<!--                            <td class="">- 60</td>-->
<!--                            <td>4,946</td>-->
<!--                        </tr>-->
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?=$_pg->getPaging();?>
<!--                <a class="active" href="javascript:void(0)">1</a>-->
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
</body>
</html>