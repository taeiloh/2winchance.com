<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 파라미터
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;

    // 변수 정리
    $where      = '';

    $where      .= "
        AND g_status IN (3, 4)
    ";

    /*
    $where      .= "
        AND join_contest.result_report='finished'
    ";
*/

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
                        $query  = "
                            SELECT
                                jc.jc_idx, jc.jc_game, jc.jc_lineups, MAX(jc.jc_point) AS point,
                                g.g_idx, g.g_name, g.g_fee,
                                COUNT(jc.jc_game) AS multi_join
                            FROM join_contest jc
                            INNER JOIN game g
                                ON jc.jc_game = g.g_idx
                            WHERE 1=1
                                AND jc.jc_u_idx = {$_se_idx}
                            GROUP BY jc.jc_game
                            ORDER BY jc.jc_game DESC
                        ";
                        //p($query);
                        $result     = $_mysqli->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                        ?>
                        <tr class="view">
                            <td><?=$db['g_name'];?></td>
                            <td></td>
                            <td><?=$db['multi_join'];?></td>
                            <td><?=$db['point'];?></td>
                            <td><?=$db['g_fee'];?></td>
                            <td></td>
                            <td>
                                <p>결과보기 <img src="/images/ico_arrow_blue.svg" alt="결과 보기"/></p>
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>입상 순위</h3>
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
                                                    echo <<<TR
                                                <tr>
                                                    <td>{$sub_db['jc_rank']}</td>
                                                    <td class="ellipsis_multiple2">{$sub_db['m_name']}</td>
                                                    <td>{$sub_db['jc_point']}</td>
                                                    <td>{$sub_db['jc_prize']}</td>
                                                </tr>
TR;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>선수 상세 결과 <span class="sub-ex">(획득 점수는 “전투력”으로 변환/저장됩니다. 마이페이지에서 누적되는 “전투력”을 확인하세요.)</span></h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>포지션</th>
                                                    <th>이름</th>
                                                    <th>콘테스트</th>
                                                    <th>상세 내용</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>
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
                                                while ($sub_db = $sub_result->fetch_assoc()) {
                                                    $result_json    = $sub_db['player_result_json'];
                                                    $arrResult      = json_decode($result_json, true);
                                                    //p($arrResult);

                                                    echo <<<TR
                                                <tr>
                                                    <td>{$sub_db['player_pos']}</td>
                                                    <td>{$sub_db['player_name']}</td>
                                                    <td></td>
                                                    <td class="hover">
                                                        <p>팀순위({$arrResult['SUM_TEAM_SCORE']}) 킬수({$arrResult['SUM_KILLED']}) 팀킬({$arrResult['SUM_TEAMKILLED']}) 자살({$arrResult['SUM_SELFKILLED']}) 부활({$arrResult['SUM_REVIVED']})</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>팀순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= {$arrResult['SUM_TEAM_SCORE']}</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= {$arrResult['SUM_KILLED']}</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= {$arrResult['SUM_TEAMKILLED']}</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>자살</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= {$arrResult['SUM_SELFKILLED']}</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>부활</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= {$arrResult['SUM_REVIVED']}</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>획득 점수</dt>
                                                                <dd>= {$sub_db['game_players_points']}</dd>
                                                            </dl>
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
                        ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
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
