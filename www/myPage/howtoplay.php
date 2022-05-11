<?php
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

                <div class="category inner">
                    <ul>
                        <li class="active"><a href="javascript:void(0)">HOW TO PLAY</a></li>
                        <li><a href="javascript:void(0)">리그 오브 레전드</a></li>
                        <li><a href="javascript:void(0)">배틀그라운드</a></li>
                        <li><a href="javascript:void(0)">DOTA2</a></li>
                        <li><a href="javascript:void(0)">CS:GO</a></li>
                    </ul>
                </div>
                <div class="mypage-box inner">

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