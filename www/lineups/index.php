<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;

    // 변수 정리
    $where      = '';

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
    <<div id="container">
        <!--content-->
        <div id="content">
            <!--sec-01-->
            <section class="sec sec-01 T0 B0">
                <div class="line-up-nav inner">
                    <ul>
                        <li class="active"><a href="javascript:void(0)">ALL</a></li>
                        <li class="active"><a href="javascript:void(0)">대기</a></li>
                        <li class="active"><a href="javascript:void(0)">LIVE</a></li>
                        <li class="active"><a href="javascript:void(0)">결과</a></li>
                    </ul>
                </div>
                <div class="inner">
                    <ul class="contest-list lineup-list">
                        <?php
                        $query  = "
                            SELECT a.* 
                            FROM lineups a 
                            LEFT JOIN game b
                                ON a.lu_g_idx = b.g_idx
                            WHERE 1=1
                              AND a.lu_u_idx = {$_se_idx}
                            ORDER BY a.lu_idx DESC
                        ";
                        //p($query);
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            //p($db);

                            echo <<<LI
                        <li class="edit">
                            <a href="javascript:void(0)" class="active">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb01.png')">
                                    <div class="subject"></div>
                                </div>
                                <div class="contest-desc lineUP">
                                    <div class="conts-desc-l">
                                        <div class="contest-ico">
                                            <img src="../images/item2.png" alt="임시">
                                        </div>
                                        <dl>
                                            <dt class="contest-schedule">내일 경기 예정</dt>
                                            <dt class="contest-title">COD:M 커뮤니티</dt>
                                            <dd class="contest-detail">
                                                <ul>
                                                    <li><img src="../images/ico_pin.svg" class="mR5" alt="위치">LAS</li>
                                                    <li>5v5</li>
                                                    <li>1,254 Slots</li>
                                                </ul>
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="current-price">
                                        <p>PRIZE</p>
                                        <span>1,000</span>
                                    </div>
                                </div>
                            </a>
                            <table class="entries-table">
                                <thead>
                                <tr>
                                    <th>참가자 수</th>
                                    <th>잔여 연봉</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>2</td>
                                    <td>$ 1,300</td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="line-up-table">
                                <thead>
                                <tr>
                                    <th>포지션</th>
                                    <th>이름</th>
                                    <th>구단</th>
                                    <th>연봉</th>
                                </tr>
                                </thead>
                                <tbody>
LI;
                            $sub_query  = "
                                SELECT * FROM lineups a
                                LEFT JOIN game b 
                                    ON b.g_idx = a.lu_g_idx
                                LEFT JOIN lineups_history c 
                                    ON c.lu_idx = a.lu_idx
                                WHERE 1=1
                                    AND c.lu_idx = {$db['lu_idx']}
                            ";
                            //p($sub_query);
                            $sub_result = $_mysqli->query($sub_query);
                            if (!$sub_result) {
                            }
                            while ($sub_db = $sub_result->fetch_assoc()) {
                                //p($sub_db);

                                echo <<<TR
                                <tr>
                                    <td>{$sub_db['player_pos']}</td>
                                    <td>{$sub_db['player_name']}</td>
                                    <td></td>
                                    <td>$ {$sub_db['player_salary']}</td>
                                </tr>                                
TR;
                            }
                        ?>
                                <tr>
                                    <td colspan="4" class="game-total">
                                        <div>
                                            <ul>
                                                <li><p>기대 상금</p><span>702</span></li>
                                                <li><p>총 상금</p><span class="fc-yellow">702</span></li>
                                                <li><p>수정 시간</p><span>2022-10-27 12:02:30</span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
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