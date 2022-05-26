<?php
// config
require_once __DIR__ .'/../_inc/config.php';
$more = !empty($_GET['more']) ? $_GET['more'] : "";
$more1 = 6;
$more1 += $more;

$query  = "SELECT count(*) as count FROM pubg_game_daily_schedule WHERE 1=1 
                              AND game_status = 'scheduled'
                              AND standard_scheduled > NOW()
                              AND standard_scheduled >= '2022-05-26 09:16:20'
                              AND standard_scheduled <= '2022-05-26 23:59:59' +INTERVAL 10 DAY 
GROUP BY date(standard_scheduled)";
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
                              AND standard_scheduled >= '2022-05-26 09:16:20'
                              AND standard_scheduled <= '2022-05-26 23:59:59' +INTERVAL 10 DAY
                            GROUP BY date(standard_scheduled)
                            ORDER BY standard_scheduled ASC
                            LIMIT {$more1}
                        ";

                        $result = $_mysqli_game->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            //p($db);
                            $games_timezone_scheduled1 = substr($db['games_timezone_scheduled'], 0, 10);
                            echo <<<LI
                        <li>
                            <a href="/lobby/list.php?cate=20&g_date={$games_timezone_scheduled1}">
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
                                                <li class="">30,024 FP</li>
                                                <li>30 FP</li>
                                                <li>0 /1,112</li>
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

    function remaindTime() {
        var now = new Date(); //현재시간을 구한다.
        var end = new Date(now.getFullYear(),now.getMonth(),now.getDate(),18,00,00);

//오늘날짜의 저녁 9시 - 종료시간기준
        var open = new Date(now.getFullYear(),now.getMonth(),now.getDate(),09,00,00);

//오늘날짜의 오전9시 - 오픈시간기준

        var nt = now.getTime(); // 현재의 시간만 가져온다
        var ot = open.getTime(); // 오픈시간만 가져온다
        var et = end.getTime(); // 종료시간만 가져온다.

        /*
        if(nt<ot){ //현재시간이 오픈시간보다 이르면 오픈시간까지의 남은 시간을 구한다.
            $(".time").fadeIn();
            $("p.time-title").html("금일 오픈까지 남은 시간");

            sec =parseInt(ot - nt) / 1000;
            day  = parseInt(sec/60/60/24);
            sec = (sec - (day * 60 * 60 * 24));
            hour = parseInt(sec/60/60);
            sec = (sec - (hour*60*60));
            min = parseInt(sec/60);
            sec = parseInt(sec-(min*60));
            if(hour<10){hour="0"+hour;}
            if(min<10){min="0"+min;}
            if(sec<10){sec="0"+sec;}
            $(".hours").html(hour);
            $(".minutes").html(min);
            $(".seconds").html(sec);
        } else
            */
        if(nt>et){ //현재시간이 종료시간보다 크면
            $("p.time-title").html("금일 마감");
            $(".time").fadeOut();
        }else { //현재시간이 오픈시간보다 늦고 마감시간보다 이르면 마감시간까지 남은 시간을 구한다.
            $(".time").fadeIn();
            $("p.time-title").html("금일 마감까지 남은 시간");
            sec =parseInt(et - nt) / 1000;
            day  = parseInt(sec/60/60/24);
            sec = (sec - (day * 60 * 60 * 24));
            hour = parseInt(sec/60/60);
            sec = (sec - (hour*60*60));
            min = parseInt(sec/60);
            sec = parseInt(sec-(min*60));
            if(hour<10){hour="0"+hour;}
            if(min<10){min="0"+min;}
            if(sec<10){sec="0"+sec;}
            $(".hours").html(hour);
            $(".minutes").html(min);
            $(".seconds").html(sec);
        }
    }
    setInterval(remaindTime,1000); //1초마다 검사를 해주면 실시간으로 시간을 알 수 있다.
</script>
</body>
</html>
