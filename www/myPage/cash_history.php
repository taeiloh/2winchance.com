<?php
require_once __DIR__ .'/../_inc/config.php';

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
    //페이징
    $sql = "select count(*) from deposit_history where 1=1 and dh_u_idx = '{$idx}'";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 10;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    // db
    $query  = "
        select 
              dh_idx, DATE_FORMAT(dh_req_date,'%Y-%m-%d %h:%i:%s') AS regdate, dh_content,
               dh_condition, dh_amount, dh_balance, dh_pay_key, dh_deposit,dh_cash_type
        from deposit_history
        WHERE dh_u_idx = '{$idx}'
        order by dh_idx desc
        LIMIT {$from_record}, {$rows}
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
                        if($total_count > 0){
                            $i = 0;
                            $total_amount1=0;
                            while ($dbgold = $result_cash->fetch_assoc()) {
                                $title = empty(!$dbgold['dh_content']) ? $dbgold['dh_content'] : '';
                                $regdate = empty(!$dbgold['regdate']) ? $dbgold['regdate'] : '';
                                $tid = empty(!$dbgold['dh_pay_key']) ? $dbgold['dh_pay_key'] : '';
                                $amount = empty(!$dbgold['dh_amount']) ? $dbgold['dh_amount'] : '';
                                $balance = empty(!$dbgold['dh_balance']) ? $dbgold['dh_balance'] : 0;
                                $deposit = empty(!$dbgold['dh_deposit']) ? $dbgold['dh_deposit'] : 0;
                                $total_amount = !empty($_arrAmount['total_amount']) ? $_arrAmount['total_amount'] : 0;
                                $dh_cash_type = !empty($dbgold['dh_cash_type']) ? $dbgold['dh_cash_type'] : '';
                                $i++;
                                $no=$total_count-($i+($page-1)*$rows);
                                $total_amount=$total_amount-$total_amount1;
                                echo <<<TR
                        <tr>
                            <td class="Fgray">{$regdate}</td>
                            <td>{$title}</td>
                            <!--td>{$tid}</td-->
                            <td>{$dh_cash_type}</td>
                            <td>{$deposit}</td>
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
                <?php
                echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                ?>
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