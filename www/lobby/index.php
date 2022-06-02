<?php
// config
require_once __DIR__ .'/../_inc/config.php';

// 클래스
require_once __DIR__ .'/../class/Game.php';

// 파라미터 정리
$cate       = !empty($_GET['cate'])     ? $_GET['cate']     : 20;
$more       = !empty($_GET['more'])     ? $_GET['more']     : 0;
$more1      = 6;
$more1      += $more;

// 변수 정리
$today      = date('Y-m-d');

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
                    <source src="/images/banner_video.mp4" type="video/mp4">
                    <strong>Your browser does not support the video tag.</strong>
                </video>
            </div>
            <!--//visual-->
            <!--//sec-01-->
            <!--sec-02-->
            <section class="sec sec-02">
                <div class="inner mT10">
                    <h2>진행중인 콘테스트 (1회 콘테스트 사용 FP 입장료는 최대 50,000FP를 초과하지 않습니다.)</h2>
                    <ul class="contest-list">
                        <?php
                        $gameInfo   = new Game($cate, $_mysqli);
                        $arrData    = $gameInfo->getListGame($today, $today);
                        //p($arrData);
                        foreach ($arrData as $key=>$value) {
                            // 변수 정리
                            $img_n  = str_replace('/', '', $value['g_name']);
                            $img_n  = str_replace('%', '', $img_n);

                            $g_fee      = number_format($value['g_fee']);
                            $g_entry    = number_format($value['g_entry']);
                            $g_size     = number_format($value['g_size']);
                            $reward     = number_format(($value['g_size'] * $value['g_fee']) * (100 - COMMISSION) / 100);

                            $title      = utf8_substr($value['g_name'], 0, 24);
                            $sub_menu   = $gameInfo->getSub_menu($value['g_prize']);

                            echo <<<LI
                        <li>
                            <a href="/lobby/list.php?cate={$cate}&sub_menu={$sub_menu}&g_date={$today}&gidx={$value['g_idx']}" title="{$title}">
                                <div class="game-thumb" style="background-image: url('/images/PUBG/output/{$img_n}.jpg')">
                                    <div class="subject">
                                        <img src="/images/pubg_logo.png" alt="pubg_logo"/>
                                    </div>
                                </div>
                                <div class="contest-desc">
                                    <dl>
                                        <!--dt class="contest-schedule">2022-05-20 | 02:56:12</dt-->
                                        <dt class="contest-schedule">{$value['g_date']}</dt>
                                        <dt class="contest-title">{$title}</dt>
                                        <dd class="contest-detail">
                                            <ul>
                                                <li class="">{$reward} FP</li>
                                                <li>{$g_fee} FP</li>
                                                <li>{$g_entry} /{$g_size}</li>
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
                    <!--<p class="more-line" id="moreID">
                        <button type="button" onclick="more1();">더보기 <img src="/images/btn-more.svg" alt="더보기" class="mL8"></button>
                    </p>-->
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
