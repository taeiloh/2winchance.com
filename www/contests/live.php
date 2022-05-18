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
            <section class="sec sec-01 T0">
                <div class="contents-nav inner">
                    <?php
                    // nav
                    require_once __DIR__ .'/../common/nav_contests.php';
                    ?>
                </div>

                <div class="contents-cont inner">
                    <table class="contents-table live-table">
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
                        <tr>
                            <th>Contest</th>
                            <th>Entries</th>
                            <th>My Rank</th>
                            <th>My Score</th>
                            <th>Top Score</th>
                            <th>Entry Fee</th>
                            <th>
                                <input type="search" placeholder="플레이어를 검색해주세요.">
                                <button class="search-btn"></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td>8</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td class="rank">1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td>4</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td class="rank">2</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td class="rank">3</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td>8</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td class="rank">1</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td>4</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td>4</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td>6</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td>5</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        <tr>
                            <td>2022 LoL 챔피언스 코리아 스프링</td>
                            <td>
                                <div>
                                    <p>600</p>/<span>1,000</span>
                                </div>
                            </td>
                            <td>30</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                            <td><button type="button"><span class="circle"></span>Live</button></td>
                        </tr>
                        </tbody>
                    </table>
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