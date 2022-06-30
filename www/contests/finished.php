<?php
// config
require_once __DIR__ .'/../_inc/config.php';
require_once __DIR__ .'/../_inc/paging.php';

try {
    // 파라미터
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;
    $index        = !empty($_GET['index'])      ? $_GET['index']      : 0;
    $lu_idx        = !empty($_GET['lu_idx'])      ? $_GET['lu_idx']      : 0;
    $_se_nm             = !empty($_SESSION['_se_name'])             ? $_SESSION['_se_name']           : '';
    // 변수 정리

    //변수 정리
    $size           = PAGING_SIZE;
    $offset         = ($page - 1) * $size;
    $scale          = PAGING_SCALE;
    $where      = '';

    $where      .= "
        AND g_status IN (3, 4)
    ";

    /*
    $where      .= "
        AND join_contest.result_report='finished'
    ";
*/
    $query1  = "
                            SELECT
                                count(DISTINCT jc_game) as total
                            FROM join_contest jc
                            INNER JOIN game g
                                ON jc.jc_game = g.g_idx
                            WHERE 1=1
                                AND jc.jc_u_idx = {$_se_idx}
                            ORDER BY jc.jc_game DESC
                        ";
    //p($query1);
    $sub_result     = $_mysqli->query($query1);
    $sub_dbarray    = $sub_result->fetch_array();
    $total          = $sub_dbarray['total'];

    $sub_result->free();

    //페이징
    $_pg    = new PAGING($total, $page, $size, $scale);


} catch (Exception $e) {
    p($e);
}
?>
<!doctype html>
<html lang="ko">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
    <script>
        var testnum = 0;
        function get_player_score(jc_idx, lu_idx, g_idx, i,num) {
            console.log(testnum);
            console.log("===> get_player_score");
            console.log(i);
            $("#playerSelect_"+testnum).removeClass('user');
            testnum = num;
            $("#playerSelect_"+num).addClass('user');

            /*if (se_name == name) {
                $("#playertest"+i).hide();
                console.log("1");

            } else {*/
                console.log("2"+g_idx+lu_idx);
                var postData = {
                    "jc_idx" : jc_idx,
                    "g_idx" : g_idx,
                    "lu_idx" : lu_idx
                };
                $.ajax({
                    url: "another_player_score.php",
                    type: "POST",
                    async: false,
                    data: postData,
                    success: function (data) {
                        //console.log(data);
                        //var json = JSON.parse(data);
                        $("#playertest_"+i).html(data);
                    },
                    beforeSend: function () {
                        $(".wrap-loading").removeClass("display-none");
                    },
                    complete: function () {
                        $(".wrap-loading").addClass("display-none");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            /*}*/

        }
    </script>
</head>

<!--//head-->
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
            <section class="sec sec-01 T0">
                <div class="contents-nav inner">
                    <?php
                    // nav
                    require_once __DIR__ .'/../common/nav_contests.php';
                    ?>
                </div>

                <div class="contents-cont inner">
                    <table class="contents-table fold-table">
                        <colgroup>
                            <col style="width:25.142%">
                            <col style="width:16.572%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:25.142%">
                        </colgroup>
                        <thead>
                        <tr class="filter">
                            <th>콘테스트</th>
                            <th><a href="javascript:void(0);">경기 종료 시간</a></th>
                            <th><a href="javascript:void(0);">중복</a></th>
                            <th><a href="javascript:void(0);">내 점수</a></th>
                            <th><a href="javascript:void(0);">사용 FP</a></th>
                            <th><a href="javascript:void(0);">상금</a></th>
                            <th>
                                <input type="search" placeholder="플레이어를 검색해주세요.">
                                <button class="search-btn"></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($total > 0)
                        {
                            $on = "";
                            $query  = "
                            SELECT
                                jc.jc_idx, jc.jc_game, jc.jc_lineups, MAX(jc.jc_point) AS point,
                                g.g_idx, g.g_name, g.g_fee,jc.jc_prize,g.g_round_seq,
                                COUNT(jc.jc_game) AS multi_join
                            FROM join_contest jc
                            INNER JOIN game g
                                ON jc.jc_game = g.g_idx
                            WHERE 1=1
                                AND jc.jc_u_idx = {$_se_idx}
                            GROUP BY jc.jc_game
                            ORDER BY jc.jc_game DESC
                            LIMIT {$offset}, {$size}
                        ";
                            //p($query);
                            $result     = $_mysqli->query($query);


                            if (!$result) {

                            }
                            $i = 0;
                            $selectnum = 0;
                            while ($db = $result->fetch_assoc()) {
                                $i++;
                                $balancequery = "SELECT MAX(balance) as balance
                                    FROM honor_point_history
                                    where m_idx = {$_se_idx};
                                    ";
                                $resultbalance = $_mysqli->query($balancequery);
                                $dbb = $resultbalance->fetch_assoc();
                                $balance = $dbb['balance'];
                                $g_idx = $db['g_idx'];
                                $gamename = $db['g_name'];
                                $point = $db['point'];
                                $balance += $point;
                                $gamename2 = "콘테스트참가 (G{$g_idx})";
                                $jc_game = $db['jc_game'];
                                $round_seq = $db['g_round_seq'];
                                $lu_idx = $db['jc_lineups'];


                                $query2 = "SELECT END_DT FROM ROUNDS WHERE SEQ = $round_seq";
                                $resultdate = $_mysqli->query($query2);
                                $round_data = $resultdate ->fetch_assoc();
                                $end_dt = !empty($round_data['END_DT']) ? ($round_data['END_DT']) : '';

                                //lineup에서 결과값이 넘어온 경우
                                if($db['jc_game'] == $index)
                                {
                                    $on = "open";
                                }
                                else{
                                    $on = "";
                                }


                                ?>
                                <tr class="view">
                                    <td><?=$db['g_name'];?> <span class="contest_num">G(<?=$db['g_idx'];?>)</span></td>
                                    <td><?=$end_dt?></td>
                                    <td><?=$db['multi_join'];?></td>
                                    <td><?=$db['point'];?></td>
                                    <td><?=$db['g_fee'];?></td>
                                    <td><?=$db['jc_prize'];?></td>
                                    <td>
                                        <p>결과보기 <img src="/images/ico_arrow_blue.svg" alt="결과 보기"/></p>
                                    </td>
                                </tr>
                                <tr class="fold <?=$on?>">
                                    <td colspan="7">
                                        <div class="fold-content">
                                            <div class="fold-table-wrap">
                                                <div class="lanking-table">
                                                    <h3>입상 순위</h3>
                                                    <div class="tb-wrap">
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th>순위</th>
                                                                <th>ID</th>
                                                                <th>점수</th>
                                                                <th>상금</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $sub_query  = "
                                                                SELECT
                                                                    jc.jc_idx, jc.jc_game, jc.jc_rank, jc.jc_point, jc.jc_prize,
                                                                    m.m_name
                                                                FROM join_contest jc
                                                                INNER JOIN members m
                                                                    ON jc.jc_u_idx = m.m_idx
                                                                WHERE 1=1
                                                                    AND jc.jc_game = {$db['g_idx']}
                                                                ORDER BY jc.jc_rank ASC
                                                            ";
                                                            //p($sub_query);
                                                            $sub_result     = $_mysqli->query($sub_query);


                                                            if (!$sub_result) {
                                                            }
                                                            while ($sub_db = $sub_result->fetch_assoc()) {
                                                                $selectnum++;
                                                                $m_name = empty(!$sub_db['m_name']) ? ($sub_db['m_name']) : '';
                                                                $jc_idx = empty(!$sub_db['jc_idx']) ? ($sub_db['jc_idx']) : '';


                                                                $nameOnclick    = "<button type=\"button\" onclick=\"get_player_score('{$jc_idx}','{$lu_idx}','{$g_idx}', '{$g_idx}','{$selectnum}');\">{$m_name}</button>";

                                                                echo <<<TR

                                                                    <tr id = "playerSelect_$selectnum" >
                                                                        <td>{$sub_db['jc_rank']}</td>
                                                                        <td class="ellipsis_multiple2">{$nameOnclick}</td>
                                                                        <td>{$sub_db['jc_point']}</td>
                                                                        <td>{$sub_db['jc_prize']}</td>
                                                                    </tr>
TR;
                                                            }

                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="player-table">
                                                    <h3>선수 상세 결과 <span class="sub-ex">(획득 점수는 “전투력”으로 변환/저장됩니다. 마이페이지에서 누적되는 “전투력”을 확인하세요.)</span></h3>
                                                    <table id="change-player-table" class="player-detail-table" style="display:block">
                                                        <colgroup>
                                                            <col style="width:7.5%;">
                                                            <col style="width:20%;">
                                                            <col style="width:15%;">
                                                            <col style="width:35%;">
                                                            <col style="width:7.5%;">
                                                        </colgroup>
                                                        <thead>
                                                        <tr>
                                                            <th>포지션</th>
                                                            <th>이름</th>
                                                            <th>콘테스트</th>
                                                            <th>상세 내용</th>
                                                            <th>점수</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="playertest_<?=$g_idx?>">
                                                        <?php
                                                        $sub_query  = "
                                                    SELECT
                                                        player_pos, player_name, player_result_json, game_players_points
                                                    FROM lineups_history
                                                    WHERE 1=1
                                                        AND m_idx = {$_se_idx}
                                                        AND g_idx = {$db['jc_game']}
                                                        AND lu_idx = {$db['jc_lineups']}
                                                ";
                                                        //p($sub_query);
                                                        $sub_result     = $_mysqli->query($sub_query);
                                                        if (!$sub_result) {
                                                        }
                                                        $sum_team_score     = 0;
                                                        $sum_killed     = 0;
                                                        $sum_teamkilled     = 0;
                                                        $sum_selfkilled     = 0;
                                                        $sum_revived     = 0;

                                                        $pos = !empty($sub_db['player_pos']) ? ($sub_db['player_pos']) : "";

                                                        $j = 0;
                                                        while ($sub_db = $sub_result->fetch_assoc()) {
                                                            //p($sub_db);
                                                            $result_json    = $sub_db['player_result_json'];
                                                            $arrResult      = json_decode($result_json, true);
                                                            //p($arrResult);
                                                            for($i=0; $i<5; $i++)
                                                            {
                                                                $arrResult[$i]['TEAM_SCORE'] = 0;
                                                                $arrResult[$i]['KILLED'] = 0;
                                                                $arrResult[$i]['TEAMKILLED'] = 0;
                                                                $arrResult[$i]['SELFKILLED'] = 0;
                                                                $arrResult[$i]['REVIVED'] = 0;
                                                            }
                                                            $j++;
                                                            //p($sub_db);
                                                            if(($sub_db['player_pos']=='OD' or $sub_db['player_pos']=='TL') and $j<5) {
                                                                $pos = '오더';
                                                            } else if(($sub_db['player_pos']=='ST' or $sub_db['player_pos']=='R') and $j<5 ) {
                                                                $pos = '정찰';
                                                            } else if(($sub_db['player_pos']=='TW' or $sub_db['player_pos']=='GR') and $j<5 ) {
                                                                $pos = '포탑';
                                                            } else if(($sub_db['player_pos']=='RR' or $sub_db['player_pos']=='AR') and $j<5 ) {
                                                                $pos = '돌격';
                                                            } else {
                                                                $pos = '유틸';
                                                            }
                                                            $sum_team_score = $arrResult[0]['TEAM_SCORE'] + $arrResult[1]['TEAM_SCORE'] + $arrResult[2]['TEAM_SCORE'] + $arrResult[3]['TEAM_SCORE'] + $arrResult[4]['TEAM_SCORE'];
                                                            $sum_killed     = $arrResult[0]['KILLED'] + $arrResult[1]['KILLED'] + $arrResult[2]['KILLED'] + $arrResult[3]['KILLED'] + $arrResult[4]['KILLED'];
                                                            $sum_teamkilled = $arrResult[0]['TEAMKILLED'] + $arrResult[1]['TEAMKILLED'] + $arrResult[2]['TEAMKILLED'] + $arrResult[3]['TEAMKILLED'] + $arrResult[4]['TEAMKILLED'];
                                                            $sum_selfkilled = $arrResult[0]['SELFKILLED'] + $arrResult[1]['SELFKILLED'] + $arrResult[2]['SELFKILLED'] + $arrResult[3]['SELFKILLED'] + $arrResult[4]['SELFKILLED'];
                                                            $sum_revived    = $arrResult[0]['REVIVED'] + $arrResult[1]['REVIVED'] + $arrResult[2]['REVIVED'] + $arrResult[3]['REVIVED'] + $arrResult[4]['REVIVED'];

                                                            echo <<<TR
                                                <tr>
                                                    <td>{$pos}</td>
                                                    <td>{$sub_db['player_name']}</td>
                                                    <td>G({$db['g_idx']})</td>
                                                    <td class="hover">
                                                        <p>팀순위({$sum_team_score}) 킬수({$sum_killed}) 팀킬({$sum_teamkilled}) 자살({$sum_selfkilled}) 부활({$sum_revived})</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <table>
                                                                     <tr>
                                                                        <th>팀 순위</th>
                                                                        <td>{$arrResult[0]['TEAM_SCORE']}</td>
                                                                        <td>{$arrResult[1]['TEAM_SCORE']}</td>
                                                                        <td>{$arrResult[2]['TEAM_SCORE']}</td>
                                                                        <td>{$arrResult[3]['TEAM_SCORE']}</td>
                                                                        <td>{$arrResult[4]['TEAM_SCORE']}</td>
                                                                        <td>= {$sum_team_score}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th>킬수</th>
                                                                        <td>{$arrResult[0]['KILLED']}</td>
                                                                        <td>{$arrResult[1]['KILLED']}</td>
                                                                        <td>{$arrResult[2]['KILLED']}</td>
                                                                        <td>{$arrResult[3]['KILLED']}</td>
                                                                        <td>{$arrResult[4]['KILLED']}</td>
                                                                        <td>= {$sum_killed}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th>팀킬</th>
                                                                        <td>{$arrResult[0]['TEAMKILLED']}</td>
                                                                        <td>{$arrResult[1]['TEAMKILLED']}</td>
                                                                        <td>{$arrResult[2]['TEAMKILLED']}</td>
                                                                        <td>{$arrResult[3]['TEAMKILLED']}</td>
                                                                        <td>{$arrResult[4]['TEAMKILLED']}</td>
                                                                        <td>= {$sum_selfkilled}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th>자살</th>
                                                                        <td>{$arrResult[0]['SELFKILLED']}</td>
                                                                        <td>{$arrResult[1]['SELFKILLED']}</td>
                                                                        <td>{$arrResult[2]['SELFKILLED']}</td>
                                                                        <td>{$arrResult[3]['SELFKILLED']}</td>
                                                                        <td>{$arrResult[4]['SELFKILLED']}</td>
                                                                        <td>= {$sum_selfkilled}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th>부활</th>
                                                                        <td>{$arrResult[0]['REVIVED']}</td>
                                                                        <td>{$arrResult[1]['REVIVED']}</td>
                                                                        <td>{$arrResult[2]['REVIVED']}</td>
                                                                        <td>{$arrResult[3]['REVIVED']}</td>
                                                                        <td>{$arrResult[4]['REVIVED']}</td>
                                                                        <td>= {$sum_revived}</td>
                                                                     </tr>
                                                                     <tr>
                                                                        <th colspan="6">총점 (전투력)</th>
                                                                        <td>= {$sub_db['game_players_points']}</td>
                                                                     </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                <td>{$sub_db['game_players_points']}</td>
                                                </tr>
TR;
                                                        }
                                                        ?>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="status-txt">
                                                <p>최종 참여자 수에 따라 최종 상금이 변경될 수 있습니다.</p>
                                                <p>* 다른 참여자 닉네임을 클릭하면 선수 상세 내역을 확인 하실 수 있습니다.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php

                            } // while
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?=$_pg->getPaging();?>
                <?php
                //echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                ?>
                <!--a href="javascript:void(0)" class="active" >1</a>
                <a href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">3</a>
                <a href="javascript:void(0)">4</a-->
            </div>
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
