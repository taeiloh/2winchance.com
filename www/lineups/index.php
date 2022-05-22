<?php
// config
require_once __DIR__ .'/../_inc/config.php';



try {

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
            <section class="sec sec-01 T0 B0">
                <div class="line-up-nav inner">
                    <ul>
                        <li class="active"><a href="javascript:void(0)">ALL</a></li>
                        <li class="active"><a href="javascript:void(0)">UP COMMING</a></li>
                        <li class="active"><a href="javascript:void(0)">LIVE</a></li>
                        <li class="active"><a href="javascript:void(0)">FINISHED</a></li>
                    </ul>
                </div>
                <div class="inner">
                    <ul class="contest-list lineup-list">
                        <?php
                        $query  = "
                            SELECT a.* FROM lineups a LEFT JOIN game b
                            ON a.lu_g_idx = b.g_idx
                            WHERE 1=1
                              AND a.lu_u_idx = 10031
                            ORDER BY a.lu_idx DESC
                        ";
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }
                        while ($db = $result->fetch_assoc()) {
                            p($db);

                            echo <<<LI
                        <li class="edit">
                            <a href="javascript:void(0)" class="active">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb01.png')">
                                    <div class="subject"></div>
                                </div>
                                <div class="contest-desc lineUP">
                                    <div class="conts-desc-l">
                                        <div class="contest-ico">
                                            <img src="" alt="임시">
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
                                <span class="line-up-badge">UPCOMMING</span>
                            </a>
                            <table class="entries-table">
                                <thead>
                                <tr>
                                    <th># of Entries</th>
                                    <th>Remain Salary</th>
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
                                    <th>POS</th>
                                    <th>NAME</th>
                                    <th>TEAM</th>
                                    <th>SALARY</th>
                                </tr>
                                </thead>
                                <tbody>
LI;
                            ?>

                            <tr>
                                <td>TL</td>
                                <td>Deft</td>
                                <td>DRX</td>
                                <td>$ 3,000</td>
                            </tr>
                            <tr>
                                <td>TL</td>
                                <td>Deft</td>
                                <td>DRX</td>
                                <td>$ 3,000</td>
                            </tr>
                            <tr>
                                <td>TL</td>
                                <td>Deft</td>
                                <td>DRX</td>
                                <td>$ 3,000</td>
                            </tr>
                            <tr>
                                <td>TL</td>
                                <td>Deft</td>
                                <td>DRX</td>
                                <td>$ 3,000</td>
                            </tr>
                            <tr>
                                <td>TL</td>
                                <td>Deft</td>
                                <td>DRX</td>
                                <td>$ 3,000</td>
                            </tr>
                            <tr>
                                <td>TL</td>
                                <td>Deft</td>
                                <td>DRX</td>
                                <td>$ 3,000</td>
                            </tr>
                            <tr>
                                <td>TL</td>
                                <td>Deft</td>
                                <td>DRX</td>
                                <td>$ 3,000</td>
                            </tr>
                            <tr>
                                <td>TL</td>
                                <td>Deft</td>
                                <td>DRX</td>
                                <td>$ 3,000</td>
                            </tr>
                            <?php
                            echo <<<LI
                                <tr>
                                    <td colspan="4" class="game-total">
                                        <div>
                                            <ul>
                                                <li><p>Possible Winning Account</p><span>702</span></li>
                                                <li><p>Total Prize</p><span class="fc-yellow">702</span></li>
                                                <li><p>Last Edit</p><span>2022-10-27 12:02:30</span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </li>
LI;

                        }
                        ?>
                    </ul>
                    <ul class="contest-list lineup-list">
                        <li class="live">
                            <a href="javascript:void(0)" class="active">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb03.png')">
                                    <div class="subject"></div>
                                </div>
                                <div class="contest-desc lineUP">
                                    <div class="conts-desc-l">
                                        <div class="contest-ico">
                                            <img src="" alt="임시">
                                        </div>
                                        <dl>
                                            <dt class="contest-schedule">2022년 3월 25일 금요일</dt>
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
                                <span class="line-up-badge">LIVE</span>
                            </a>
                            <table class="entries-table">
                                <thead>
                                <tr>
                                    <th># of Entries</th>
                                    <th>Remain Salary</th>
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
                                    <th>POS</th>
                                    <th>NAME</th>
                                    <th>TEAM</th>
                                    <th>SALARY</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="game-total">
                                        <div>
                                            <ul>
                                                <li><p>Possible Winning Account</p><span>702</span></li>
                                                <li><p>Total Prize</p><span class="fc-yellow">702</span></li>
                                                <li><p>Last Edit</p><span>2022-10-27 12:02:30</span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </li>
                        <li class="edit">
                            <a href="javascript:void(0)" class="active">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb01.png')">
                                    <div class="subject"></div>
                                </div>
                                <div class="contest-desc lineUP">
                                    <div class="conts-desc-l">
                                        <div class="contest-ico">
                                            <img src="" alt="임시">
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
                                <span class="line-up-badge">EDDIT</span>
                            </a>
                            <table class="entries-table">
                                <thead>
                                <tr>
                                    <th># of Entries</th>
                                    <th>Remain Salary</th>
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
                                    <th>POS</th>
                                    <th>NAME</th>
                                    <th>TEAM</th>
                                    <th>SALARY</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="game-total">
                                        <div>
                                            <ul>
                                                <li><p>Possible Winning Account</p><span>702</span></li>
                                                <li><p>Total Prize</p><span class="fc-yellow">702</span></li>
                                                <li><p>Last Edit</p><span>2022-10-27 12:02:30</span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </li>
                        <li class="finished">
                            <a href="javascript:void(0)" class="active">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb03.png')">
                                    <div class="subject"></div>
                                </div>
                                <div class="contest-desc lineUP">
                                    <div class="conts-desc-l">
                                        <div class="contest-ico">
                                            <img src="" alt="임시">
                                        </div>
                                        <dl>
                                            <dt class="contest-schedule">2022년 3월 25일 금요일</dt>
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
                                <span class="line-up-badge">Finished</span>
                            </a>
                            <table class="entries-table">
                                <thead>
                                <tr>
                                    <th># of Entries</th>
                                    <th>Remain Salary</th>
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
                                    <th>POS</th>
                                    <th>NAME</th>
                                    <th>TEAM</th>
                                    <th>SALARY</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="game-total">
                                        <div>
                                            <ul>
                                                <li><p>Possible Winning Account</p><span>702</span></li>
                                                <li><p>Total Prize</p><span class="fc-yellow">702</span></li>
                                                <li><p>Last Edit</p><span>2022-10-27 12:02:30</span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </li>
                    </ul>
                    <ul class="contest-list lineup-list">
                        <li class="finished">
                            <a href="javascript:void(0)" class="active">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb03.png')">
                                    <div class="subject"></div>
                                </div>
                                <div class="contest-desc lineUP">
                                    <div class="conts-desc-l">
                                        <div class="contest-ico">
                                            <img src="" alt="임시">
                                        </div>
                                        <dl>
                                            <dt class="contest-schedule">2022년 3월 25일 금요일</dt>
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
                                <span class="line-up-badge">Finished</span>
                            </a>
                            <table class="entries-table">
                                <thead>
                                <tr>
                                    <th># of Entries</th>
                                    <th>Remain Salary</th>
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
                                    <th>POS</th>
                                    <th>NAME</th>
                                    <th>TEAM</th>
                                    <th>SALARY</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td>TL</td>
                                    <td>Deft</td>
                                    <td>DRX</td>
                                    <td>$ 3,000</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="game-total">
                                        <div>
                                            <ul>
                                                <li><p>Possible Winning Account</p><span>702</span></li>
                                                <li><p>Total Prize</p><span class="fc-yellow">702</span></li>
                                                <li><p>Last Edit</p><span>2022-10-27 12:02:30</span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </li>
                    </ul>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <a href="javascript:void(0)">1</a>
                <a class="active" href="javascript:void(0)">2</a>
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