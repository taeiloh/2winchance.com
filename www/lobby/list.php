<?php
// config
require_once __DIR__ .'/../_inc/config.php';

// 클래스
require_once __DIR__ .'/../class/RankReward.php';
require_once __DIR__ .'/../class/Contest.php';

// 세션 정리
$m_idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스

// 파라미터
$cate           = !empty($_GET['cate'])         ? $_GET['cate']         : 0;
$sub_menu       = !empty($_GET['sub_menu'])     ? $_GET['sub_menu']     : 0;
$g_date         = !empty($_GET['g_date'])         ? $_GET['g_date']         :"";
$gidx           = !empty($_GET['gidx'])         ? $_GET['gidx']         : 0;

$g_date1        =substr($g_date, 0, 10);
$year           =substr($g_date, 0, 4);
$month          =substr($g_date, 5,2);
$days           =substr($g_date, 8,2);

// 변수 정리
$where          = "";
$limit          = "";
$today          = date('Y-m-d');
$time           = date('Y-m-d H:i:s');

// cate
if (!empty($cate)) {
    $where      .= "AND g_sport = {$cate} ";
}

// sub_menu
switch ($sub_menu) {
    case 1:
        $where  .= "AND g_fee = 0 ";
        break;
    case 2:
        $where  .= "AND g_prize IN (4, 5) ";
        //$limit  = "LIMIT 5 ";
        break;
    case 3:
        $where  .= "AND g_prize = 7 ";
        break;
    case 4:
        $where  .= "AND g_prize = 8 ";
        break;
    case 5:
        $where  .= "AND g_prize = 9 ";
        break;
    case 6:
        $where  .= "AND g_prize = 1 ";
        break;
    default:
        break;
}

// 총 상금
$query    = "
    SELECT
        sum(g_fee * g_size) AS total_prize,
        sum(g_entry) AS total_entry,
        sum(g_size) AS total_size
    FROM game
    WHERE 1=1
        AND g_status != 3
        AND DATE_SUB(g_date, INTERVAL 5 HOUR) >= '{$g_date}'
        AND DATE_SUB(g_date, INTERVAL 5 HOUR) <= '{$g_date1} 23:59:59'
        /*AND g_name like '%%'*/
";
//p($query);
$result = $_mysqli->query($query);
if (!$result) {

}
$db = $result->fetch_assoc();
$total_prize    = $db['total_prize'] - ($db['total_prize'] * COMMISSION / 100);
$total_entry    = $db['total_entry'];
$total_size     = $db['total_size'];
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
        <!--visual-->
        <div id="visual">
            <div class="inner">
                <ul class="game-schedule">
                    <?php
                    $query  = "
                            SELECT
                                count(1) as count, timezone_type AS games_timezone_type, MIN(timezone_scheduled) AS games_timezone_scheduled
                            FROM pubg_game_daily_schedule
                            WHERE 1=1
                              AND game_status = 'scheduled'
                              AND timezone_scheduled > NOW()
                              AND timezone_scheduled >= '{$today} 00:00:00'
                              AND timezone_scheduled <= '{$today} 23:59:59'+ INTERVAL 10 DAY
                            GROUP BY date(timezone_scheduled)
                            ORDER BY timezone_scheduled ASC
                            LIMIT 7
                        ";
                    //p($query);
                    $result = $_mysqli_game->query($query);
                    if (!$result) {
                    }
                    $i = 0;
                    while ($db = $result->fetch_assoc()) {
                        if ($i==0) {
                            $start_date = "{$db['games_timezone_scheduled']}";
                            $start_hour = date('H', strtotime($start_date));
                            $start_min  = date('i', strtotime($start_date));
                        }
                        //p($db);
                        $games_timezone_scheduled1 = substr($db['games_timezone_scheduled'], 0, 10);
                        $games_timezone_scheduled2 = substr($db['games_timezone_scheduled'], 11, 5);
                        if ($g_date == $games_timezone_scheduled1) {

                            echo <<<LI
                    <li class="active">
                        <a href="/lobby/list.php?sub_menu={$sub_menu}&cate={$cate}&g_date={$games_timezone_scheduled1}">
                            <p>{$games_timezone_scheduled2} {$games_timezone_scheduled1}</p>
                            <p>{$db['count']} match PUBG</p>
                        </a>
                    </li>
LI;
                        }else{
                            echo <<<LI
                    <li>
                       <a href="/lobby/list.php?sub_menu={$sub_menu}&cate={$cate}&g_date={$games_timezone_scheduled1}">
                            <p>{$games_timezone_scheduled2} {$games_timezone_scheduled1}</p>
                            <p>{$db['count']} match PUBG</p>
                        </a>
                    </li>
LI;
                        }
                        $i++;
                    }
                    ?>
                    <!--li class="active">
                        <p>18:00 2022-05-20</p>
                        <p>16 match PUBG</p>
                    </li>
                    <li>
                        <p>18:00 2022-05-20</p>
                        <p>16 match PUBG</p>
                    </li>
                    <li>
                        <p>18:00 2022-05-20</p>
                        <p>16 match PUBG</p>
                    </li>
                    <li>
                        <p>18:00 2022-05-20</p>
                        <p>16 match PUBG</p>
                    </li>
                    <li>
                        <p>18:00 2022-05-20</p>
                        <p>16 match PUBG</p>
                    </li>
                    <li>
                        <p>18:00 2022-05-20</p>
                        <p>16 match PUBG</p>
                    </li>
                    <li>
                        <p>18:00 2022-05-20</p>
                        <p>16 match PUBG</p>
                    </li-->
                </ul>
                <div class="cont">
                    <div class="visual-thumb">
                    <span class="sample"></span>
                        <img src="/images/pubg_list.jpeg" alt="LCS">
                    </div>
                    <div class="visual-detail">
                        <div class="contest-info tab-wrap">
                            <ul class="tabs">
                                <li class="tab-link on" data-tab="tab-1"><button type="button">아시아</button></li>
                                <!--<li class="tab-link" data-tab="tab-2"><button type="button">아시아 태평양</button></li>
                                <li class="tab-link" data-tab="tab-3"><button type="button">유럽</button></li>
                                <li class="tab-link" data-tab="tab-3"><button type="button">아메리카</button></li>-->
                            </ul>
                            <div id="tab-1"  class="tab-content on">
                                <dl>
                                    <dd class="start-date">시작 시간 : <?=$start_date;?></dd>
                                    <dd class="timer">남은 시간 : <span class="day">0</span>일  <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b><?=number_format($total_prize);?></b><span> FP</span></p>
                                    <p class="participant"><img src="/images/ico_peple.svg" alt="참여자 수" class="mR13"><span><?=number_format($total_entry);?></span> / <?=number_format($total_size);?></p>
                                </div>
                            </div>
                            <!--<div id="tab-2"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : <?/*=$g_date*/?> 18:00:00</dd>
                                    <dd class="timer">남은 시간 : <span class="day">00</span>일  <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="/images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
                            <div id="tab-3"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : <?/*=$g_date*/?> 18:00:00</dd>
                                    <dd class="timer">남은 시간 : <span class="day">00</span>일  <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="/images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
                            <div id="tab-4"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : <?/*=$g_date*/?> 18:00:00</dd>
                                    <dd class="timer">남은 시간 : <span class="day">00</span>일  <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="/images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>-->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--//visual-->
        <!--content-->
        <div id="content">
            <!--sec-01-->
            <section class="sec sec-01 T0">
                <?php
                // sub_menu
                require_once __DIR__ .'/../common/lobby_sub_menu.php';
                ?>
                <div class="inner">
                    <div class="league-list">
                        <?php
                        // 리스트
                        $query    = "
                            SELECT
                                *
                                ,(g_fee * g_size) as prize
                            FROM game
                            WHERE 1=1
                                AND g_status != 3
                                AND DATE_SUB(g_date, INTERVAL 5 HOUR) >= '{$g_date}'
                                AND DATE_SUB(g_date, INTERVAL 5 HOUR) <= '{$g_date1} 23:59:59'
                                /*AND g_name like '%%'*/
                                {$where}
                            ORDER BY g_date ASC, prize DESC , g_name ASC
                            {$limit}
                        ";
                        //p($query);
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            // 변수 정리
                            $img_n  = str_replace('/', '', $db['g_name']);
                            $img_n  = str_replace('%', '', $img_n);
                            $badge  = get_badge_img($db['g_prize']);

                            // 클래스 호출
                            $rankReward     = new RankReward($db['g_size'], $db['g_fee'], $db['g_prize'], 4);
                            $total_reward   = number_format($rankReward->getTotal_reward());
                            $reward_info    = $rankReward->getReward_info($db['g_prize']);
                            $summary        = $rankReward->getSummary($db['g_prize']); // reward_info 보다 뒤에 호출 주의

                            // 게임 상태
                            $ago30min       = date('Y-m-d H:i:s', strtotime('-30 minutes', strtotime($db['g_date'])));
                            //p($ago30min);
                            if ($time > $ago30min) {
                                $gstatus        = 'Live';
                            } else if ($db['g_size'] > $db['g_entry']) {
                                $gstatus        = '대기';
                            } else {
                                $gstatus        = 'FULL';
                            }

                            $query_l    = "
                            SELECT count(*) as m_g_entry FROM lineups
                            WHERE 1=1 and lu_u_idx={$db['g_idx']}
                        ";
                            $result_l = $_mysqli->query($query_l);
                            $db_l = $result_l->fetch_assoc();
                            $m_entry=!empty($db_l['m_entry']) ? $db_l['m_entry'] : 0;

                            if($m_idx!="") {
                                $contestInfo = new Contest($m_idx, $db['g_idx'], $_mysqli);
                                $my_entry_cnt = $contestInfo->getCntJoinContest();
                            }else{
                                $my_entry_cnt=0;
                            }
                            if($sub_menu == 1){
                                $total_reward = 5000;
                                $reward_info = "
                        <ul>
                            <li class=\"first\">
                                <label>50/50</label>
                                <p>10 FP</p>
                            </li>
                        </ul>
                    ";
                                $summary = "
                    * 1000명으로 구성된 본 콘테스트는 총 5000 FP의 상금을 상위 순위 50%에게 지급합니다.<br/>
                    * 우승자의 상금은 각 10 FP입니다.<br/>
                ";
                            }
                            echo <<<DIV
                        <a id="gidx_{$db['g_idx']}"></a>
                        <div class="league-box">
                            <div class="league-thumb-box">
                                <div class="league-thumb" style="overflow: hidden;">
                                 <span class="sample"></span>
                                    <img src="/images/PUBG/output/{$img_n}.jpg" alt="게임 이미지 {$db['g_idx']}" title="{$db['g_idx']}"/>
                                    <div class="game-logo"><img src="/images/ico_pubg.png"></div>
                                </div>
                                <div class="status-detail">
                                    <div class="detail-box">
                                        <p class="status">{$gstatus}</p>
                                        <small>{$db['g_date']}</small>
                                        <p class="time fc-yellow"><span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></p>
                                        <div class="game-logo"></div>
                                    </div>
                                    <button type="button" class="active" onclick="go_url('/myPage/howtoplay.php');">게임 가이드 <img class="mL10" src="/images/ico_triangle.svg" alt="화살표 이미지"/></button>
                                </div>
                            </div>
                            <div class="league-info">
                                <div class="league-title">
                                    <h2>{$db['g_name']}</h2>
                                    {$badge}
                                    <button type="button" onclick="copy_url();"><img class="mR10" src="/images/ico_share.svg" alt="공유하기"/>공유하기</button>
                                </div>
                                <div class="league-detail">
                                    <div class="info-box">
                                        <div class="show">
                                            <table class="border-table">
                                                <colgroup>
                                                    <col>
                                                    <col>
                                                    <col>
                                                    <col>
                                                    <col>
                                                </colgroup>
                                                <tr>
                                                    <th>총 상금</th>
                                                    <th>참가비</th>
                                                    <th>참가자 수</th>
                                                    <th>중복 참여 가능</th>
                                                    <th>나의 참여</th>
                                                </tr>
                                                <tr>
                                                    <td>{$total_reward} FP</td>
                                                    <td>{$db['g_fee']} FP</td>
                                                    <td>{$db['g_entry']} <span class="total">/ {$db['g_size']}</span></td>
                                                    <td>{$db['g_multi_max']}</td>
                                                    <td>{$my_entry_cnt}</td>
                                                </tr>
                                            </table>
                                            <div class="status-detail">
                                                <p class="status">Live</p>
                                                <small>2022-03-13</small>
                                                <p class="time fc-yellow">19:15:27</p>
                                            </div>
                                        </div>
                                        <div class="slide-cont">
                                            <div class="league-desc">
                                                <div>
                                                    <h3>요약</h3>
                                                    <p>{$summary}</p>
                                                </div>
                                                <!--<div>
                                                    <h3>참가자</h3>
                                                    <a href="javascript:void(0);">참가자 리스트 자세히 보기</a>
                                                </div>-->
                                            </div>
                                            <div class="ranking">
                                                <div class="ranking-box">
                                                    <h4>상금</h4>
                                                    {$reward_info}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" id="btnDown{$db['g_idx']}" class="btn-grey btn-down">
                                         <span class="contest_num">G({$db['g_idx']})</span>
                                         <div><span>경기정보</span> <img src="/images/ico_arrow.svg" alt="더보기"></div>
                                        </button>
                                        <button type="button" onclick="go_draft({$db['g_idx']},'{$m_idx}' );" class="btn-blue slide-cont"> 게임참가</button>
                                    </div>
                                </div>
                            </div>
                        </div>
DIV;
                            if($gidx == $db['g_idx']) {
                                echo <<<SCRIPT
                        <script>
                            $(function () {
                                var offset = $("#gidx_{$gidx}").offset();
                                $("html,body").animate({scrollTop:offset.top - 200}, 400);

                                $("#btnDown{$gidx}").trigger("click");
                            });
                        </script>
SCRIPT;
                            }

                        }
                        ?>
                        <!--<div class="pagination">
                            <a class="active" href="javascript:void(0)">1</a>
                            <a class="" href="javascript:void(0)">2</a>
                            <a href="javascript:void(0)">3</a>
                            <a href="javascript:void(0)">4</a>
                        </div>-->
                    </div>
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
<script>
    function remaindTime() {
        var now = new Date(); //현재시간을 구한다.
        var end = new Date(<?=$year?>,<?=$month-1?>,<?=$days?>,<?=$start_hour;?>,<?=$start_min;?>,00);

        var endDays="<?=$days?>";
//오늘날짜의 저녁 9시 - 종료시간기준
        var open = new Date(now.getFullYear(),now.getMonth(),now.getDate(),09,00,00);
        //console.log(now.getFullYear());
        //console.log(now.getMonth());
        //console.log(now.getDate());
        //console.log(endDays);
//오늘날짜의 오전9시 - 오픈시간기준

        var nt = now.getTime(); // 현재의 시간만 가져온다
        var ot = open.getTime(); // 오픈시간만 가져온다
        var et = end.getTime(); // 종료시간만 가져온다.

        //console.log(end.getDay());
        /*
        if(months>0){
            var days=Number(endDays)+months*30-Number(now.getDate()); //마감까지의 날짜
        }else{

        }
        */

        //console.log(days);
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
        if(now>end){ //현재시간이 종료시간보다 크면
            $(".timer").html("종료 되었습니다.");
            //$(".time").fadeOut();
        }else{ //현재시간이 오픈시간보다 늦고 마감시간보다 이르면 마감시간까지 남은 시간을 구한다.
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
            $(".day").html(day);
            $(".hours").html(hour);
            $(".minutes").html(min);
            $(".seconds").html(sec);
        }
    }
    setInterval(remaindTime,1000); //1초마다 검사를 해주면 실시간으로 시간을 알 수 있다.
</script>
<input type="text" id="share_url" value="<?=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>" style="display: none;"/>
</body>
</html>
