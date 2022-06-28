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
            idx, created_at AS regdate, content, point, balance
        FROM honor_point_history
        WHERE 1 and m_idx='{$idx}'
        ORDER BY created_at DESC
        LIMIT {$offset}, {$size}
    ";

    $resulthp = $_mysqli->query($query);

    $sub_result     = $_mysqli->query("SELECT Count(*) AS total from honor_point_history where m_idx='{$idx}'");
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
                <div class="contents-cont inner">
                    <table class="contents-table cash-table fp-page">
                        <colgroup>
                            <col style="width:20%">
                            <col style="width:40%">
                            <col style="width:20%">
                            <col style="width:20%">
                        </colgroup>
                        <thead>
                        <tr class="filter">
                            <th><a href="javascript:void(0);">일자</a></th>
                            <th><a href="javascript:void(0);">내용</a></th>
                            <th><a href="javascript:void(0);">전투력</a></th>
                            <th><a href="javascript:void(0);">보유 전투력</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($total > 0){

                            while ($dbhp = $resulthp->fetch_assoc()) {
                                $myhonotpoint = !empty($dbhp['point']) ? ($dbhp['point']) : 0;
                                echo <<<TR
                        <tr>
                            <td class="Fgray">{$dbhp['regdate']}</td>
                            <td class="contents_txt">{$dbhp['content']}</td>
                            <td>+$myhonotpoint</td>
                            <td class="balance">{$dbhp['balance']}</td>
                        </tr>
TR;
                            }
                        }else {
                            echo <<<TR
                         <tr>
                                <td colspan="6">전투력 내역이 없습니다.</td>
                         </tr>
TR;
                        }
                        ?>
                        <!--<tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>콘테스트 결과(G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        -->
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?=$_pg->getPaging();?>
                <!--                <a class="active" href="javascript:void(0)">1</a>
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
