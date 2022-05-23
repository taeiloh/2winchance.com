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
            <!--visual-->
            <div id="visual">
                <!-- Swiper -->
                <video autoplay="autoplay" muted="muted">
                    <source src="../images/banner_video.mp4" type="video/mp4">
                    <strong>Your browser does not support the video tag.</strong>
                </video>
            </div>
            <!--//visual-->
            <!--//sec-01-->
            <!--sec-02-->
            <section class="sec sec-02">
                <div class="inner mT10">
                    <h2>진행 경기 정보</h2>
                    <ul class="contest-list">
                        <?php
                        $query  = "
                            SELECT
                                count(1) as count, timezone_type AS games_timezone_type, MIN(standard_scheduled) AS games_timezone_scheduled
                            FROM pubg_game_daily_schedule
                            WHERE 1=1
                              AND game_status = 'scheduled'
                              AND standard_scheduled > NOW()
                              AND standard_scheduled >= '2022-05-12 16:16:20'
                              AND standard_scheduled <= '2022-05-12 23:59:59' +INTERVAL 10 DAY
                            GROUP BY date(standard_scheduled)
                            ORDER BY standard_scheduled ASC
                            LIMIT 5
                        ";
                        $result = $_mysqli_game->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            //p($db);

                            echo <<<LI
                        <li>
                            <a href="/lobby/list.php?cate=20">
                                <div class="game-thumb" style="background-image: url('/images/@img_thumb01.png')">
                                    <div class="subject"></div>
                                </div>
                                <div class="contest-desc">
                                    <dl>
                                        <dt class="contest-schedule">2022-05-20 | 02:56:12</dt>
                                        <!-- dt class="contest-schedule">{$db['games_timezone_scheduled']}</dt -->
                                        <dt class="contest-title">30회 중복 & 상위 50% WIN</dt>
                                        <!-- dt class="contest-title">{$db['count']} GAMES</dt -->
                                        <dd class="contest-detail">
                                            <ul>
                                                <li class="coin-b">2,056</li>
                                                <li>0.00</li>
                                                <li>1,658 / 1.5K</li>
                                            </ul>
                                        </dd>
                                    </dl>
                                </div>
                            </a>
                        </li>
LI;
                        }
                        ?>
                    </ul>
                    <p class="more-line">
                        <button type="button">더보기 <img src="/images/btn-more.svg" alt="더보기" class="mL8"></button>
                    </p>
                </div>
            </section>
            <!--//sec-02-->
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