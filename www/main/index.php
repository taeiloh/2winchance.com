<?php
// config
require_once __DIR__ .'/../_inc/config.php';
checkmobile();

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
                        <a href="javascript:void(0)" style="background-image: url('../images/img_banner02.png')">
                            <button type="button">PLAY NOW</button>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:void(0)" style="background-image: url('../images/img_banner.png')">
                            <p class="fs-28">2022 LCK 대회</p>
                            <p class="fs-50">COMING SOON</p>
                            <button type="button">PLAY NOW</button>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:void(0)" style="background-image: url('../images/img_banner.png')">
                            <p class="fs-28">2022 LCK 대회</p>
                            <p class="fs-50">COMING SOON</p>
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
                            <div class="game-thumb" style="background-image: url('../images/main_thumb_01.jpg')">
                                <a href="javascript:void(0)" class="game-info">
                                    <p class="game-title"></p>
                                    <p class="game-type"></p>
                                </a>
                                <div class="none-event">
                                    <p>진행중인 이벤트가 없습니다.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <h2>새로운 소식</h2>
                            <div class="game-thumb" style="background-image: url('../images/main_thumb_02.jpg')">
                                <a href="javascript:void(0)" class="game-info">
                                    <p class="game-title">
                                    </p>
                                    <p class="game-type"></p>
                                </a>
                            </div>
                        </li>
                        <li>
                            <h2>게임 방법</h2>
                            <div class="game-thumb" style="background-image: url('../images/main_thumb_03.jpg')">
                                <a href="javascript:void(0)" class="game-info">
                                    <p class="game-title">2WC 200% 즐기기</p>
                                    <p class="game-type"></p>
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