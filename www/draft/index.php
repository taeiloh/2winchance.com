<?php
// config
require_once __DIR__ .'/../_inc/config.php';

// 클래스
require_once __DIR__ .'/../class/Contest.php';
require_once __DIR__ .'/../class/DraftGame.php';

// 세션
$m_idx          = !empty($_SESSION['_se_idx'])  ? $_SESSION['_se_idx']  : 0;

// 파라미터
//p($_REQUEST);
$idx            = !empty($_GET['index'])        ? $_GET['index']        : 0;
$lu_idx         = !empty($_GET['lu_idx'])       ? $_GET['lu_idx']       : 0;
$edit           = !empty($_GET['edit'])         ? $_GET['edit']         : 0;

// 변수 정리
$today          = date('Y-m-d');
$time           = date('Y-m-d H:i:s');

$query  = "
    SELECT * 
    FROM game
    LEFT JOIN game_category
        ON gc_idx = g_sport
    WHERE 1=1
        AND g_idx = {$idx}
";
$result = $_mysqli->query($query);
if (!$result) {

}
$db = $result->fetch_assoc();
//p($db);
$gname      = $db['g_name'];
$gfee       = $db['g_fee'];
$gentry     = $db['g_entry'];
$gsize      = $db['g_size'];
$gmulti     = $db['g_multi_max'];
$greward    = floor($gsize * $gfee * (100 - COMMISSION) / 100);
$pos        = json_decode($db['gc_pos'], true);
$gc_pos     = implode('","', $pos['pos']);
$gdate      = $db['g_date'];
//p($gc_pos);
$year           =substr($gdate, 0, 4);
$month          =substr($gdate, 5,2);
$days           =substr($gdate, 8,2);

//$draftGame  = new DraftGame($idx, $_mysqli);
$contestInfo    = new Contest($m_idx, $idx, $_mysqli);

$my_entry_cnt   = $contestInfo->getCntJoinContest();

// 게임 상태
$ago30min       = date('Y-m-d H:i:s', strtotime('-30 minutes', strtotime($gdate)));
//p($ago30min);
if ($time > $ago30min) {
    $gstatus        = 'Live';
} else if ($db['g_size'] > $db['g_entry']) {
    $gstatus        = '대기';
} else {
    $gstatus        = 'FULL';
}
?>
<!doctype html>
<html lang="ko">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
    <script type="text/javascript" src="/js/moment.js"></script>
    <script type="text/javascript" src="/js/moment-timezone-with-data.js"></script>
    <script type="text/javascript" src="/js/jquery.number.min.js"></script>
    <style>
        .wrap-loading{
            position: fixed;
            left:0;
            right:0;
            top:0;
            bottom:0;
            background: rgba(0,0,0,0.2); /*not in ie */
            filter: progid:DXImageTransform.Microsoft.Gradient(startColorstr='#20000000',endColorstr='#20000000');    /* ie */
            z-index: 999;
        }

        .wrap-loading div{
            position: fixed;
            top:50%;
            left:50%;
            margin-left: -50px;
            margin-top: -50px;
        }

        .display-none{
            display:none;
        }
    </style>
</head>
<body>
<div class="wrap-loading display-none">
    <div><img src="https://www.palbok.com/img/common/loading.gif" style="width: 100px;" /></div>
</div>
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
        <!--visual-->
        <div id="visual">
            <div class="inner enter">
                <div class="game-detail">
                    <div class="thumb-icon">
                        <img src="/images/pubg.png" alt="pubg">
                    </div>
                    <div class="parti-info">
                        <p><?=$gname;?></p>
                        <dl class="">
                            <dd class="prize-money">총 상금<b><?=number_format($greward);?></b><span>FP</span></dd>
                            <dd class="prize-money">참가비<b><?=number_format($gfee);?></b><span>FP</span></dd>
                            <dd class="participant"><img src="/images/ico_peple.svg" alt="참여자 수" class="mR13"><span><?=number_format($gentry);?> </span> / <?=number_format($gsize);?></dd>
                            <dd>중복 가능 : <?=number_format($gmulti);?></dd>
                            <dd>나의 참가 : <?=number_format($my_entry_cnt);?></dd>
                        </dl>
                    </div>
                </div>
                <div class="detail-box">
                    <p class="status"><?=$gstatus;?></p>
                    <small><?=$gdate;?></small>
                    <p class="time fc-yellow"><span class="day">00</span>일  <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></p>
                    <div class="game-logo"></div>
                </div>
            </div>
        </div>
        <!--//visual-->
        <!--content-->
        <div id="content">
            <!--sec-01-->
            <section class="sec sec-01 T0">
                <div class="inner enter">
                    <div class="league-left">
                        <div class="time-menu">
                            <div class="swiper time-swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide active">
                                        <a href="javascript:void(0)" data-home_id="" data-away_id="">
                                            <p class="team-name">ALL</p>
                                        </a>
                                    </div>
                                    <?php
                                    $game_daily_schedule    = "pubg_game_daily_schedule";
                                    $query  = "
                                        SELECT
                                            home_alias, away_alias, 
                                            DATE_FORMAT(standard_scheduled, '%b %e') AS sch_date,
                                            DATE_FORMAT(standard_scheduled, '%h:%i %p') AS sch_time,
                                            home_id, away_id
                                        FROM {$game_daily_schedule}
                                        WHERE 1=1 
                                        AND DATE_FORMAT(timezone_scheduled, '%Y-%m-%d')=DATE_FORMAT('{$db['g_date']}', '%Y-%m-%d')
                                        ORDER BY timezone_scheduled
                                    ";
                                    //p($query);
                                    $result = $_mysqli_game->query($query);
                                    if (!$result) {

                                    }
                                    for($i=0; $i<5; $i++) {
                                        if($i==0) {
                                            $title  = '1st M';
                                        } else if($i==1) {
                                            $title  = '2nd M';
                                        } else if($i==2) {
                                            $title  = '3rd M';
                                        } else if($i==3) {
                                            $title  = '4th M';
                                        } else {
                                            $title  = '5th M';
                                        }

                                        echo <<<DIV
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)" data-home_id="" data-away_id="">
                                            <p class="team-name">{$title}</p>
                                            <p class="date">{$today}</p>
                                            <p class="time">18:00:00</p>
                                        </a>
                                    </div>
DIV;

                                    }
                                    ?>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <script>
                                var swiper = new Swiper(".time-swiper", {
                                    slidesPerView: "auto",
                                    spaceBetween: 40,
                                    navigation: {
                                        nextEl: ".swiper-button-next",
                                        prevEl: ".swiper-button-prev",
                                    },
                                });
                            </script>
                        </div>
                        <div id="player-info" class="player-info">
                        </div>
                        <div class="category-wrap">
                            <ul class="category dp_tab_draft">
                                <li class="active sort" data-sort="ALL"><a href="javascript:void(0);">ALL</a></li>
                                <li class="sort" data-sort="TL"><a href="javascript:void(0);">오더</a></li>
                                <li class="sort" data-sort="R"><a href="javascript:void(0);">정찰</a></li>
                                <li class="sort" data-sort="GR"><a href="javascript:void(0);">포탑</a></li>
                                <li class="sort" data-sort="AR"><a href="javascript:void(0);">돌격</a></li>
                                <!--<li class="sort" data-sort="UTIL"><a href="javascript:void(0);">백업</a></li>
                                <li class="sort" data-sort="UTIL"><a href="javascript:void(0);">서포터</a></li>-->
                                <li class="sort" data-sort="UTIL"><a href="javascript:void(0);">유틸</a></li>
                            </ul>
                            <button type="button" id="btnRandom" class="random-btn">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                무작위 선발
                            </button>
                        </div>
                        <table class="contents-table">
                            <colgroup>
                                <col style="width: 10%"/>
                                <col style="width: 10%"/>
                                <col style=""/>
                                <col style="width: 20%"/>
                                <col style="width: 10%"/>
                                <col style="width: 10%"/>
                                <col style="width: 10%"/>
                            </colgroup>
                            <thead>
                            <tr class="filter">
                                <th><a href="javascript:void(0);">POS</a></th>
                                <th>이름</th>
                                <th>
                                    <input type="search" placeholder="플레이어를 검색해주세요.">
                                    <button class="search-btn"></button>
                                </th>
                                <th><a href="javascript:void(0);">팀</a></th>
                                <th><a href="javascript:void(0);">전투력</a></th>
                                <th><a href="javascript:void(0);">연봉</a></th>
                                <th>선택</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="scroll-tbody">
                        <table class="contents-table">
                            <colgroup>
                                <col style="width: 10%"/>
                                <col style=""/>
                                <col style=""/>
                                <col style="width: 20%"/>
                                <col style="width: 10%"/>
                                <col style="width: 10%"/>
                                <col style="width: 10%"/>
                            </colgroup>
                            <tbody id="player_list">
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="league-right">
                        <ul class="lineup-info">
                            <li>
                                <dl>
                                    <dt>잔여 연봉</dt>
                                    <dd>$ <span class="total_salary">50,000</span></dd>
                                </dl>
                            </li>
                            <li>
                                <dl>
                                    <dt>총 전투력</dt>
                                    <dd><span class="total_fppg">0</span></dd>
                                </dl>
                            </li>
                            <li>
                                <dl>
                                    <dt>평균 연봉</dt>
                                    <dd>$ <span class="avg_salary">0</span></dd>
                                </dl>
                            </li>
                        </ul>
                        <div class="select-player pick_player">
                            <ul>
                                <?php
                                // 라인업 히스토리
                                if ($edit==1) {
                                    $draftGame  = new DraftGame($idx, $lu_idx, $_mysqli, $_mysqli_game);
                                    $arrLineup  = $draftGame->getListLineup();
                                }
                                //p($arrLineup);

                                $i  = 0;
                                foreach ($pos['pos'] as $key=>$value) {
                                    if ($edit==1) {
                                        $team_name      = $arrLineup[$key]['team_alias'];
                                        $player_name    = $arrLineup[$key]['player_name'];
                                        $player_salary  = $arrLineup[$key]['player_salary'];
                                        $on ="on";
                                        $player_img     = "<img src=\"/images/player_images/pubg/{$arrLineup[$key]['player_name']}.jpg\" alt=\"\" onerror=\"this.src='/images/player_images/pubg/default.png'\" style=\"width: 68px;\">";
                                        $btnDel         = "<button class=\"btn-delete\" data-fppg=\"0\" data-del-index=\"{$arrLineup[$key]['player_idx']}\" data-game=\"{$arrLineup[$key]['game_id']}\" onclick=\"delPlayer('pubg', {$arrLineup[$key]['player_idx']}, '{$value}');\">삭제</button>";

                                    } else {
                                        $team_name      = 'Team';
                                        $player_name    = 'Player Name';
                                        $player_salary  = '0';
                                        $on="";
                                        $player_img     = "<p style=\"background-image:url('/images/PUBG/pos/{$value}.png');background-size:100%;\"></p>";
                                        $btnDel         = '';
                                    }

                                    /*if($i==4) {
                                        $img_name   = 'BK';
                                    } else if($i==5) {
                                        $img_name   = 'SU';
                                    }*/
                                    $i++;

                                    echo <<<LI
                                <!-- TODO 20220524 syryu 아래 영역은 선택 전디폴트 화면 입니다. -->
                                <li class="player-info lineup_{$value}">
                                    <div class="player-img player_img {$on}">{$player_img}</div>
                                    <div class="player-skill">
                                        <div class="skill-top">
                                            <div class="name">
                                                <h2>
                                                    <span class="fc-blue team_name">{$team_name}</span>
                                                    <span class="player_name">{$player_name}</span>
                                                </h2>
                                                <p class="player-money salary">$ {$player_salary}</p>
                                            </div>
                                            <table class="border-table">
                                                <colgroup>
                                                    <col>
                                                    <col>
                                                    <col>
                                                    <col>
                                                </colgroup>
                                                <tbody><tr>
                                                    <th>최근 경기</th>
                                                    <th>순위</th>
                                                    <th>킬 수</th>
                                                    <th>전투력</th>
                                                </tr>
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                    <div class="del">{$btnDel}</div>
                                </li>
                                <!-- TODO 20220524 syryu 아래 영역은 선수 선택 후 값이 들어오는 화면입니다. -->
                                <!--li class="player-info">
                                    <div class="player-img">
                                        <img src="/images/img_player.png" width="80" alt="이상혁 프로필 사진">
                                    </div>
                                    <div class="player-skill">
                                        <div class="skill-top">
                                            <div class="name">
                                                <h2><span class="fc-blue">AFA</span>Faker</h2>
                                                <p class="player-money">$3,000</p>
                                            </div>
                                            <table class="border-table">
                                                <colgroup>
                                                    <col>
                                                    <col>
                                                    <col>
                                                    <col>
                                                </colgroup>
                                                <tr>
                                                    <th>최근 경기</th>
                                                    <th>순위</th>
                                                    <th>킬 수</th>
                                                    <th>전투력</th>
                                                </tr>
                                                <tr>
                                                    <td>MM-DD</td>
                                                    <td>00</td>
                                                    <td>00</td>
                                                    <td>000</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-delete">삭제</button>
                                </li -->

LI;
                                }
                                ?>
                            </ul>
                            <div class="btn-group">
                                <button type="button" id="btnClear" class="btn-8 btn-grey">전부 삭제하기</button>
                                <button type="button" id="btnConfirmDraft" class="btn-8 btn-blue btn-confirm-draft" data-coin="<?=$gfee;?>" data-category="20" data-game="<?=$idx;?>">콘테스트 참여하기</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--//sec-01-->
        </div>
        <!--//content-->
    </div>
    <!--//container-->
    <div id="modal-1" class="modal">
        <div class="modal-container">
            <div class="modal-body">
                <div class="player-detail">
                    <div class="player-info">
                        <div class="player-img">
                            <img src="/images/img_player.png" alt="이상혁 프로필 사진">
                        </div>
                        <div class="player-skill">
                            <p class="fc-yellow"><b class="fc-blue mR10">오더</b>GEN G.</p>
                            <h2 class="name">RENDA <span>JAEYEONG SEO</span></h2>
                            <p class="fc-blue">연봉 <b>$3,000</b></p>
                        </div>
                        <div class="right">
                            <button type="button" class="btn-blue">라인업 추가하기</button>
                            <img width="40" src="/images/ico_lcs.png" alt="lcs">
                        </div>
                    </div>
                    <div class="skill-box">
                        <dl>
                            <dt>5</dt>
                            <dd>평균순위</dd>
                        </dl>
                        <dl>
                            <dt>1</dt>
                            <dd>평균 킬</dd>
                        </dl>
                        <dl>
                            <dt>mm:ss</dt>
                            <dd>평균 생존</dd>
                        </dl>
                        <dl>
                            <dt>0,000</dt>
                            <dd>평균 데미지</dd>
                        </dl>
                        <dl>
                            <dt>205</dt>
                            <dd>평균 전투력</dd>
                        </dl>
                        <dl>
                            <dt>90%</dt>
                            <dd>승률</dd>
                        </dl>
                        <dl>
                            <dt>26.4%</dt>
                            <dd>KDA</dd>
                        </dl>
                    </div>
                </div>
                <div class="player-news">
                    <ul class="tabs">
                        <li class="on" data-tab="tabs-1"><a href="javascript:void(0)">최근 시즌 요약</a></li>
                        <li data-tab="tabs-2"><a href="javascript:void(0)">최근 시즌 상세</a></li>
                    </ul>
                    <div id="tabs-1" class="tab-content on">
                        <h3>PUBG Continental Series 6 ASIA
                        </h3>
                        <div class="game-date">
                            <p class="label">Date</p>
                            <p>2022-05-29 00:15:26:33</p>
                        </div>
                        <table class="border-table">
                            <colgroup>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                            </colgroup>
                            <tr>
                                <th>평균 순위</th>
                                <th>평균 킬</th>
                                <th>평균 생존</th>
                                <th>평균 데미지</th>
                                <th>평균 전투력</th>
                                <th>승률</th>
                                <th>KDA</th>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>1</td>
                                <td>mm:ss</td>
                                <td>0,000</td>
                                <td>205</td>
                                <td>90%</td>
                                <td>26.4%</td>
                            </tr>
                        </table>
                    </div>
                    <div id="tabs-2" class="tab-content">
                        <table class="border-table">
                            <colgroup>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                            </colgroup>
                            <tr>
                                <th>일자</th>
                                <th>순위</th>
                                <th>킬</th>
                                <th>생존</th>
                                <th>데미지</th>
                                <th>전투력</th>
                                <th>KDA</th>
                            </tr>
                            <tr>
                                <td>05/13</td>
                                <td>0</td>
                                <td>265</td>
                                <td>mm:ss</td>
                                <td>0,000</td>
                                <td>000</td>
                                <td>00.0%</td>
                            </tr>
                            <tr>
                                <td>05/13</td>
                                <td>0</td>
                                <td>265</td>
                                <td>mm:ss</td>
                                <td>0,000</td>
                                <td>000</td>
                                <td>00.0%</td>
                            </tr>
                            <tr>
                                <td>05/13</td>
                                <td>0</td>
                                <td>265</td>
                                <td>mm:ss</td>
                                <td>0,000</td>
                                <td>000</td>
                                <td>00.0%</td>
                            </tr>
                            <tr>
                                <td>05/13</td>
                                <td>0</td>
                                <td>265</td>
                                <td>mm:ss</td>
                                <td>0,000</td>
                                <td>000</td>
                                <td>00.0%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-close">
                <button type="button" class="close-btn"></button>
            </div>
        </div>
        <div class="overlay"></div>
    </div>

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
    function remaindTime() {
        var now = new Date(); //현재시간을 구한다.
        var end = new Date(<?=$year?>,<?=$month?>,<?=$days?>,18,00,00);

        var endDays="<?=$days?>";
//오늘날짜의 저녁 9시 - 종료시간기준
        var open = new Date(now.getFullYear(),now.getMonth(),now.getDate(),09,00,00);
        /*console.log(now.getFullYear());
        console.log(now.getMonth());
        console.log(now.getDate());*/
//오늘날짜의 오전9시 - 오픈시간기준

        var nt = now.getTime(); // 현재의 시간만 가져온다
        var ot = open.getTime(); // 오픈시간만 가져온다
        var et = end.getTime(); // 종료시간만 가져온다.

        var days=parseInt(endDays)-parseInt(now.getDate()); //마감까지의 날짜
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
            $(".timer").html("종료 되었습니다.");
            //$(".time").fadeOut();
        }else if(days>=0){ //현재시간이 오픈시간보다 늦고 마감시간보다 이르면 마감시간까지 남은 시간을 구한다.
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
            $(".day").html(days);
            $(".hours").html(hour);
            $(".minutes").html(min);
            $(".seconds").html(sec);
        }
    }
    setInterval(remaindTime,1000); //1초마다 검사를 해주면 실시간으로 시간을 알 수 있다.
</script>
<script>
    var isEdit          = <?=$edit;?>;
    var lu_idx          = <?=$lu_idx;?>;
    var what_category   = "pubg";
    var count_time      = $("#game_date").attr('data-next-game');
    var nextDate        = moment.tz(count_time, "GMT");
    var total_salary    = parseInt($(".total_salary").text().replace(",", ""));
    var total_fppg      = 0;
    var avg_salary      = (50000 - total_salary) / 8;
    var flex            = false;
    var tab_draft       = $(".dp_tab_draft");

    $(".avg_salary").html($.number(avg_salary));

    function get_player_list() {
        console.log("=== get_player_list ===");

        // ajax
        var postData = {
            "index": 24965
        };

        $.ajax({
            url: "/ajax/player_list.php",
            type: "POST",
            data: postData,
            success: function (data) {
                var tr      = "";
                var json    = JSON.parse(data);
                console.log(json);

                $.each(json, function (index, obj) {
                    if (index === 0) {
                    }
                    tr += make_tr(json[index]);
                });

                $("#player_list").html(tr);
                init_add_player();

                // 첫 선수 정보 보여주기
                $(".player_info").eq(0).trigger("click");
            },
            beforeSend:function(){
                $(".wrap-loading").removeClass("display-none");
            },
            complete:function(){
                $(".wrap-loading").addClass("display-none");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    // json 데이터 가공
    function make_tr(json) {
        var season      = "";
        if (json[17] != "" && json[17] != undefined) {
            season = $.parseJSON(json[17]);
        }
        //console.log(season['informally']['DBPG']);
        var flex        = "";
        var name        = "";
        var class_flex  = "";
        //
        if (json[7] !== 'TEAM') {
            class_flex = 'pos_FLEX';
            flex = 'data-flex="' + json[7] + '"';
        }
        //
        var tr = '<tr class="pos_' + json[0] + ' ' + class_flex + ' pos_' + json[16] + '">';
        tr += '<td>' + json[21] + '</td>';
        tr += '<td colspan="2" class="player_info" style="cursor:pointer" data-category="' + json[15] + '" data-index="' + json[14] + '">';
        if (json[15] === 'mlb') {
            tr += json[2] + ' ' + json[3];
            name = json[11] + ' ' + json[12];
        } else if (json[15] === 'lol') {
            tr += json[3];
            name = json[12];
        } else if (json[15] === 'nba' || json[15] === 'nba_allstar') {
            tr += json[2] + ' ' + json[3];
            name = json[11] + ' ' + json[12];
        } else if (json[15] === 'wc' || json[15] === 'epl' || json[15] === 'tsl') {
            tr += json[2] + ' ' + json[3];
            name = json[11] + ' ' + json[12];

        } else if (json[15] === "pubg") {
            tr += json[3];
            name = json[11] + ' ' + json[12];
        }
        //
        tr += '</td>';
        tr += '<td>' + json[13] + '</td>';
        tr += '<td>' + json[5] + '</td>';
        /*tr += '<td>' + json[5] + '</td>';
        tr += '<td style="text-align:right">$</td>';*/
        tr += '<td>$ ' + json[6];
        tr += '<td class="tR">';
        tr += '<button type="button" class="btn-plus add_player" ';
        tr += 'data-category="' + json[15] + '" ';
        tr += 'data-flex="' + json[7] + '" ';
        tr += 'data-fppg="' + json[20] + '" ';
        tr += 'data-game="' + json[8] + '" ';
        tr += 'data-img_l="' + json[19] + '" ';
        tr += 'data-img_s="' + json[18] + '" ';
        tr += 'data-index="' + json[9] + '" ';
        tr += 'data-name ="' + name + '" ';
        tr += 'data-pos="' + json[7] + '" ';
        tr += 'data-pos2="' + json[16] + '" ';
        tr += 'data-salary="' + json[10] + '" ';
        tr += 'data-team ="' + json[13] + '" ';

        //NBA
        var mpg;
        if (season != "" && season != undefined) {
            mpg = season['informally']['mpg'];
        } else {
            mpg = "";
        }

        var ppg;
        if (season != "" && season != undefined) {
            ppg = season['informally']['ppg'];
        } else {
            ppg = "";
        }

        var rpg;
        if (season != "" && season != undefined) {
            rpg = season['informally']['rpg'];
            if (json[15] === "pubg") {
                //pubg
                rpg = season['informally']['RPG'];
            }
        } else {
            rpg = "";
        }

        var apg;
        if (season != "" && season != undefined) {
            apg = season['informally']['apg'];
        } else {
            apg = "";
        }

        var bpg;
        if (season != "" && season != undefined) {
            bpg = season['informally']['bpg'];
        } else {
            bpg = "";
        }

        //EPL
        var gg;
        if (season != "" && season != undefined) {
            gg = season['informally']['GG'];
        } else {
            gg = "";
        }

        var ag;
        if (season != "" && season != undefined) {
            ag = season['informally']['AG'];
        } else {
            ag = "";
        }

        var sg;
        if (season != "" && season != undefined) {
            sg = season['informally']['SG'];
        } else {
            sg = "";
        }

        var crsa;
        if (season != "" && season != undefined) {
            crsa = season['informally']['CrsA'];
        } else {
            crsa = "";
        }

        var inta;
        if (season != "" && season != undefined) {
            inta = season['informally']['IntA'];
        } else {
            inta = "";
        }

        //PUBG
        var dbpg;
        if (season != "" && season != undefined) {
            dbpg = season['informally']['DBPG'];
        } else {
            dbpg = "";
        }

        var kpg;
        if (season != "" && season != undefined) {
            kpg = season['informally']['KPG'];
        } else {
            kpg = "";
        }

        var hkpg;
        if (season != "" && season != undefined) {
            hkpg = season['informally']['HKPG'];
        } else {
            hkpg = "";
        }

        var dpg;
        if (season != "" && season != undefined) {
            dpg = season['informally']['DPG'];
        } else {
            dpg = "";
        }

        if (json[15] === 'nba' || json[15] === 'nba_allstar') {
            tr += 'data-mpg ="' + mpg + '" ';
            tr += 'data-ppg ="' + ppg + '" ';
            tr += 'data-rpg ="' + rpg + '" ';
            tr += 'data-apg ="' + apg + '" ';
            tr += 'data-bpg ="' + bpg + '" ';

        } else if (json[15] === 'wc' || json[15] === 'epl' || json[15] === 'tsl') {
            tr += 'data-gg ="' + gg + '" ';
            tr += 'data-ag ="' + ag + '" ';
            tr += 'data-sg ="' + sg + '" ';
            tr += 'data-crsa ="' + crsa + '" ';
            tr += 'data-inta ="' + inta + '" ';

        } else if (json[15] === "pubg") {
            tr += 'data-dbpg ="' + dbpg + '" ';
            tr += 'data-kpg ="' + kpg + '" ';
            tr += 'data-hkpg ="' + hkpg + '" ';
            tr += 'data-dpg ="' + dpg + '" ';
            tr += 'data-rpg ="' + rpg + '" ';
        }
        tr += '></button>';
        tr += '</td>';
        tr += '</tr>';

        return tr;
    }

    function init_add_player() {
        console.log("=== init_add_player ===");

        var add_player = $(".add_player");

        //왼쪽 선수 리스트에서 + 클릭 시
        $(document).on("click", ".add_player", function () {
            console.log("=== add_player click ===");

            var data_category   = $(this).attr('data-category');
            var data_flex       = $(this).attr('data-flex');
            var data_fppg       = $(this).attr('data-fppg');
            var data_game       = $(this).attr('data-game');
            var data_img_s      = $(this).attr('data-img_s');
            var data_img_l      = $(this).attr('data-img_l');
            var data_index      = $(this).attr('data-index');
            var data_name       = $(this).attr('data-name');
            var data_pos        = $(this).attr('data-pos');
            var data_pos2       = $(this).attr('data-pos2');
            var data_salary     = $(this).attr('data-salary');
            var data_team       = $(this).attr('data-team');
            if (data_category == "nba" || data_category == "nba_allstar") {
                var data_mpg        = $(this).attr('data-mpg');
                var data_ppg        = $(this).attr('data-ppg');
                var data_rpg        = $(this).attr('data-rpg');
                var data_apg        = $(this).attr('data-apg');
                var data_bpg        = $(this).attr('data-bpg');
                var data_gg         = "";
                var data_ag         = "";
                var data_sg         = "";
                var data_crsa       = "";
                var data_inta       = "";
                var data_dbpg       = "";
                var data_kpg        = "";
                var data_hkpg       = "";
                var data_dpg        = "";
                //var data_rpg        = "";

            } else if (data_category == "wc" || data_category == "epl" || data_category == "tsl") {
                var data_mpg        = "";
                var data_ppg        = "";
                var data_rpg        = "";
                var data_apg        = "";
                var data_bpg        = "";
                var data_gg         = $(this).attr('data-gg');
                var data_ag         = $(this).attr('data-ag');
                var data_sg         = $(this).attr('data-sg');
                var data_crsa       = $(this).attr('data-crsa');
                var data_inta       = $(this).attr('data-inta');
                var data_dbpg       = "";
                var data_kpg        = "";
                var data_hkpg       = "";
                var data_dpg        = "";
                //var data_rpg        = "";

            } else if (data_category == "pubg") {
                var data_mpg        = "";
                var data_ppg        = "";
                //var data_rpg        = "";
                var data_apg        = "";
                var data_bpg        = "";
                var data_gg         = "";
                var data_ag         = "";
                var data_sg         = "";
                var data_crsa       = "";
                var data_inta       = "";
                var data_dbpg       = $(this).attr('data-dbpg');
                var data_kpg        = $(this).attr('data-kpg');
                var data_hkpg       = $(this).attr('data-hkpg');
                var data_dpg        = $(this).attr('data-dpg');
                var data_rpg        = $(this).attr('data-rpg');
            }

            //농구 G, F 포지션 예외 처리
            //console.log($(".dp_tab_draft").children(".active").attr('data-sort'));
            if (data_category == "nba" || data_category == "nba_allstar") {
                if ($(".dp_tab_draft").children(".active").attr('data-sort') == 'G' || $(".dp_tab_draft").children(".active").attr('data-sort') == 'F') {
                    data_pos    = data_pos2;
                } else if ($(".dp_tab_draft").children(".active").attr('data-sort') == 'UTIL') {
                    data_pos    = "UTIL";
                }

            } else if (data_category == "wc" || data_category == "epl" || data_category == "tsl") {
                if ($(".dp_tab_draft").children(".active").attr('data-sort') == 'UTIL') {
                    data_pos    = "UTIL";
                }

            } else if (data_category == "pubg") {
                if ($(".dp_tab_draft").children(".active").attr('data-sort') == 'G' || $(".dp_tab_draft").children(".active").attr('data-sort') == 'F') {
                    data_pos    = data_pos2;
                } else if ($(".dp_tab_draft").children(".active").attr('data-sort') == 'UTIL') {
                    data_pos    = "UTIL";
                }
            }
            console.log("data_pos: ", data_pos);

            //선수 추가
            addPlayer(data_pos, data_game, data_index, data_salary, data_name, data_team, data_flex, data_category, data_img_s, data_img_l, data_fppg, data_mpg, data_rpg, data_ppg, data_apg, data_bpg, data_gg, data_ag, data_sg, data_crsa, data_inta, data_dbpg, data_kpg, data_hkpg, data_dpg);
        });
    }

    function addPlayer(pos, game_id, id, salary, name, team, data_flex, category, img_s, img_l, fppg, data_mpg, data_rpg, data_ppg, data_apg, data_bpg, data_gg, data_ag, data_sg, data_crsa, data_inta, data_dbpg, data_kpg, data_hkpg, data_dpg) {
        console.log("=== addPlayer ===");

        var cnt = 0;

        if (total_salary - salary < 0) {
            alert("Salary exceeded the standard.");
            total_salary    = parseInt(total_salary);
            total_fppg      = parseFloat(total_fppg);
            avg_salary      = parseInt(avg_salary);
            return;

        } else {
            if (flex === true) {
                pos = 'FLEX';
                //
                if (chk_flex(data_flex, "player_name", name) === false) {
                    alert('선수 포지션이 중복되었습니다. (001)');
                    return false;
                }
            }

            //2018-01-18 진경수 (선수 중복 걸러내기 추가)
            var overlap = false;
            $(".del-player").each(function () {
                if ($(this).attr("data-del-index") == id) {
                    overlap = true;
                }
            });
            if (overlap === true) {
                alert('선수 포지션이 중복되었습니다. (002)');
                return;
            }

            if (input_node(pos, "player_name", name) === true) {
                //선택된 선수 개수 찾기
                cnt = $(".del-player").length + 1;

                total_salary    = total_salary - salary;
                total_fppg      = total_fppg + parseFloat(fppg);
                avg_salary      = (50000 - total_salary) / cnt;

            } else {
                alert('선수 포지션이 중복되었습니다. (003)');
                return;
            }

            //선수 이미지를 위해서 name 파싱
            if (category == "nba" || category == "nba_allstar") {
                name = name.replace(" ", "+");
                input_node(pos, 'player_img', '<img src="/images/player_images/nba/'+ name +'.png" width="50" alt="" onerror=\'this.src="/images/player_images/nba/default.png"\' />');

            } else if (category == "wc" || category == "epl" || category == "tsl") {
                name = name.replace(" ", "+");
                input_node(pos, 'player_img', '<img src="/images/player_images/soc/'+ category + img_s +'" width="50" alt="" onerror=\'this.src="/images/player_images/soc/'+ category +'/img_s/home_s.png"\' />');

            } else if (category == "pubg") {
                name = name.split(" ");
                input_node(pos, 'player_img', '<img src="/images/player_images/pubg/'+ name[1] +'.jpg" alt="" onerror=\'this.src="/images/player_images/pubg/default.png"\' style="width: 68px;" />');


            }

            input_node(pos, 'team_name', team);
            input_node(pos, 'point', '0');
            input_node(pos, 'salary', '$' + $.number(salary));
            input_node(pos, 'del', '<button class="btn-delete" data-fppg="'+ fppg +'" data-del-index ="' + id + '" data-game ="' + game_id + '" onclick="delPlayer(\''+ category +'\', \''+ id +'\', \''+ pos +'\');">삭제</button>');
            //2018-05-23 진경수 (GG, AG, SG, CrsA, IntA 추가)
            input_node(pos, 'p_fppg', fppg);
            if (category == "nba" || category == "nba_allstar") {
                input_node(pos, 'p_mpg', data_mpg);
                input_node(pos, 'p_ppg', data_ppg);
                input_node(pos, 'p_rpg', data_rpg);
                input_node(pos, 'p_apg', data_apg);
                input_node(pos, 'p_bpg', data_bpg);

            } else if (category == "wc" || category == "epl" || category == "tsl") {
                input_node(pos, 'p_gg', data_gg);
                input_node(pos, 'p_ag', data_ag);
                input_node(pos, 'p_sg', data_sg);
                input_node(pos, 'p_crsa', data_crsa);
                input_node(pos, 'p_inta', data_inta);

            } else if (category == "pubg") {
                input_node(pos, 'p_dbpg', data_dbpg);
                input_node(pos, 'p_kpg', data_kpg);
                input_node(pos, 'p_hkpg', data_hkpg);
                input_node(pos, 'p_dpg', data_dpg);
                input_node(pos, 'p_rpg', data_rpg);
            }

            //Your Lineup 영역 처리
            console.log(total_salary);
            console.log(avg_salary);
            $('.total_salary').html($.number(total_salary));
            $('.total_fppg').html(total_fppg);
            $('.avg_salary').html($.number(avg_salary));

            //
            var del_player = $('.del-player');
            //del_player.css('cursor', 'pointer');
        }
    }

    function input_node(pos, node, text) {
        console.log("=== input_node ===");
        console.log(pos, node, text);

        var table = $(".lineup_" + pos).find('.' + node);
        $(".lineup_" + pos).children(".player-img").addClass('on');
        var count = table.length;
        //
        for (var i=0; i<count; i++) {
            //
            var innet_eq = table.eq(i);
            console.log(innet_eq.html());

            //2018-01-18 진경수 (디자인 수정)
            if (innet_eq.html() == "Player Name" ||
                innet_eq.html() == "Team" ||
                innet_eq.html() == "$ 0" ||
                innet_eq.html() == '<img src="/images/player_images/nba/default.png" width="50">' ||
                innet_eq.html() == '<img src="/images/player_images/soc/wc/img_s/home_s.png" width="50">' ||
                innet_eq.html() == '<img src="/images/player_images/soc/epl/img_s/home_s.png" width="50">' ||
                innet_eq.html() == '<img src="/images/player_images/soc/tsl/img_s/home_s.png" width="50">' ||
                innet_eq.html() == "<p style=\"background-image:url('/images/PUBG/pos/TL.png');background-size:100%;\"></p>" ||
                innet_eq.html() == "<p style=\"background-image:url('/images/PUBG/pos/R.png');background-size:100%;\"></p>" ||
                innet_eq.html() == "<p style=\"background-image:url('/images/PUBG/pos/GR.png');background-size:100%;\"></p>" ||
                innet_eq.html() == "<p style=\"background-image:url('/images/PUBG/pos/AR.png');background-size:100%;\"></p>" ||
                innet_eq.html() == "<p style=\"background-image:url('/images/PUBG/pos/BK.png');background-size:100%;\"></p>" ||
                innet_eq.html() == "<p style=\"background-image:url('/images/PUBG/pos/SU.png');background-size:100%;\"></p>" ||
                innet_eq.html() == "<p style=\"background-image:url('/images/PUBG/pos/UTIL.png');background-size:100%;\"></p>" ||
                innet_eq.html() == "") {
                innet_eq.html(text);
                return true;

            } else {
                if (node === 'player_name') {
                    if (text === innet_eq.html()) {
                        return false;
                    }
                }
                continue;
            }
        }
        return false;
    }

    function chk_flex(data_flex, node, name) {
        var table = $('.lineup_' + data_flex).find('.' + node);
        if (table.html() === name) {
            return false;
        } else {
            return true;
        }
    }

    function draft_proccess(data, edit) {
        console.log("=== draft_proccess ===");

        var data = data;
        var go_url = "";
        if (edit == 1) {
            go_url = "_edit";
        }

        data['player'] = {};
        var error = true;
        var del = $(".del").each(function (i) {
            if ($(this).html() == "") {
                alert('선수 선발을 완료해 주세요.');
                error = true;
                return false;

            } else {
                data['player'][i] = {};
                data['player'][i]['game_id'] = $(this).find("button").attr('data-game');
                data['player'][i]['player_id'] = $(this).find("button").attr('data-del-index');
                error = false;
            }
        });
        console.log(data);
        $.when(del).then(function () {
            if (error === false) {
                $.ajax({
                    url: "/ajax/draftgame"+ go_url +".php",
                    type: 'post',
                    data: data,
                    beforeSend: function () {
                        $(".btn-confirm-draft").attr("disabled", "");
                    },
                    success: function (data) {
                        console.log(data);

                        if (data === '100') {
                            if (isEdit==1) {
                                alert("콘테스트 수정이 완료되었습니다.");
                            } else {
                                alert("콘테스트 참여가 완료되었습니다.");
                            }

                            location.href = "/lineups/?sub=upcoming";

                        } else if (data === '411') {
                            alert('FP가 부족합니다.');
                            //location.replace('/index.php?menu=store');

                        } else if (data === '412') {
                            alert("중복 참여 횟수를 초과하였습니다.");
                            //location.replace('/index.php?menu=lobby');

                        } else {
                            $('.btn-confirm-draft').removeAttr('disabled', '');
                            alert('Error occurred');

                        }
                    }
                });
            }
        });
    }

    // 포지션 별로 정렬
    function sort(pos) {
        console.log("sort");

        var tbody = $("#player_list");

        if (pos === "ALL" || pos === "UTIL") {
            tbody.each(function () {
                tbody.find('tr').show();
            });
        } else if (pos === "FLEX") {
            tbody.find('tr').hide();
            tbody.each(function () {
                tbody.find('.pos_' + pos).show();
            });
        } else {
            tbody.find('tr').hide();
            tbody.each(function () {
                tbody.find('.pos_' + pos).show();
            });
        }
    }

    $(function () {
        get_player_list();

        $("#btnRandom").on("click", function() {
            console.log("=== btnRandom ===");

            //전체 제거
            $("#btnClear").trigger("click");

            var arrCate = ["<?=$gc_pos;?>"];
            var arrPos  = [];
            var rows    = $("#player_list").find("tr").toArray();
            console.log(rows);

            for (var i=0; i<arrCate.length; i++) {
                while (1) {
                    search_value    = "pos_"+ arrCate[i]; //포지션
                    console.log(search_value);
                    rand            = Math.floor((Math.random() * (rows.length - 1 - 0 + 1)) + 0); //랜덤 수
                    console.log(rand);

                    if (arrCate[i] != "UTIL") {
                        console.log("pos: "+ arrCate[i] + ", rand: "+ rand);
                        if (rows[rand].className.replace("pos_FLEX ", "").indexOf(search_value) != -1) {
                            //console.log(rows[rand].lastChild.lastElementChild);
                            arrPos.push(rand);
                            break;
                        }

                    } else {
                        console.log("pos: "+ arrCate[i] + ", rand: "+ rand);
                        if ($.inArray(rand, arrPos) == -1) {
                            //console.log(rows[rand].lastChild.lastElementChild);
                            arrPos.push(rand);
                            break;
                        }
                    }
                }
            }

            arrPos.forEach(function (value, index, array) {
                var obj             = rows[value].lastChild.lastElementChild;
                //var data_pos        = arrCate[index];
                var data_category   = $(obj).attr('data-category');
                var data_flex       = $(obj).attr('data-flex');
                var data_fppg       = $(obj).attr('data-fppg');
                var data_game       = $(obj).attr('data-game');
                var data_img_s      = $(obj).attr('data-img_s');
                var data_img_l      = $(obj).attr('data-img_l');
                var data_index      = $(obj).attr('data-index');
                var data_name       = $(obj).attr('data-name');
                var data_pos        = $(obj).attr('data-pos');
                var data_pos2       = $(obj).attr('data-pos2');
                var data_salary     = $(obj).attr('data-salary');
                var data_team       = $(obj).attr('data-team');

                if (data_category == "nba" || data_category == "nba_allstar") {
                    var data_mpg        = $(obj).attr('data-mpg');
                    var data_ppg        = $(obj).attr('data-ppg');
                    var data_rpg        = $(obj).attr('data-rpg');
                    var data_apg        = $(obj).attr('data-apg');
                    var data_bpg        = $(obj).attr('data-bpg');
                    var data_gg         = "";
                    var data_ag         = "";
                    var data_sg         = "";
                    var data_crsa       = "";
                    var data_inta       = "";
                    var data_dbpg       = "";
                    var data_kpg        = "";
                    var data_hkpg       = "";
                    var data_dpg        = "";
                    //var data_rpg        = "";

                } else if (data_category == "wc" || data_category == "epl" || data_category == "tsl") {
                    var data_mpg        = "";
                    var data_ppg        = "";
                    var data_rpg        = "";
                    var data_apg        = "";
                    var data_bpg        = "";
                    var data_gg         = $(obj).attr('data-gg');
                    var data_ag         = $(obj).attr('data-ag');
                    var data_sg         = $(obj).attr('data-sg');
                    var data_crsa       = $(obj).attr('data-crsa');
                    var data_inta       = $(obj).attr('data-inta');
                    var data_dbpg       = "";
                    var data_kpg        = "";
                    var data_hkpg       = "";
                    var data_dpg        = "";
                    //var data_rpg        = "";

                } else if (data_category == "pubg") {
                    var data_mpg        = "";
                    var data_ppg        = "";
                    //var data_rpg        = "";
                    var data_apg        = "";
                    var data_bpg        = "";
                    var data_gg         = "";
                    var data_ag         = "";
                    var data_sg         = "";
                    var data_crsa       = "";
                    var data_inta       = "";
                    var data_dbpg       = $(obj).attr('data-dbpg');
                    var data_kpg        = $(obj).attr('data-kpg');
                    var data_hkpg       = $(obj).attr('data-hkpg');
                    var data_dpg        = $(obj).attr('data-dpg');
                    var data_rpg        = $(obj).attr('data-rpg');
                    console.log(data_dpg);

                }

                //농구 G, F 포지션 예외 처리
                if (data_category == "nba" || data_category == "nba_allstar") {
                    if (arrCate[index] == "G" || arrCate[index] == "F" || arrCate[index] == "UTIL") {
                        //data_pos    = data_pos2;
                        data_pos    = arrCate[index];
                    }

                } else if (data_category == "wc" || data_category == "epl" || data_category == "tsl") {
                    if (value == "UTIL") {
                        data_pos    = "UTIL";
                    }

                } else if (data_category == "pubg") {
                    if (arrCate[index] == "G" || arrCate[index] == "F" || arrCate[index] == "UTIL") {
                        //data_pos    = data_pos2;
                        data_pos    = arrCate[index];
                    }

                }

                //추가
                addPlayer(data_pos, data_game, data_index, data_salary, data_name, data_team, data_flex, data_category, data_img_s, data_img_l, data_fppg, data_mpg, data_rpg, data_ppg, data_apg, data_bpg, data_gg, data_ag, data_sg, data_crsa, data_inta, data_dbpg, data_kpg, data_hkpg, data_dpg);
            });
        });

        $("#btnClear").on("click", function () {
            console.log("=== btnClear ===");

            $(".player_img").each(function (index) {
                if (what_category == "nba" || what_category == "nba_allstar") {
                    $(this).html('<img src="/public/images/player_images/nba/default.png" width="50">');

                } else if (what_category == "wc" || what_category == "epl" || what_category == "tsl") {
                    $(this).html('<img src="/public/images/player_images/soc/'+ what_category +'/img_s/home_s.png" width="50">');

                } else if (what_category == "pubg") {
                    if(index==0) {
                        $(this).html("<p style=\"background-image:url('/images/PUBG/pos/TL.png');background-size:100%;\"></p>");
                    } else if(index==1) {
                        $(this).html("<p style=\"background-image:url('/images/PUBG/pos/R.png');background-size:100%;\"></p>");
                    } else if(index==2) {
                        $(this).html("<p style=\"background-image:url('/images/PUBG/pos/GR.png');background-size:100%;\"></p>");
                    } else if(index==3) {
                        $(this).html("<p style=\"background-image:url('/images/PUBG/pos/AR.png');background-size:100%;\"></p>");
                    } else if(index==4) {
                        $(this).html("<p style=\"background-image:url('/images/PUBG/pos/BK.png');background-size:100%;\"></p>");
                    } else if(index==5) {
                        $(this).html("<p style=\"background-image:url('/images/PUBG/pos/SU.png');background-size:100%;\"></p>");
                    } else {
                        $(this).html("<p style=\"background-image:url('/images/PUBG/pos/UTIL.png');background-size:100%;\"></p>");
                    }
                }
            });
            $(".team_name").each(function () {
                $(this).html("Team");
            });
            $(".player_name").each(function () {
                $(this).html("Player Name");
            });
            $('.point').each(function () {
                $(this).html('');
            });
            $('.salary').each(function () {
                $(this).html('$ 0');
            });
            //상세 스텟 지우기
            $('.p_fppg').each(function () {
                $(this).html("");
            });

            if (what_category == "nba" || what_category == "nba_allstar") {
                $('.p_mpg').each(function () {
                    $(this).html("");
                });
                $('.p_ppg').each(function () {
                    $(this).html("");
                });
                $('.p_rpg').each(function () {
                    $(this).html("");
                });
                $('.p_apg').each(function () {
                    $(this).html("");
                });
                $('.p_bpg').each(function () {
                    $(this).html("");
                });

            } else if (what_category == "wc" || what_category == "epl" || what_category == "tsl") {
                $('.p_gg').each(function () {
                    $(this).html("");
                });
                $('.p_ag').each(function () {
                    $(this).html("");
                });
                $('.p_sg').each(function () {
                    $(this).html("");
                });
                $('.p_crsa').each(function () {
                    $(this).html("");
                });
                $('.p_inta').each(function () {
                    $(this).html("");
                });

            } else if (what_category == "pubg") {
                $('.p_dbpg').each(function () {
                    $(this).html("");
                });
                $('.p_kpg').each(function () {
                    $(this).html("");
                });
                $('.p_hkpg').each(function () {
                    $(this).html("");
                });
                $('.p_dpg').each(function () {
                    $(this).html("");
                });
                $('.p_rpg').each(function () {
                    $(this).html("");
                });

            }

            $(".del").each(function () {
                $(this).html("");
            });

            //남은 salary
            total_salary    = total_salary - total_salary + 50000;
            $('.total_salary').html($.number(total_salary));

            total_fppg      = 0;
            $('.total_fppg').html(total_fppg);

            //평균 salary
            avg_salary      = 0;
            $('.avg_salary').html($.number(avg_salary));
        });

        // 라인업 저장하기
        $(".btn-confirm-draft").on("click", function () {
            console.log("=== btn-confirm-draft ===");

            var coin = $(this).attr('data-coin');
            var category = $(this).attr('data-category');
            var game = $(this).attr('data-game');
            var data = {
                "edit": isEdit,
                "id": <?=$m_idx;?>,
                "coin": coin,
                "category": category,
                "game": game,
                "lu_idx": lu_idx
            };
            draft_proccess(data, isEdit);
        });

        $(".sort").on("click", function () {
            console.log("sort click");

            //tab_draft.find('li').removeClass('active');
            //$(this).addClass('active');
            var pos = $(this).attr('data-sort');
            if (pos === 'FLEX') {
                flex = true;
            } else {
                flex = false;
            }
            sort(pos);
        });

        // 선수 정보 페이어
        $(document).on("click", ".player_info", function () {
            console.log("=== player_info click ===");

            var game_id     = $(this).parent().find(".add_player").data('game');
            var index       = $(this).data('index');
            var category    = $(this).data('category');
            //
            var postData = {
                'cate': category,
                'g_id': game_id,
                'p_id': index
            };
            console.log(postData);

            $.ajax({
                url: "/ajax/player_detail.php",
                type: "POST",
                data: postData,
                success: function (data) {
                    //console.log(data);
                    $("#player-info").html(data);
                },
                beforeSend:function(){
                    $(".wrap-loading").removeClass("display-none");
                },
                complete:function(){
                    $(".wrap-loading").addClass("display-none");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });

    function delPlayer(category, id, pos) {
        var this_btn    = $('[data-del-index="' + id + '"]');
        //console.log(this_btn.parent().parent().next().find('.p_fppg').html());
        var salary      = parseInt((this_btn.parent().parent().find('.salary').text()).replace('$', '').replace(',', ''));
        var fppg        = parseFloat(this_btn.attr("data-fppg"));

        if (category == "nba" || category == "nba_allstar") {
            this_btn.parent().parent().find('.img').html('<img src="/images/player_images/nba/default.png" width="50">'); //2018-01-09 진경수 (디자인 수정)

        } else if (category == "wc" || category == "epl" || category == "tsl") {
            this_btn.parent().parent().find('.img').html('<img src="/images/player_images/soc/'+ category +'/img_s/home_s.png" width="50">');

        } else if (category == "pubg") {
            this_btn.parent().parent().find('.player_img').removeClass("on");
            this_btn.parent().parent().find('.player_img').html("<p style=\"background-image:url('/images/PUBG/pos/"+ pos +".png');background-size:100%;\"></p>");
        }

        this_btn.parent().parent().next().find('.p_fppg').html("0");
        this_btn.parent().parent().find('.player_name').html("Player Name");
        this_btn.parent().parent().find('.team_name').html("Team");
        //this_btn.parent().parent().find('.point').html("");
        this_btn.parent().parent().find('.salary').html("$ 0");
        //2018-05-23 진경수 (GG, AG, SG, CrsA, IntA 추가)
        this_btn.parent().parent().next().find('.p_fppg').html("");
        if (category == "nba" || category == "nba_allstar") {
            this_btn.parent().parent().next().find('.p_mpg').html("");
            this_btn.parent().parent().next().find('.p_ppg').html("");
            this_btn.parent().parent().next().find('.p_rpg').html("");
            this_btn.parent().parent().next().find('.p_apg').html("");
            this_btn.parent().parent().next().find('.p_bpg').html("");

        } else if (category == "wc" || category == "epl" || category == "tsl") {
            this_btn.parent().parent().next().find('.p_gg').html("");
            this_btn.parent().parent().next().find('.p_ag').html("");
            this_btn.parent().parent().next().find('.p_sg').html("");
            this_btn.parent().parent().next().find('.p_crsa').html("");
            this_btn.parent().parent().next().find('.p_inta').html("");

        } else if (category == "pubg") {
            this_btn.parent().parent().next().find('.p_dbpg').html("");
            this_btn.parent().parent().next().find('.p_kpg').html("");
            this_btn.parent().parent().next().find('.p_hkpg').html("");
            this_btn.parent().parent().next().find('.p_dpg').html("");
            this_btn.parent().parent().next().find('.p_rpg').html("");
        }
        this_btn.parent().parent().find('.del').html(""); //마지막에 처리

        //Your Lineup 영역
        total_salary    = total_salary + salary;
        $('.total_salary').html($.number(total_salary));

        total_fppg      = total_fppg - fppg;
        $('.total_fppg').html(total_fppg);

        avg_salary      = (50000 - total_salary) / 8;
        $('.avg_salary').html($.number(avg_salary));
    }
</script>
</body>
</html>