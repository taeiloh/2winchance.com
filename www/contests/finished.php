<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 파라미터

    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;

    // 변수 정리
    $where      = '';

    $where      .= "
        AND g_status IN (3, 4)
    ";

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
                        <tr class="view">
                            <td>{$db['g_name']}</td>
                            <td>{$db['jc_result_update']}</td>
                            <td>{$db['g_multi_max']}</td>
                            <td>{$db['jc_point']}</td>
                            <td>{$db['g_fee']}</td>
                            <td>{$db['g_prize']}</td>
                            <td>
                                <p>결과보기 <img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
                            </td>
                        </tr>
                        <tr class="fold open">
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
                                                    <th>상금</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr>
                                                    <td>1st</td>
                                                    <td>{$sub_db['m_name']}</td>
                                                    <td>{$sub_db['jc_prize']}</td>
                                                    <td>{$sub_db['jc_point']}</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>선수 상세 결과</h3>
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
                                                <tr>
                                                    <td>{$sub_db['player_pos']}</td>
                                                    <td>{$sub_db['player_name']}</td>
                                                    <td>{$game_info}</td>
                                                    <td class="hover">
                                                        {$sub_db['player_result_json']}
                                                        <p>36p 9 made 3pt 6rebounds</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>{$sub_db['game_players_points']}</td>
                                                </tr>

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
                        // 콘테스트
                        $query  = "
                            SELECT 
                                join_contest.*, 
                                game.*,  
                                game_category.gc_name 
                            FROM 
                            (
                                SELECT
                                    jc_idx
                                FROM join_contest
                                WHERE 1=1
                                    AND jc_u_idx = {$_se_idx}
                            ) b INNER JOIN join_contest 
                                ON join_contest.jc_idx = b.jc_idx
                            LEFT JOIN lineups 
                                ON lu_idx = jc_lineups 
                            LEFT JOIN game 
                                ON g_idx = jc_game 
                            LEFT JOIN game_category 
                                ON gc_idx = g_sport 
                            LEFT JOIN members 
                                ON m_idx = lu_u_idx 
                            WHERE 1=1 
                                AND lu_u_idx = {$_se_idx} 
                                {$where} 
                            GROUP BY jc_game 
                            ORDER BY g_date DESC, jc_result DESC
                        ";
                        //p($query);
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            //p($db);

                            echo <<<TR
                        <tr class="view">
                            <td>{$db['g_name']}</td>
                            <td>{$db['jc_result_update']}</td>
                            <td>{$db['g_multi_max']}</td>
                            <td>{$db['jc_point']}</td>
                            <td>{$db['g_fee']}</td>
                            <td>{$db['g_prize']}</td>
                            <td>
                                <p>결과보기</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold open">
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
                                                    <th>상금</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>
TR;
                            $sub_query  = "
                                SELECT 
                                    jc_u_idx, jc_rank, jc_prize, jc_point,
                                    (SELECT m_name FROM members WHERE 1=1 AND m_idx=a.jc_u_idx ) AS m_name
                                FROM join_contest a
                                WHERE 1=1
                                    AND jc_game = {$db['jc_game']}
                                ORDER BY jc_rank
                            ";
                            $sub_result = $_mysqli->query($sub_query);
                            if (!$sub_result) {
                            }
                            while ($sub_db = $sub_result->fetch_assoc()) {
                                //p($sub_db);

                                echo <<<TR
                                                <tr>
                                                    <td>1st</td>
                                                    <td>{$sub_db['m_name']}</td>
                                                    <td>{$sub_db['jc_prize']}</td>
                                                    <td>{$sub_db['jc_point']}</td>
                                                </tr>
TR;

                            }

                            echo <<<TR
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>선수 상세 결과</h3>
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
TR;
                            $sub_query  = "
                                SELECT * 
                                FROM lineups a
                                LEFT JOIN game b 
                                    ON b.g_idx = a.lu_g_idx
                                LEFT JOIN lineups_history c 
                                    ON c.lu_idx = a.lu_idx
                                WHERE 1=1
                                    AND c.lu_idx = 17489
                            ";
                            $sub_result = $_mysqli->query($sub_query);
                            if (!$result) {
                            }
                            while ($sub_db = $sub_result->fetch_assoc()) {
                                //p($sub_db);

                                // 경기 정보
                                $_query = "
                                    SELECT * 
                                    FROM lineups_history a
                                    LEFT JOIN lineups_history_score b
                                        ON b.game_id = a.game_id
                                    WHERE 1=1
                                        AND a.m_idx = {$_se_idx}
                                        AND a.g_idx = {$sub_db['g_idx']}
                                        AND a.game_id = '{$sub_db['game_id']}'
                                        AND a.player_id = '{$sub_db['player_id']}'
                                ";
                                $_result    = $_mysqli->query($_query);
                                if (!$_result) {

                                }
                                $_db    = $_result->fetch_assoc();
                                //p($_db);
                                $game_info  = "{$_db['home_name']} {$_db['home_score']}:{$_db['away_score']} {$_db['away_name']}";

                                $player_result_json = json_decode($sub_db['player_result_json'], true);
                                echo <<<TR
                                                <tr>
                                                    <td>{$sub_db['player_pos']}</td>
                                                    <td>{$sub_db['player_name']}</td>
                                                    <td>{$game_info}</td>
                                                    <td class="hover">
                                                        {$sub_db['player_result_json']}
                                                        <p>36p 9 made 3pt 6rebounds</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>{$sub_db['game_players_points']}</td>
                                                </tr>
TR;
                            }
                            ?>
                            <?php
                            echo <<<TR

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
TR;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <a href="javascript:void(0)" class="active" >1</a>
                <a href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">3</a>
                <a href="javascript:void(0)">4</a>
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