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
    // head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>

<!--//head-->

<body>
<div id="wrap" class="main">
    <!--header-->
    <header id="header">
        <?php
        // header
        require_once __DIR__ .'/../common/header.php';
        ?>
    </header>
    <!--//header-->

    <!--container-->
    <div id="container">
        <!--visual-->
        <div id="visual">
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="javascript:void(0)" style="background-image: url('../images/img_banner.png')">
                            <p class="fs-28">2022 LCK 대회</p>
                            <p class="fs-50">COMMING SOON</p>
                            <p class="fs-28">2022.04.01 ~ 2022.06.30</p>
                            <button type="button">PLAY NOW</button>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:void(0)" style="background-image: url('../images/img_banner.png')">
                            <p class="fs-28">2022 LCK 대회</p>
                            <p class="fs-50">COMMING SOON</p>
                            <p class="fs-28">2022.04.01 ~ 2022.06.30</p>
                            <button type="button">PLAY NOW</button>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:void(0)" style="background-image: url('../images/img_banner.png')">
                            <p class="fs-28">2022 LCK 대회</p>
                            <p class="fs-50">COMMING SOON</p>
                            <p class="fs-28">2022.04.01 ~ 2022.06.30</p>
                            <button type="button">PLAY NOW</button>
                        </a>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <script>
            var swiper = new Swiper(".mySwiper", {
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        </script>
        <!--//visual-->

        <!--content-->
        <div id="content">
            <!--sec-01-->
            <section class="sec bg-grey">
                <div class="inner">
                    <ul class="event-list">
                        <li>
                            <h2>주력 이벤트</h2>
                            <div class="game-thumb" style="background-image: url('../images/thumb_event.png')">
                                <a href="javascript:void(0)" class="game-info">
                                    <p class="game-title">
                                        부름 |<br/>
                                        2022 시즌 시네마틱
                                    </p>
                                    <p class="game-type">리그 오브 레전드</p>
                                </a>
                            </div>
                        </li>
                        <li>
                            <h2>새로운 소식</h2>
                            <div class="game-thumb" style="background-image: url('../images/thumb_news.png')">
                                <a href="javascript:void(0)" class="game-info">
                                    <p class="game-title">
                                        리그 오브 레전드<br/>
                                        3.0A 패치노트
                                    </p>
                                    <p class="game-type">리그 오브 레전드</p>
                                </a>
                            </div>
                        </li>
                        <li>
                            <h2>게임 방법</h2>
                            <div class="game-thumb" style="background-image: url('../images/thumb_method.png')">
                                <a href="javascript:void(0)" class="game-info">
                                    <p class="game-title">
                                        리그오브 레전드를<br/>
                                        시작하는 방법
                                    </p>
                                    <p class="game-type">리그 오브 레전드</p>
                                </a>
                            </div>
                        </li>
                    </ul>
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
        // footer
        require_once __DIR__ .'/../common/footer.php';
        ?>
    </footer>
    <!--//footer-->
</div>
</body>
</html>