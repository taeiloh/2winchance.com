<?php
// config
require_once __DIR__ .'/../_inc/config.php';
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
            <h1 class="logo"><a href="/main/index.php"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
            <section class="sec sec-01">
                <div class="inner">
                    <div class="title">
                        <h2>지금은 서비스 기간이 아닙니다.</h2>
                    </div>
                    <button type="button" class="btn-blue btn-6" onclick="location.href='/main/'" style="margin: 200px 0 0 0;">홈으로</button>
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
