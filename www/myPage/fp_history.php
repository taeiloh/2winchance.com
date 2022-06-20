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
try{

    //파라미터 정리
    $page               = !empty($_GET['page'])             ? $_GET['page']             : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    //변수 정리
    $size           = PAGING_SIZE;
    $offset         = ($page - 1) * $size;
    $scale          = PAGING_SCALE;
    $where          = '';


    //db
    $query ="
        SELECT
            fph_idx, DATE_FORMAT(created_at,'%Y-%m-%d %h:%i:%s') AS regdate, fph_content, fph_point, fph_balance
        FROM fantasy_point_history
        WHERE 1 and fph_m_idx='{$idx}'
        ORDER BY created_at DESC
        LIMIT {$offset}, {$size}
    ";

    $resultfp = $_mysqli->query($query);

    $sub_result     = $_mysqli->query("SELECT Count(*) AS total from fantasy_point_history where fph_m_idx='{$idx}'");
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
<!--                        <li><a href="javascript:void(0)">CASH HISTORY</a></li>-->
<!--                        <li class="active"><a href="javascript:void(0)">FP HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">게임 가이드</a></li>-->
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
                        <tr class="filter">
                            <th><a href="javascript:void(0);">일자</a></th>
                            <th><a href="javascript:void(0);">내용</a></th>
                            <th><a href="javascript:void(0);">FP</a></th>
                            <th><a href="javascript:void(0);">FP 잔액</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($total > 0){
                            while ($dbfp = $resultfp->fetch_assoc()) {
                                $fp = $dbfp['fph_point'];
                                $setfp = '';
                                if($fp > 0) {
                                    $setfp = '+';
                                    echo <<<TR
                        <tr>
                            <td class="Fgray">{$dbfp['regdate']}</td>
                            <td>{$dbfp['fph_content']}</td>
                            <td>{$setfp}$fp</td>
                            <td>{$dbfp['fph_balance']}</td>
                        </tr>
TR;
                                }
                                else{

                                    echo <<< TR
                        <tr>
                            <td class="Fgray">{$dbfp['regdate']}</td>
                            <td>{$dbfp['fph_content']}</td>
                            <td><span class="fc-red">$fp</span></td>
                            
                            <td class="balance">{$dbfp['fph_balance']}</td>
                        </tr>
TR;

                                }
                            }
                        }else {
                            echo <<<TR
                         <tr>
                                <td colspan="6">FP 내역이 없습니다.</td>
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