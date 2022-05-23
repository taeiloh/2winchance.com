<?php
// config
require_once __DIR__ .'/../_inc/config.php';

// 파라미터
$idx        = !empty($_GET['index'])        ? $_GET['index']        : 0;

$query  = "
    SELECT * FROM game
          LEFT JOIN game_category
          ON gc_idx = g_sport
          WHERE 1=1
            AND g_idx = {$idx}
";
$result = $_mysqli->query($query);
if (!$result) {

}
$db = $result->fetch_assoc();
p($db);
$pos    = json_decode($db['gc_pos'], true);
?>
<!doctype html>
<html lang="ko">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
    <script src="http://dev.spo-bit.com/public_new/js/moment.js"></script>
    <script src="http://dev.spo-bit.com/public_new/js/moment-timezone-with-data.js"></script>
    <script type="text/javascript" src="http://dev.spo-bit.com/public/js/jquery.number.min.js"></script>
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
        var what_category   = "pubg";
        var count_time      = $("#game_date").attr('data-next-game');
        var nextDate        = moment.tz(count_time, "GMT");
        var total_salary    = parseInt($(".total_salary").text().replace(",", ""));
        var total_fppg      = 0;
        var avg_salary      = (50000 - total_salary) / 8;
        var flex            = false;
        var tab_draft       = $(".dp_tab_draft");

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
                    init_add_player();
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
            tr += '<td>' + json[1] + '</td>';
            tr += '<td style="cursor:pointer" data-category="' + json[15] + '" data-index="' + json[14] + '">';
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
            tr += '<td>' + json[4] + '</td>';
            tr += '<td>' + json[5] + '</td>';
            /*tr += '<td>' + json[5] + '</td>';
            tr += '<td style="text-align:right">$</td>';*/
            tr += '<td>$ ' + json[6];
            tr += '<td class="tR">';
            tr += '<button class="btn-plus add_player" ';
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
            console.log("init_add_player");

            var add_player = $(".add_player");

            //왼쪽 선수 리스트에서 + 클릭 시
            add_player.on("click", function () {
                console.log("add_player click");

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
            console.log("addPlayer");

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
                        alert('You have already selected that position. (001)');
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
                    alert('You have already selected that position. (002)');
                    return;
                }

                if (input_node(pos, "player_name", name) === true) {
                    //선택된 선수 개수 찾기
                    cnt = $(".del-player").length + 1;

                    total_salary    = total_salary - salary;
                    total_fppg      = total_fppg + parseFloat(fppg);
                    avg_salary      = (50000 - total_salary) / cnt;

                } else {
                    alert('You have already selected that position. (003)');
                    return;
                }

                //선수 이미지를 위해서 name 파싱
                if (category == "nba" || category == "nba_allstar") {
                    name = name.replace(" ", "+");
                    input_node(pos, 'player_img', '<img src="http://dev.spo-bit.com/public/images/player_images/nba/'+ name +'.png" width="50" alt="" onerror=\'this.src="/public/images/player_images/nba/default.png"\' />');

                } else if (category == "wc" || category == "epl" || category == "tsl") {
                    name = name.replace(" ", "+");
                    input_node(pos, 'player_img', '<img src="http://dev.spo-bit.com/public/images/player_images/soc/'+ category + img_s +'" width="50" alt="" onerror=\'this.src="/public/images/player_images/soc/'+ category +'/img_s/home_s.png"\' />');

                } else if (category == "pubg") {
                    name = name.split(" ");
                    input_node(pos, 'player_img', '<img src="http://dev.spo-bit.com/public/images/player_images/pubg/'+ name[1] +'.jpg" alt="" onerror=\'this.src="http://dev.spo-bit.com//public/images/player_images/pubg/default.png"\' style="width: 80px;" />');

                }

                input_node(pos, 'team_name', team);
                input_node(pos, 'point', '0');
                input_node(pos, 'salary', '$' + $.number(salary));
                input_node(pos, 'del', '<button class="btn-delete" data-fppg="'+ fppg +'" data-del-index ="' + id + '" data-game ="' + game_id + '" onclick="delPlayer(\''+ category +'\', \'' + id + '\');">삭제</button>');
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
                $('.total_salary').html($.number(total_salary));
                $('.total_fppg').html(total_fppg);
                $('.avg_salary').html($.number(avg_salary));

                //
                var del_player = $('.del-player');
                //del_player.css('cursor', 'pointer');
            }
        }

        function input_node(pos, node, text) {
            console.log(pos, node, text);

            var table = $(".lineup_" + pos).find('.' + node);
            var count = table.length;
            //
            for (var i = 0; i < count; i++) {
                //
                var innet_eq = table.eq(i);
                console.log(innet_eq.html());

                //2018-01-18 진경수 (디자인 수정)
                if (innet_eq.html() == "Name" ||
                    innet_eq.html() == "Team" ||
                    innet_eq.html() == "$ 0" ||
                    innet_eq.html() == '<img src="http://dev.spo-bit.com/public/images/player_images/nba/default.png" width="50">' ||
                    innet_eq.html() == '<img src="http://dev.spo-bit.com/public/images/player_images/soc/wc/img_s/home_s.png" width="50">' ||
                    innet_eq.html() == '<img src="http://dev.spo-bit.com/public/images/player_images/soc/epl/img_s/home_s.png" width="50">' ||
                    innet_eq.html() == '<img src="http://dev.spo-bit.com/public/images/player_images/soc/tsl/img_s/home_s.png" width="50">' ||
                    innet_eq.html() == '<img src="http://dev.spo-bit.com/public/images/player_images/pubg/default.png" width="80" alt="">' ||
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

        function draft_proccess(data, url) {
            console.log("draft_proccess");

            var data = data;
            var go_url = '';
            if (url) {
                go_url = url;
            }

            data['player'] = {};
            var error = true;
            var del = $('.del').each(function (i) {
                if ($(this).html() === '') {
                    alert('You must select all positions.');
                    error = true;
                    return false;
                } else {
                    data['player'][i] = {};
                    data['player'][i]['game_id'] = $(this).find('img').attr('data-game');
                    data['player'][i]['player_id'] = $(this).find('img').attr('data-del-index');
                    error = false;
                }
            });
            $.when(del).then(function () {
                if (error === false) {
                    $.ajax({
                        url: '/ajax/draftgame.php',
                        type: 'post',
                        data: data,
                        beforeSend: function () {
                            $('.btn-confrim-draft').attr('disabled', '');
                        },
                        success: function (data) {
                            //console.log(data);
                            if (data === '100') {
                                alert('Completed');
                                location.replace('index.php?menu=contests');
                                return false;
                            } else if (data === '411') {
                                alert('Not enough Gold.');
                                location.replace('/index.php?menu=store');
                                return false;
                            } else if (data === '412') {
                                alert('You have already reached Max entry limit.');
                                location.replace('/index.php?menu=lobby');
                                return false;
                            } else {
                                $('.btn-confrim-draft').removeAttr('disabled', '');
                                alert('Error occurred');
                                return false;
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

            $('.btn-confrim-draft').on("click", function () {
                console.log("btn-confrim-draft click");

                var coin = $(this).attr('data-coin');
                var category = $(this).attr('data-category');
                var game = $(this).attr('data-game');
                var data = {
                    'id': '10031',
                    'coin': coin,
                    'category': category,
                    'game': game
                };
                draft_proccess(data);
                event.stopPropagation();
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
                            <dd class="contest-loca"><img src="/images/ico_pin.svg" class="mR5" alt="위치">Lobo Solitário</dd>
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
                                    <th>중복 참여 가능</th>
                                    <th>나의 참여</th>
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
                                    while ($db = $result->fetch_assoc()) {
                                        echo <<<DIV
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0)" data-home_id="{$db['home_id']}" data-away_id="{$db['away_id']}">
                                            <p class="team-name">{$db['home_alias']} @ {$db['away_alias']}</p>
                                            <p class="date">{$db['sch_date']}</p>
                                            <p class="time">{$db['sch_time']}</p>
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
                            <ul class="category dp_tab_draft">
                                <li class="active sort" data-sort="ALL"><a href="javascript:void(0);">ALL</a></li>
                                <li class="sort" data-sort="TL"><a href="javascript:void(0);">TL</a></li>
                                <li class="sort" data-sort="R"><a href="javascript:void(0);">R</a></li>
                                <li class="sort" data-sort="GR"><a href="javascript:void(0);">GR</a></li>
                                <li class="sort" data-sort="AR"><a href="javascript:void(0);">AR</a></li>
                                <li class="sort" data-sort="UTIL"><a href="javascript:void(0);">UTIL</a></li>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="league-right">
                        <ul class="lineup-info">
                            <li>
                                <dl>
                                    <dt>Salary Remaining</dt>
                                    <dd>$ <span class="total_salary">50,000</span></dd>
                                </dl>
                            </li>
                            <li>
                                <dl>
                                    <dt>Total FPPG</dt>
                                    <dd><span class="total_fppg">0</span></dd>
                                </dl>
                            </li>
                            <li>
                                <dl>
                                    <dt>Avg / Player</dt>
                                    <dd>$ <span class="avg_salary">0</span></dd>
                                </dl>
                            </li>
                        </ul>
                        <div class="select-player">
                            <ul>
                                <?php
                                foreach ($pos['pos'] as $key=>$value) {
                                    echo <<<LI
                                <li class="player-info lineup_{$value}">
                                    <div class="player-img player_img"><img src="http://dev.spo-bit.com/public/images/player_images/pubg/default.png" width="80" alt=""></div>
                                    <div class="player-skill">
                                        <div class="skill-top">
                                            <div class="name">
                                                <h2><span class="fc-blue team_name">Team</span><span class="player_name">Name</span></h2>
                                                <p class="player-money salary">$ 0</p>
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
                                    <div class="del"></div>
                                </li>
LI;
                                }
                                ?>
                            </ul>
                            <div class="btn-group">
                                <button type="button" class="btn-8 btn-grey">전부 삭제하기</button>
                                <button type="button" class="btn-8 btn-blue btn-confrim-draft" data-coin="5" data-category="20" data-game="24884">라인업 저장하기</button>
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