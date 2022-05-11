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
    <script>
        function get_player_list() {
            // ajax
            var postData = {
                "index": 24824
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
            tr += '<td class="center" style="width:65px;">' + json[1] + '</td>';
            tr += '<td colspan="2" class="left player_info" style="cursor:pointer" data-category="' + json[15] + '" data-index="' + json[14] + '">';
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
                tr += json[2] + ' ' + json[3];
                name = json[11] + ' ' + json[12];
            }
            //
            tr += '</td>';
            tr += '<td style="width:100px;">' + json[4] + '</td>';
            tr += '<td style="width:75px;">' + json[5] + '</td>';
            /*tr += '<td>' + json[5] + '</td>';
            tr += '<td style="text-align:right">$</td>';*/
            tr += '<td style="width:75px;">$ ' + json[6];
            tr += '<td style="width:55px;">';
            tr += '<img class="add_player" ';
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
            tr += 'src="/public_new/img/ico_plus.png" />';
            tr += '</td>';
            tr += '</tr>';

            return tr;
        }

        $(function () {
            get_player_list();
        });
    </script>
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
            <a class="inner" href="javascript:void(0)">
                <div class="visual-thumb">
                    <img src="../images/img_lcs.png" alt="LCS">
                </div>
                <div class="visual-detail">
                    <div class="contest-info">
                        <dl>
                            <dt class="contest-title">LCS</dt>
                            <dd class="contest-date">2022-03-14  IN 39 MINUTES, 12:00</dd>
                            <dd class="contest-loca"><img src="../images/ico_pin.svg" class="mR5" alt="위치">Lobo Solitário</dd>
                            <dd class="contest-detail">
                                <ul>
                                    <li>5v5</li>
                                    <li>€150.00</li>
                                    <li>1,254 Slots</li>
                                </ul>
                            </dd>
                        </dl>
                        <img src="../images/ico_lcs.png" alt="LCS">
                    </div>
                    <div class="parti-info">
                        <div class="info-box border">
                            <table>
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
                                    <td>702<img src="../images/ico_gold.svg" alt="총 상금" class="mL5"></td>
                                    <td>5<img src="../images/ico_gold.svg" alt="총 상금" class="mL5"></td>
                                    <td>603 <span class="total">/ 1,000</span></td>
                                    <td>5</td>
                                    <td>10</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </a>
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
                                    <div class="swiper-slide"><a href="javascript:void(0)">
                                            <p class="team-name">ALL</p>
                                        </a></div>
                                    <div class="swiper-slide active">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)">
                                            <p class="team-name">CA</p>
                                            <p class="date">03월26일</p>
                                            <p class="time">05:00 AM</p>
                                        </a>
                                    </div>
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
                        <div class="player-info">
                            <div class="player-img">
                                <img src="../images/img_player.png" alt="이상혁 프로필 사진">
                            </div>
                            <div class="player-skill">
                                <div class="skill-top">
                                    <div class="name">
                                        <h2><span class="fc-yellow">T1</span>Faker</h2>
                                        <p>이상혁</p>
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
                                            <th>M</th>
                                            <th>W</th>
                                            <th>L</th>
                                            <th>승률</th>
                                            <th>KDA</th>
                                        </tr>
                                        <tr>
                                            <td>722</td>
                                            <td>238</td>
                                            <td>238</td>
                                            <td>67%</td>
                                            <td>66.1%</td>
                                        </tr>
                                    </table>
                                    <button type="button" class="btn-plus"></button>
                                </div>
                                <div class="skill-bottom">
                                    <div class="player-salary">
                                        <p><span class="fc-blue">연봉</span>$963,000</p>
                                        <button type="button" class="btn-yellow player-stats open-btn" data-target="modal-1">FULL STATS</button>
                                    </div>
                                    <table class="bg-table">
                                        <colgroup>
                                            <col>
                                            <col>
                                            <col>
                                            <col>
                                            <col>
                                            <col>
                                            <col>
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th>TK</th>
                                            <th>TD</th>
                                            <th>TA</th>
                                            <th>K/M</th>
                                            <th>D/M</th>
                                            <th>A/M</th>
                                            <th>KDA</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>2561</td>
                                            <td>3.5</td>
                                            <td>3790</td>
                                            <td>3.2</td>
                                            <td>2</td>
                                            <td>5.2</td>
                                            <td>4.4</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="category-wrap">
                            <ul class="category">
                                <li class="active"><a href="javascript:void(0)">ALL</a></li>
                                <li><a href="javascript:void(0)">TL</a></li>
                                <li><a href="javascript:void(0)">R</a></li>
                                <li><a href="javascript:void(0)">GR</a></li>
                                <li><a href="javascript:void(0)">AR</a></li>
                                <li><a href="javascript:void(0)">UTIL</a></li>
                            </ul>
                            <button class="random-btn">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                RANDOM PICK
                            </button>
                        </div>
                        <table class="contents-table">
                            <colgroup>
                                <col style="width: 16%;">
                                <col style="width: 16%">
                                <col style="width: 16%;">
                                <col style="width: 16%;">
                                <col style="width: 16%;">
                                <col style="width: 300px">
                            </colgroup>
                            <thead>
                            <tr>
                                <th>POS</th>
                                <th>NAME</th>
                                <th>TEAM</th>
                                <th>FPPG</th>
                                <th>SALARY</th>
                                <th>
                                    <input type="search" placeholder="플레이어를 검색해주세요.">
                                    <button class="search-btn"></button>
                                </th>
                            </tr>
                            </thead>
                        </table>
                        <div class="scroll-tbody">
                            <table class="contents-table">
                                <colgroup>
                                    <col style="width: 16%;">
                                    <col style="width: 16%;">
                                    <col style="width: 16%;">
                                    <col style="width: 16%;">
                                    <col style="width: 16%;">
                                    <col style="width: 282px">
                                </colgroup>
                                <tbody id="player_list">
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>60</td>
                                    <td>$ 3,000</td>
                                    <td class="tR"><button type="button" class="btn-plus"></button></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="league-right">
                        <ul class="lineup-info">
                            <li>
                                <dl>
                                    <dt>Salary Remaining</dt>
                                    <dd>$ 26,000</dd>
                                </dl>
                            </li>
                            <li>
                                <dl>
                                    <dt>Total FPPG</dt>
                                    <dd>1500</dd>
                                </dl>
                            </li>
                            <li>
                                <dl>
                                    <dt>Avg / Player</dt>
                                    <dd>$ 3,000</dd>
                                </dl>
                            </li>
                        </ul>
                        <div class="select-player">
                            <ul>
                                <li class="player-info">
                                    <div class="player-img">
                                        <img src="../images/img_player.png" width="80" alt="이상혁 프로필 사진">
                                    </div>
                                    <div class="player-skill">
                                        <div class="skill-top">
                                            <div class="name">
                                                <h2><span class="fc-blue">T1</span>Faker</h2>
                                                <p class="player-money">$3,000</p>
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
                                                    <th>M</th>
                                                    <th>W</th>
                                                    <th>L</th>
                                                    <th>승률</th>
                                                    <th>KDA</th>
                                                </tr>
                                                <tr>
                                                    <td>722</td>
                                                    <td>238</td>
                                                    <td>238</td>
                                                    <td>67%</td>
                                                    <td>66.1%</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-delete">삭제</button>
                                </li>
                                <li class="player-info">
                                    <div class="player-img">
                                        <img src="../images/img_player.png" width="80" alt="이상혁 프로필 사진">
                                    </div>
                                    <div class="player-skill">
                                        <div class="skill-top">
                                            <div class="name">
                                                <h2><span class="fc-blue">T1</span>Faker</h2>
                                                <p class="player-money">$3,000</p>
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
                                                    <th>M</th>
                                                    <th>W</th>
                                                    <th>L</th>
                                                    <th>승률</th>
                                                    <th>KDA</th>
                                                </tr>
                                                <tr>
                                                    <td>722</td>
                                                    <td>238</td>
                                                    <td>238</td>
                                                    <td>67%</td>
                                                    <td>66.1%</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-delete">삭제</button>
                                </li>
                                <li class="player-info">
                                    <div class="player-img">
                                        <img src="../images/img_player.png" width="80" alt="이상혁 프로필 사진">
                                    </div>
                                    <div class="player-skill">
                                        <div class="skill-top">
                                            <div class="name">
                                                <h2><span class="fc-blue">T1</span>Faker</h2>
                                                <p class="player-money">$3,000</p>
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
                                                    <th>M</th>
                                                    <th>W</th>
                                                    <th>L</th>
                                                    <th>승률</th>
                                                    <th>KDA</th>
                                                </tr>
                                                <tr>
                                                    <td>722</td>
                                                    <td>238</td>
                                                    <td>238</td>
                                                    <td>67%</td>
                                                    <td>66.1%</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-delete">삭제</button>
                                </li>
                                <li class="player-info">
                                    <div class="player-img">
                                        <img src="../images/img_player.png" width="80" alt="이상혁 프로필 사진">
                                    </div>
                                    <div class="player-skill">
                                        <div class="skill-top">
                                            <div class="name">
                                                <h2><span class="fc-blue">T1</span>Faker</h2>
                                                <p class="player-money">$3,000</p>
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
                                                    <th>M</th>
                                                    <th>W</th>
                                                    <th>L</th>
                                                    <th>승률</th>
                                                    <th>KDA</th>
                                                </tr>
                                                <tr>
                                                    <td>722</td>
                                                    <td>238</td>
                                                    <td>238</td>
                                                    <td>67%</td>
                                                    <td>66.1%</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-delete">삭제</button>
                                </li>
                            </ul>
                            <div class="btn-group">
                                <button type="button" class="btn-8 btn-grey">전부 삭제하기</button>
                                <button type="button" class="btn-8 btn-blue">라인업 저장하기</button>
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
                            <img src="../images/img_player.png" alt="이상혁 프로필 사진">
                        </div>
                        <div class="player-skill">
                            <p class="fc-yellow"><b class="fc-blue mR10">T1</b>DRX</p>
                            <h2 class="name">Faker <span>이상혁</span></h2>
                            <p class="fc-blue">연봉 <b>$3,000</b></p>
                            <p class="next-game">NEXT GAME A@B 2022.04.21 10:00:00 GMT</p>
                        </div>
                        <button type="button" class="btn-blue">선수 추가하기</button>
                    </div>
                    <div class="skill-box">
                        <dl>
                            <dt>1</dt>
                            <dd>DBPG</dd>
                        </dl>
                        <dl>
                            <dt>1</dt>
                            <dd>KPG</dd>
                        </dl>
                        <dl>
                            <dt>0</dt>
                            <dd>HKPG</dd>
                        </dl>
                        <dl>
                            <dt>205.37</dt>
                            <dd>DPG</dd>
                        </dl>
                        <dl>
                            <dt>0</dt>
                            <dd>RPG</dd>
                        </dl>
                    </div>
                </div>
                <div class="player-news">
                    <ul class="tabs">
                        <li class="on" data-tab="tabs-1"><a href="javascript:void(0)">SUMMARY</a></li>
                        <li data-tab="tabs-2"><a href="javascript:void(0)">SPLIT STATS</a></li>
                    </ul>
                    <div id="tabs-1" class="tab-content on">
                        <h3>PLAYER NEWS</h3>
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
                                <th>TSPG</th>
                                <th>DBNO</th>
                                <th>Kill</th>
                                <th>RK</th>
                                <th>DMB</th>
                                <th>Heal</th>
                                <th>RP</th>
                                <th>RV</th>
                                <th>TK</th>
                            </tr>
                            <tr>
                                <td>722</td>
                                <td>238</td>
                                <td>238</td>
                                <td>67%</td>
                                <td>66.1%</td>
                                <td>66.1%</td>
                                <td>66.1%</td>
                                <td>66.1%</td>
                                <td>66.1%</td>
                            </tr>
                        </table>
                    </div>
                    <div id="tabs-2" class="tab-content">
                        <h3>PLAYER NEWS</h3>
                        <div class="game-date">
                            <p class="label">Date</p>
                            <p>Phase1</p>
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
                                <th>TSPG</th>
                                <th>DBNO</th>
                                <th>Kill</th>
                                <th>RK</th>
                                <th>DMB</th>
                                <th>Heal</th>
                                <th>RP</th>
                                <th>RV</th>
                                <th>TK</th>
                            </tr>
                            <tr>
                                <td>722</td>
                                <td>238</td>
                                <td>238</td>
                                <td>67%</td>
                                <td>66.1%</td>
                                <td>66.1%</td>
                                <td>66.1%</td>
                                <td>66.1%</td>
                                <td>66.1%</td>
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
</body>
</html>