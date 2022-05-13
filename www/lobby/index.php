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
            <section class="sec sec-01 bg-black">
                <div class="inner">
                    <ul class="game-list">
                        <li>
                            <a href="javascript:void(0)" class="game-info">
                                <div class="game-thumb" style="background-image: url('../images/thumb_lol.png')"></div>
                                <h2>리그 오브 레전드</h2>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="game-info">
                                <div class="game-thumb" style="background-image: url('../images/thumb_battle.png')"></div>
                                <h2>배틀그라운드</h2>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="game-info">
                                <div class="game-thumb" style="background-image: url('../images/thumb_dota.png')"></div>
                                <h2>DOTA 2</h2>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="game-info">
                                <div class="game-thumb" style="background-image: url('../images/thumb_csgo.png')"></div>
                                <h2>CS:GO</h2>
                            </a>
                        </li>
                    </ul>
                </div>
            </section>
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
                                    <div class="contest-ico">
                                        <!--<img src="" alt="임시">-->
                                    </div>
                                    <dl>
                                        <!--<dt class="contest-schedule">내일 경기 예정</dt>-->
                                        <dt class="contest-schedule">{$db['games_timezone_scheduled']}</dt>
                                        <!--<dt class="contest-title">COD:M 커뮤니티</dt>-->
                                        <dt class="contest-title">{$db['count']} GAMES</dt>
                                        <dd class="contest-detail">
                                            <ul>
                                                <li><img src="/images/ico_pin.svg" class="mR5" alt="위치">LAS</li>
                                                <li>5v5</li>
                                                <li>€150.00</li>
                                                <li>1,254 Slots</li>
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