<?php
// config
require_once __DIR__ .'/../_inc/config.php';

// 파라미터
$cate           = !empty($_GET['cate'])         ? $_GET['cate']         : 0;
$g_date    = !empty($_GET['g_date'])         ? $_GET['g_date']         :"";
$g_date1=substr($g_date, 0, 10);

$sub_menu       = !empty($_GET['sub_menu'])     ? $_GET['sub_menu']     : 0;

$m_idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
// 변수 정리
$where          = "";
$limit          = "";

// cate
if (!empty($cate)) {
    $where      .= "AND g_sport = {$cate} ";
}

// sub_menu
switch ($sub_menu) {
    case 1:
        $where  .= "AND g_prize = 0 ";
        break;
    case 2:
        //$where  .= "";
        $limit  = "LIMIT 5 ";
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
                                count(1) as count, timezone_type AS games_timezone_type, MIN(standard_scheduled) AS games_timezone_scheduled
                            FROM pubg_game_daily_schedule
                            WHERE 1=1
                              AND game_status = 'scheduled'
                              AND standard_scheduled > NOW()
                              AND standard_scheduled >= '{$g_date} 10:00:00'
                              AND standard_scheduled <= '{$g_date1} 23:59:59' +INTERVAL 10 DAY
                            GROUP BY date(standard_scheduled)
                            ORDER BY standard_scheduled ASC
                            LIMIT 7
                        ";
                    //echo $query;
                    $result = $_mysqli_game->query($query);
                    if (!$result) {

                    }
                    while ($db = $result->fetch_assoc()) {
                        //p($db);
                        $games_timezone_scheduled1 = substr($db['games_timezone_scheduled'], 0, 10);
                        $games_timezone_scheduled2 = substr($db['games_timezone_scheduled'], 11, 5);
                        if ($g_date == $games_timezone_scheduled1) {
                            echo <<<LI
                    <li class="active">
                        <a href="/lobby/list.php?cate=20&g_date={$games_timezone_scheduled1}">
                            <p>{$games_timezone_scheduled2} {$games_timezone_scheduled1}</p>
                            <p>{$db['count']} match PUBG</p>
                        </a>
                    </li>
LI;
                        }else{
                            echo <<<LI
                    <li>
                       <a href="/lobby/list.php?cate=20&g_date={$games_timezone_scheduled1}">
                            <p>{$games_timezone_scheduled2} {$games_timezone_scheduled1}</p>
                            <p>{$db['count']} match PUBG</p>
                        </a>
                    </li>
LI;
                        }
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
                        <img src="../images/pubg_list.jpeg" alt="LCS">
                    </div>
                    <div class="visual-detail">
                        <div class="contest-info tab-wrap">
                            <ul class="tabs">
                                <li class="tab-link on" data-tab="tab-1"><button type="button">아시아</button></li>
                                <li class="tab-link" data-tab="tab-2"><button type="button">아시아 태평양</button></li>
                                <li class="tab-link" data-tab="tab-3"><button type="button">유럽</button></li>
                                <li class="tab-link" data-tab="tab-3"><button type="button">아메리카</button></li>
                            </ul>
                            <div id="tab-1"  class="tab-content on">
                                <dl>
                                    <dd class="start-date">시작 시간 : <?=$g_date?> 18:00:00</dd>
                                    <dd class="timer">남은 시간 : <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="../images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
                            <div id="tab-2"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : <?=$g_date?> 18:00:00</dd>
                                    <dd class="timer">남은 시간 : <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="../images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
                            <div id="tab-3"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : <?=$g_date?> 18:00:00</dd>
                                    <dd class="timer">남은 시간 : <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="../images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
                            <div id="tab-4"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : <?=$g_date?> 18:00:00</dd>
                                    <dd class="timer">남은 시간 : <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span></dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="../images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
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
                                AND g_name like '%%'
                                {$where}
                            ORDER BY g_date ASC, prize DESC , g_name ASC
                            {$limit}
                        ";
                        //echo $query;
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            // 변수 정리

                            echo <<<DIV
                        <div class="league-box">
                            <div class="league-thumb-box">
                                <div class="league-thumb" style="overflow: hidden;">
                                    <img src="/images/PUBG/output/{$db['g_name']}.jpg" alt="Marathon Legends - The Push" width="400px">
                                    <div class="game-logo"><img src="/images/pubg.png"></div>
                                </div>
                                <div class="status-detail">
                                    <div class="detail-box">
                                        <p class="status">Live</p>
                                        <small>{$db['g_date']}</small>
                                        <p class="time fc-yellow">19:15:27</p>
                                        <div class="game-logo"></div>
                                    </div>
                                    <button type="button" class="active">게임 가이드 <img class="mL10" src="/images/ico_triangle.svg" alt="게임참가"></button>
                                </div>
                            </div>

                            <div class="league-info">
                                <div class="league-title">
                                    <h2>{$db['g_name']}</h2>
                                    <div class="badge">
                                        <img src="../images/Contest_Mod_2X.png" alt="더블">
                                    </div>
                                    <button type="button"><img class="mR10" src="/images/ico_share.svg" alt="공유하기">공유하기</button>
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
                                                    <td>{$db['prize']} FP</td>
                                                    <td>{$db['g_fee']} FP</td>
                                                    <td>{$db['g_entry']} <span class="total">/ {$db['g_size']}</span></td>
                                                    <td>{$db['g_multi_max']}</td>
                                                    <td>{$db['g_entry']}</td>
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
                                                    <p>매치 게임을 플레이 하여 티어를 획득하고 챌린지 모드 공식 랭킹을
                                                        획득 해 보세요!</p>
                                                </div>
                                                <div>
                                                    <h3>참가자</h3>
                                                    <a href="javascript:void(0);">참가자 리스트 자세히 보기</a>
                                                </div>
                                            </div>
                                            <div class="ranking">
                                                <div class="ranking-box">
                                                    <h4>상금</h4>
                                                    <ul>
                                                        <li class="first">
                                                            <label>1위</label>
                                                            <p>702</p>
                                                        </li>
                                                        <li>
                                                            <label>2위</label>
                                                            <p>200</p>
                                                        </li>
                                                        <li>
                                                            <label>3위</label>
                                                            <p>100</p>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn-grey btn-down"><span>경기정보</span> <img src="/images/ico_arrow.svg" alt="더보기"></button>
                                        <button type="button" onclick="go_draft({$db['g_idx']},'{$m_idx}' );" class="btn-blue slide-cont">게임참가</button>
                                    </div>
                                </div>
                            </div>
                        </div>
DIV;

                        }
                        ?>

                        <div class="league-box ready">
                            <div class="league-thumb-box">
                                <div class="league-thumb">
                                    <img src="/images/img_lol.png" alt="Marathon Legends - The Push">
                                    <p class="count">23:30:05 초 남음</p>
                                    <div class="game-logo"></div>
                                </div>
                            </div>
                            <div class="league-info">
                                <div class="league-title">
                                    <h2>Marathon Legends - The Push</h2>
                                    <div class="badge"></div>
                                    <button type="button"><img class="mR10" src="/images/ico_share.svg" alt="공유하기">공유하기</button>
                                </div>
                                <div class="league-detail">
                                    <div class="info-box">
                                        <div class="show">
                                            <dl>
                                                <dt>
                                                    경기예정일<span class="line"></span>2022년 4월 24일
                                                </dt>
                                                <dd><img src="/images/ico_pin.svg" class="mR5" alt="위치">Lobo Solitário</dd>
                                                <dd class="contest-detail">
                                                    <ul>
                                                        <li>5v5</li>
                                                        <li>€150.00</li>
                                                        <li>1,254 Slots</li>
                                                    </ul>
                                                </dd>
                                                <dd><img src="/images/ico-people-w.svg" class="mR5" alt="예정 호스팅">Masmorra 님 호스팅 예정</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn-grey btn-down" disabled><span>경기정보</span> <img src="/images/ico_arrow.svg" alt="더보기"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="league-box ready">
                            <div class="league-thumb-box">
                                <div class="league-thumb">
                                    <img src="/images/img_lol.png" alt="Marathon Legends - The Push">
                                    <p class="count">23:30:05 초 남음</p>
                                    <div class="game-logo"></div>
                                </div>
                            </div>
                            <div class="league-info">
                                <div class="league-title">
                                    <h2>Marathon Legends - The Push</h2>
                                    <div class="badge"></div>
                                    <button type="button"><img class="mR10" src="/images/ico_share.svg" alt="공유하기">공유하기</button>
                                </div>
                                <div class="league-detail">
                                    <div class="info-box">
                                        <div class="show">
                                            <dl>
                                                <dt>
                                                    경기예정일<span class="line"></span>2022년 4월 24일
                                                </dt>
                                                <dd><img src="/images/ico_pin.svg" class="mR5" alt="위치">Lobo Solitário</dd>
                                                <dd class="contest-detail">
                                                    <ul>
                                                        <li>5v5</li>
                                                        <li>€150.00</li>
                                                        <li>1,254 Slots</li>
                                                    </ul>
                                                </dd>
                                                <dd><img src="/images/ico-people-w.svg" class="mR5" alt="예정 호스팅">Masmorra 님 호스팅 예정</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn-grey btn-down" disabled><span>경기정보</span> <img src="/images/ico_arrow.svg" alt="더보기"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pagination">
                            <a class="active" href="javascript:void(0)">1</a>
                            <a class="" href="javascript:void(0)">2</a>
                            <a href="javascript:void(0)">3</a>
                            <a href="javascript:void(0)">4</a>
                        </div>
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