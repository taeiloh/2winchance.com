<?php
// config
require_once __DIR__ .'/../_inc/config.php';

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

<body>
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
                        <li></li>
                        <li></li>
                        <li></li>
                        <li class="active"></li>
                    </ul>
                    <h2>계정생성</h2>
                </div>
                <div class="sub-content">
                    <h3>계정 생성이 완료 되었습니다.</h3>
                    <p class="sub-txt">
                        이제 로그인 하실 수 있습니다.<br>
                        로그인을 진행해 주세요.
                    </p>
                    <button type="button" class="btn-blue btn-6 w-170" onclick="location.href='/login/index.php'">로그인 하기</button>
                </div>
            </div>
        </section>
        <!--//sec-01-->
        <!--//content-->
    </div>
    <footer>
        ⓒ 2021-2022, Metarock Inc., All rights Reserved.
    </footer>
</div>
</body>
</html>
