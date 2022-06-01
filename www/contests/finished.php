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
                        // 콘테스트
                        $query  = "
                            SELECT
                                *
                            FROM join_contest jc 
                            INNER JOIN game g 
                                ON jc.jc_game = g.g_idx
                            WHERE 1=1
                                AND jc.jc_u_idx = {$_se_idx}
                        ";
                        //p($query);
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            //p($db);

                            echo <<<TR
                        <tr class="view open">
                            <td>{$db['g_name']}</td>
                            <td>{$db['jc_result_update']}</td>
                            <td>{$db['g_multi_max']}</td>
                            <td>{$db['jc_point']}</td>
                            <td>{$db['g_fee']}</td>
                            <td>{$db['g_prize']}</td>
                            <td>
                                <p>결과보기<img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
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
                            $c=0;
                            while ($sub_db = $sub_result->fetch_assoc()) {
                                //p($sub_db);
                                $c++;
                                echo <<<TR
                                                <tr>
                                                    <td>{$c}</td>
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
                            $_query = "
                                SELECT
                                    lh.*,
                                    SUM(pr.TEAM_SCORE) AS SUM_TEAM_SCORE,
                                    SUM(pr.KILLED) AS SUM_KILLED,
                                    SUM(pr.TEAMKILLED) AS SUM_TEAMKILLED,
                                    SUM(pr.SELFKILLED) AS SUM_SELFKILLED,
                                    SUM(pr.REVIVED) AS SUM_REVIVED
                                FROM lineups_history lh
                                INNER JOIN PLAYER_RESULT pr
                                ON lh.game_id = pr.ROUNDS_SEQ   
                                    AND lh.player_id = pr.PLAYER_SEQ
                                WHERE 1=1
                                    AND lh.m_idx = {$_se_idx}
                                    AND lh.g_idx = {$db['g_idx']}
                                GROUP BY lh.player_id
                            ";
                            //p($_query);
                            $_result    = $_mysqli->query($_query);
                            if (!$_result) {

                            }
                            while ($sub_db1 = $_result->fetch_assoc()) {
                                $info   = "팀점수:{$sub_db1['SUM_TEAM_SCORE']} / 킬수:{$sub_db1['SUM_KILLED']} / 팀킬:{$sub_db1['SUM_TEAMKILLED']} / 자살:{$sub_db1['SUM_SELFKILLED']} / 부활:{$sub_db1['SUM_REVIVED']}";
                                $sum    = $sub_db1['SUM_TEAM_SCORE'] + $sub_db1['SUM_KILLED'] + $sub_db1['SUM_TEAMKILLED'] + $sub_db1['SUM_SELFKILLED'] + $sub_db1['SUM_REVIVED'];
                                echo <<<TR
                                                <tr>
                                                    <td>{$sub_db1['player_pos']}</td>
                                                    <td>{$sub_db1['player_name']}</td>
                                                    <td></td>
                                                    <td class="hover">
                                                        <p>{$info}</p>
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
                                                    <td>{$sum}</td>
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
