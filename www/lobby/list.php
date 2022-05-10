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
            <a class="inner" href="javascript:void(0)">
                <div class="visual-thumb">
                    <img src="/images/img_lcs.png" alt="LCS">
                </div>
                <div class="visual-detail">
                    <div class="contest-info">
                        <dl>
                            <dt class="contest-title">LCS</dt>
                            <dd class="contest-date">2022-03-14  IN 39 MINUTES, 12:00</dd>
                            <dd class="contest-loca"><img src="/images/ico_pin.svg" class="mR5" alt="위치">Lobo Solitário</dd>
                            <dd class="contest-detail">
                                <ul>
                                    <li>5v5</li>
                                    <li>€150.00</li>
                                    <li>1,254 Slots</li>
                                </ul>
                            </dd>
                        </dl>
                        <img src="/images/ico_lcs.png" alt="LCS">
                    </div>

                    <div class="parti-info">
                        <p class="prize-money">총 상금 <img src="/images/ico_gold.svg" alt="총 상금"> <b>650,000,000</b><span> point</span></p>
                        <p class="participant"><img src="/images/ico_peple.svg" alt="참여자 수" class="mR13"><span>978,673 </span> / 1,000,000</p>
                    </div>
                </div>
            </a>
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
                                        <p class="status">경기중</p>
                                        <small>{$db['g_date']}</small>
                                        <p class="time fc-yellow">19:15:27</p>
                                        <div class="game-logo"></div>
                                    </div>
                                    <button type="button" class="active">HOW TO PLAY <img class="mL10" src="/images/ico_triangle.svg" alt="게임참가"></button>
                                </div>
                            </div>

                            <div class="league-info">
                                <div class="league-title">
                                    <h2>{$db['g_name']}</h2>
                                    <div class="badge bg_free"><img src="/images/ico_free.svg" alt=""></div>
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
                                                    <th>Max Multi</th>
                                                    <th>My Entry</th>
                                                </tr>
                                                <tr>
                                                    <td>{$db['prize']}<img src="/images/ico_gold.svg" alt="총 상금" class="mL5"></td>
                                                    <td>{$db['g_fee']}<img src="/images/ico_gold.svg" alt="총 상금" class="mL5"></td>
                                                    <td>{$db['g_entry']} <span class="total">/ {$db['g_size']}</span></td>
                                                    <td>{$db['g_multi_max']}</td>
                                                    <td>{$db['g_entry']}</td>
                                                </tr>
                                            </table>
                                            <div class="status-detail">
                                                <p class="status">경기중</p>
                                                <small>2022-03-13 17:00:00:00</small>
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
                                        <button type="button" class="btn-blue slide-cont">게임참가</button>
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
                                    <div class="badge bg_free"><img src="/images/ico_top.svg" alt=""></div>
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
                                    <div class="badge bg_50"><img src="/images/ico_50.svg" alt=""></div>
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
            <!--sec-02-->
            <section class="sec sec-02 bg-grey">
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