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

<!--//head-->

<body>
<div id="wrap" class="member">
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="../html/index.html"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
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
                    <button type="button" class="btn-blue btn-6">다음</button>
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
</body>
</html>