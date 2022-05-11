<?php
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
        <div id="content" class="myqna">
            <!--sec-01-->
            <section class="sec sec-01 T0 myAcct">
                <?php
                //header
                require_once __DIR__ . '/../common/category.php';
                ?>
<!--                <div class="category inner">-->
<!--                    <ul>-->
<!--                        <li><a href="javascript:void(0)">MY ACCOUNT</a></li>-->
<!--                        <li class="active"><a href="javascript:void(0)">1 : 1 HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">CASH HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">FP HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">HOW TO PLAY</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="contents-cont inner">
                    <table class="contents-table personalQna">
                        <colgroup>
                            <col style="width:10%">
                            <col style="width:25%">
                            <col style="width:45%">
                            <col style="width:20%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th><a href="javascript:void(0);">번호</a></th>
                            <th><a href="javascript:void(0);">날짜</a></th>
                            <th><a href="javascript:void(0);">제목</a></th>
                            <th><a href="javascript:void(0);">처리상태</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>플레이 버튼을 눌러도 게임에 참여가 안됩니다.</td>
                            <td class="done">상담완료</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>사이트가 자꾸 튕깁니다.</td>
                            <td class="wait">대기중</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>상점에서 엠블렘을 샀는데 메뉴에는 안떠요ㅠㅠ</td>
                            <td class="done">상담완료</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td>상점에서 엠블렘을 샀는데 메뉴에는 안떠요ㅠㅠ</td>
                            <td class="wait">대기중</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td></td>
                            <td class="wait">대기중</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td></td>
                            <td class="done">상담완료</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td></td>
                            <td class="wait">대기중</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>2022-1-03-04 13:25:49</td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </section>
            <!--//sec-01-->
            <div class="qna-btn-box inner">
                <div style="width: 15rem;"></div>
                <div class="pagination">
                    <a href="javascript:void(0)">1</a>
                    <a class="active" href="javascript:void(0)">2</a>
                    <a href="javascript:void(0)">3</a>
                    <a href="javascript:void(0)">4</a>
                </div>
                <button class="btn-blue btn-6">문의하기</button>
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