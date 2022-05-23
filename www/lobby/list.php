<?php
// config
require_once __DIR__ .'/../_inc/config.php';

// 파라미터
$cate           = !empty($_GET['cate'])         ? $_GET['cate']         : 0;
$sub_menu       = !empty($_GET['sub_menu'])     ? $_GET['sub_menu']     : 0;

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
                    <li class="active">
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
                    </li>
                </ul>
                <div class="cont">
                    <div class="visual-thumb">
                        <img src="../images/img_lcs.png" alt="LCS">
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
                                    <dd class="start-date">시작 시간 : 2022-05-20 18:00:00</dd>
                                    <dd class="timer">남은 시간 : 00:00:00</dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="../images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
                            <div id="tab-2"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : 2022-05-20 18:00:00</dd>
                                    <dd class="timer">남은 시간 : 00:00:00</dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="../images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
                            <div id="tab-3"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : 2022-05-20 18:00:00</dd>
                                    <dd class="timer">남은 시간 : 00:00:00</dd>
                                </dl>
                                <div class="parti-info">
                                    <p class="prize-money">총 상금<b>650,000,000</b><span> FP</span></p>
                                    <p class="participant"><img src="../images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                                </div>
                            </div>
                            <div id="tab-4"  class="tab-content">
                                <dl>
                                    <dd class="start-date">시작 시간 : 2022-05-20 18:00:00</dd>
                                    <dd class="timer">남은 시간 : 00:00:00</dd>
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
                                AND DATE_SUB(g_date, INTERVAL 5 HOUR) >= '2022-05-10 00:00:00' 
                                AND DATE_SUB(g_date, INTERVAL 5 HOUR) <= '2022-05-10 23:59:59' 
                                AND g_name like '%%'
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

                            echo <<<DIV
                        <div class="league-box">
                            <div class="league-thumb-box">
                                <div class="league-thumb">
                                    <img src="/images/img_lol.png" alt="Marathon Legends - The Push">
                                    <p class="status">경기중</p>
                                    <div class="game-logo"></div>
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
                                    <div class="badge bg_free"></div>
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
                                        <button type="button" onclick="go_draft({$db['g_idx']});" class="btn-blue slide-cont">게임참가</button>
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
</body>
</html>