<?php
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임

$_topic = '';
if (!$idx) {

    $url    = $_SERVER['REQUEST_URI'];

    $msg    = '로그인 페이지로 이동합니다.';

    $url    = '/login/index.php?rtnUrl='. $url;

    alertReplace($msg, $url);

    exit;

}
try {

    $cu_idx =!empty($_POST['cu_idx']) ? $_POST['cu_idx'] : '';
    $query  = "
        SELECT
            cu_idx, DATE_FORMAT(cu_req_date, '%Y-%m-%d %h:%i:%s') AS regdate, cu_subject, cu_status, cu_response, cu_message, cu_topic
        FROM contactus
        WHERE 1=1 and cu_idx='{$cu_idx}'
        
    ";

    $result = $_mysqli->query($query);
    $cu_result = $result->fetch_assoc();
    $cu_status = !empty($cu_result['cu_status']) ? $cu_result['cu_status'] : 0;
    if ($cu_status == 0) {
        $cu_status = '<span style="color: gold">대기중</span>';
    }   else if($cu_status == 1){
        $cu_status = '<span style="color: #9f9f9f">상담완료</span>';
    }


    switch ($cu_result['cu_topic']){
        case '1' :
            $_topic  = '계정 제한';
            break;
        case '2' :
            $_topic  = '광고';
            break;
        case '3' :
            $_topic  = '보너스';
            break;
        case '4' :
            $_topic  = '상점';
            break;
        case '5' :
            $_topic  = '불만 사항';
            break;
        case '6' :
            $_topic  = '콘테스트';
            break;
        case '7' :
            $_topic  = '기타';
            break;
        case '8' :
            $_topic  = '로그인';
            break;
        case '9' :
            $_topic  = '제안';
            break;
        case '10' :
            $_topic  = '기술적 문제';
            break;
        default:

    }

} catch (mysqli_sql_exception $e){
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
<form id="contactus_detail" action="contactus_history.php" method="post" enctype="multipart/form-data">
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
                <div class="contents-cont inner qna-wrap">
                    <div class="board-box">
                            <h3 class="footer-sub-title">문의하기</h3>
                        <div class="inquiry-wrap">
                            <div class="inquiry-title">
                                <div>
                                    <p><?=$cu_result['cu_subject']?></p>
                                    <div class="notice_info">
                                        <span><?=$cu_result['regdate']?></span>
<!--                                        <span>18:54:34</span>-->
                                    </div>
                                </div>
                            </div>
                            <div class="txt-box">
                                <p class="inquiry-type"><?=$_topic?></p>
                                <p><?=$cu_result['cu_message']?></p>
                            </div>
                        </div>
                        <div class="answer-wrap">
                            <div class="inquiry-title">
                                <div>
                                    <p>답변</p>
                                </div>
                            </div>
                            <div class="txt-box">
<!--                                <p>답변 대기중</p>-->
                                <p><?=$cu_status?></p>
<!--                                <p>안녕하세요. 정글못해먹겐네 님<br/>-->
<!--                                    불편을 드려서 죄송합니다.<br/>-->
<!--                                    <br/>-->
<!--                                    혹시 전원을 끄고 다시 켜보셨는지요. 그래도 실행이되<br/>-->
<!--                                    지 않는다면 다시 문의 주시기 바랍니다.<br/>-->
<!--                                    항상 노력하는 2WC되겠습니다.<br/>-->
<!--                                    감사합니다.</p>-->
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!--//sec-01-->
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