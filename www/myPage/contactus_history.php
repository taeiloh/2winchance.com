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
    $page       = !empty($_GET['page'])     ? $_GET['page']     : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page = 1;
    }

    //변수 정리
    $size           = PAGING_SIZE;
    $offset         = ($page - 1) * $size;
    $scale          = PAGING_SCALE;
    $where          = '';

    // db
    $query  = "
        SELECT
            cu_idx, DATE_FORMAT(cu_req_date, '%Y-%m-%d %h:%i:%s') AS regdate, cu_subject, cu_status
        FROM contactus
        WHERE 1=1 and cu_u_idx='{$idx}'
        ORDER BY cu_req_date DESC
        LIMIT {$offset}, {$size}
    ";

    $result1 = $_mysqli->query($query);

    $sub_result     = $_mysqli->query("SELECT Count(*) AS total from contactus where cu_u_idx='{$idx}'");
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

<form id="contact" action="contactus_detail.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="cu_idx" id="cu_idx" value="">
</form>
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
        <div id="content" class="myqna">
            <!--sec-01-->
            <section class="sec sec-01 T0 myAcct">
                <?php
                //header
                require_once __DIR__ . '/../common/category.php';
                ?>
<!--                <div class="category inner">-->
<!--                    <ul>-->
<!--                        <li><a href="javascript:void(0)">MY ACCOUNT</a></li>-->
<!--                        <li class="active"><a href="javascript:void(0)">1 : 1 HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">CASH HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">FP HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">게임 가이드</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="contents-cont inner">
                    <table class="contents-table personalQna">
                        <colgroup>
                            <col style="width:10%">
                            <col style="width:25%">
                            <col style="width:45%">
                            <col style="width:20%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th><a href="javascript:void(0);">번호</a></th>
                            <th><a href="javascript:void(0);">날짜</a></th>
                            <th><a href="javascript:void(0);">제목</a></th>
                            <th><a href="javascript:void(0);">처리상태</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($total > 0){
                                $i = -1;
                                $rows = 10;
                                while ($dbCu = $result1->fetch_assoc()) {
                                    $cu_seq  = empty(!$dbCu['cu_idx']) ? $dbCu['cu_idx'] : '';
                                    $cu_status = empty(!$dbCu['cu_status']) ? $dbCu['cu_status'] : 0;
                                    $i++;
                                    $no=$total-($i+($page-1)*$rows);
                                    if ($cu_status == 0) {
                                        $cu_status = '<span style="color: gold">대기중</span>';
                                    }else if($cu_status == 1){
                                        $cu_status = '<span style="color: #9f9f9f">상담완료</span>';
                                    }
                                    echo <<<TR
                        <tr style="cursor: default;">
                            <td>{$no}</td>
                            <td class="Fgray">{$dbCu['regdate']}</td>
                            <td><a style="width: 100%; cursor: pointer;" onclick="sel_List({$cu_seq})">{$dbCu['cu_subject']}</a></td>
                            <td>{$cu_status}</td>
                        </tr>
TR;
                                }
                            }else{
                                    echo <<<TR
                         <tr>
                                <td colspan="4">아직 문의하신 내역이 없습니다.</td>
                         </tr>
TR;
                            }
                        ?>
                        </tbody>
                    </table>
                </div>

            </section>
            <!--//sec-01-->
            <div class="qna-btn-box inner">
                <div style="width: 15rem;"></div>
                <div class="pagination">
                    <?=$_pg->getPaging();?>
<!--                    <a href="javascript:void(0)">1</a>-->
<!--                    <a class="active" href="javascript:void(0)">2</a>-->
<!--                    <a href="javascript:void(0)">3</a>-->
<!--                    <a href="javascript:void(0)">4</a>-->
                </div>
                <button class="btn-blue btn-6" onclick="location.href='contactus.php'">문의하기</button>
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
<script type="text/javascript">
    function sel_List(seq){
        $("#cu_idx").val(seq);
        $("#contact").submit();
    }
</script>
