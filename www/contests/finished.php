<?php
// config
require_once __DIR__ .'/../_inc/config.php';



try {

} catch (Exception $e) {
    p($e);
}
?>
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
                            <th>Contest</th>
                            <th><a href="javascript:void(0);">Completed</a></th>
                            <th><a href="javascript:void(0);">Multi</a></th>
                            <th><a href="javascript:void(0);">My Score</a></th>
                            <th><a href="javascript:void(0);">Entry Fee</a></th>
                            <th><a href="javascript:void(0);">Won</a></th>
                            <th>
                                <input type="search" placeholder="플레이어를 검색해주세요.">
                                <button class="search-btn"></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view open">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold open">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view last">
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>2022-03-26 12:36:59</td>
                            <td>1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td>
                                <p>RESULT</p>
                                <img src="../images/ico_arrow_blue.svg" alt="결과 보기">
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>PLAYER LANKING</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>RANK</th>
                                                    <th>ID</th>
                                                    <th>PRIZE</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1st</td>
                                                    <td>Deft</td>
                                                    <td>36</td>
                                                    <td>3,000</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd</td>
                                                    <td>Ruler</td>
                                                    <td>24</td>
                                                    <td>2,606</td>
                                                </tr>
                                                <tr>
                                                    <td>3rd</td>
                                                    <td>Score</td>
                                                    <td>12</td>
                                                    <td>2,500</td>
                                                </tr>
                                                <tr>
                                                    <td>4th</td>
                                                    <td>PraY</td>
                                                    <td>8</td>
                                                    <td>2,163</td>
                                                </tr>
                                                <tr>
                                                    <td>5th</td>
                                                    <td>Five</td>
                                                    <td>5</td>
                                                    <td>5,555</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>PLAYERS</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>POS</th>
                                                    <th>NAME</th>
                                                    <th>CONTEST</th>
                                                    <th>DETAILS</th>
                                                    <th>SCORE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>TL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>62</td>
                                                </tr>
                                                <tr>
                                                    <td>AL</td>
                                                    <td>Ruler</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>1,562</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Score</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>23</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>PraY</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>20,000</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                <tr>
                                                    <td>GL</td>
                                                    <td>Deft</td>
                                                    <td>2022 LoL 챔피언스 코리아 스프링</td>
                                                    <td>36p 9 made 3pt 6rebounds</td>
                                                    <td>12,454</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>status : normal (Depending on the number of the finalists, the prize mat differ.)</p>
                                        <p>* If you click other players user name, you can see and check other line-ups detail.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <a class="active" href="javascript:void(0)">1</a>
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
