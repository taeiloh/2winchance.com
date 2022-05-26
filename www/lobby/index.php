<?php
// config
require_once __DIR__ .'/../_inc/config.php';
$more = !empty($_GET['more']) ? $_GET['more'] : "";
$more1 = 6;
$more1 += $more;

$query  = "SELECT count(*) as count FROM pubg_game_daily_schedule WHERE 1=1 
                              AND game_status = 'scheduled'
                              AND standard_scheduled > NOW()
                              AND standard_scheduled >= '2022-05-26 16:16:20'
                              AND standard_scheduled <= '2022-05-26 23:59:59' +INTERVAL 10 DAY    ";
$tresult = $_mysqli_game->query($query);
if (!$tresult) {

}
$db = $tresult->fetch_assoc();

$total_count=!empty($db['count']) ? $db['count'] : 0;
//p($db);
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
                <video autoplay="autoplay" muted="muted" loop>
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
                              AND standard_scheduled >= '2022-05-26 16:16:20'
                              AND standard_scheduled <= '2022-05-26 23:59:59' +INTERVAL 10 DAY
                            GROUP BY date(standard_scheduled)
                            ORDER BY standard_scheduled ASC
                            LIMIT {$more1}
                        ";
/*
                        $query  = "
                            SELECT
                                count(1) as count, timezone_type AS games_timezone_type, MIN(standard_scheduled) AS games_timezone_scheduled ,league_name
                            FROM pubg_game_daily_schedule
                            WHERE 1=1
                              AND game_status = 'scheduled'
                              AND standard_scheduled > NOW()

                            GROUP BY date(standard_scheduled)
                            ORDER BY standard_scheduled ASC
                            LIMIT $more1
                        ";
*/
                        $result = $_mysqli_game->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            //p($db);

                            echo <<<LI
                        <li>
                            <a href="/lobby/list.php?cate=20">
                                <div class="game-thumb" style="background-image: url('../images/img_30multi_50.png')">
                                    <div class="subject">
                                        <img src="../images/pubg_logo.png" alt="pubg_logo">
                                    </div>
                                </div>
                                <div class="contest-desc">
                                    <dl>
                                        <!--dt class="contest-schedule">2022-05-20 | 02:56:12</dt-->
                                        <dt class="contest-schedule">{$db['games_timezone_scheduled']}</dt>
                                        <dt class="contest-title">30회 중복 & 상위 50% WIN</dt>
                                        <dt class="contest-title">{$db['count']} GAMES</dt >
                                        <dd class="contest-detail">
                                            <ul>
                                                <li class="coin-b">2,056</li>
                                                <li>1,000</li>
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

                    <?php
                    if($more1 <=$total_count){
                    ?>
                    <p class="more-line" id="moreID">
                        <button type="button" onclick="more1();">더보기 <img src="/images/btn-more.svg" alt="더보기" class="mL8"></button>
                    </p>
                    <?php
                    }
                    ?>
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
<script>
    function more1(){
        location.href="/lobby/?cate=20&more=<?=$more1?>#moreID";
    }
</script>
</body>
</html>
