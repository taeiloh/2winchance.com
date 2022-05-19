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
            <section class="sec sec-01 T0 myAcct">
                <?php
                //header
                require_once __DIR__ . '/../common/category.php';
                ?>
<!--                <div class="category inner">-->
<!--                    <ul>-->
<!--                        <li><a href="javascript:void(0)">마이페이지</a></li>-->
<!--                        <li><a href="javascript:void(0)">문의내역</a></li>-->
<!--                        <li><a href="javascript:void(0)">캐시 내역</a></li>-->
<!--                        <li><a href="javascript:void(0)">FP 내역</a></li>-->
<!--                        <li class="active"><a href="javascript:void(0)">HP 내역</a></li>-->
<!--                        <li><a href="javascript:void(0)">HOW TO PLAY</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="contents-cont inner">
                    <table class="contents-table cash-table fp-page">
                        <colgroup>
                            <col style="width:25%">
                            <col style="width:25%">
                            <col style="width:25%">
                            <col style="width:25%">
                        </colgroup>
                        <thead>
                        <tr class="filter">
                            <th><a href="javascript:void(0);">일자</a></th>
                            <th>내용</th>
                            <th><a href="javascript:void(0);">HP</a></th>
                            <th><a href="javascript:void(0);">HP 잔액</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
                        </tr>
                        <tr>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>Join the contest (G55362)</td>
                            <td>+ 25</td>
                            <td>4,946</td>
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