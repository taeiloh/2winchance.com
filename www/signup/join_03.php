<?php
// config
require_once __DIR__ .'/../_inc/config.php';


$m_sns_type       = !empty($_POST['m_sns_type'])           ? strtoupper($_POST['m_sns_type'])         : '';
$m_sns_id       = !empty($_POST['m_sns_id'])           ? strtoupper($_POST['m_sns_id'])         : '';

if($m_sns_id!=""){
    $action="sns_insert_proc.php";
}else{
    $action="join_04.php";
}


try {

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
<form id="loginFrm" name="loginFrm" method="post" action="<?=$action?>">
    <input type="hidden" name="m_sns_type" id="m_sns_type" value="<?=$m_sns_type ?>"/>
    <input type="hidden" name="m_sns_id" id="m_sns_id" value="<?=$m_sns_id?>"/>

<div id="wrap" class="member">
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="/main/index.php"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
        <section class="sec sec-01">
            <div class="inner">
                <div class="title">
                    <ul class="step">
                        <li></li>
                        <li class="active"></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <h2>계정 생성</h2>
                </div>
                <div class="sub-content">
                    <h3>본인 확인</h3>
                    <p class="sub-txt">
                        본인 인증이 완료 되었습니다.
                    </p>
                    <button type="submit" class="btn-blue btn-6" >다음</button>
                </div>
            </div>
        </section>
        <!--//sec-01-->
        <!--//content-->
    </div>
    <footer>
        © 2022 METAGAMES, Inc. All Rights Reserved.
    </footer>
</div>
</form>
</body>
</html>