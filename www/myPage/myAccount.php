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
                <div class="category inner">
                    <ul>
                        <li><a href="javascript:void(0)">MY ACCOUNT</a></li>
                        <li class="active"><a href="javascript:void(0)">1 : 1 HISTORY</a></li>
                        <li><a href="javascript:void(0)">CASH HISTORY</a></li>
                        <li><a href="javascript:void(0)">FP HISTORY</a></li>
                        <li><a href="javascript:void(0)">HOW TO PLAY</a></li>
                    </ul>
                </div>
                <div class="contents-cont inner item-page">
                    <div class="user-acct">
                        <div class="user-profile">
                            <div class="pf-pic">
                                <img src="../images/item1.png" alt="profile">
                            </div>
                            <div class="pf-info">
                                <ul>
                                    <li>닉네임</li>
                                    <li>정글 못해먹겐네</li>
                                </ul>
                                <ul>
                                    <li>E-MAIL </li>
                                    <li>abC1234@naver.com</li>
                                </ul>
                                <dl>
                                    <dt>비밀번호 변경하기</dt>
                                    <dd>회원 탈퇴하기</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="user-detail-info">
                            <h3>상세정보</h3>
                            <ul>
                                <li><p>COIN</p><span class="fc-yellow coin">54,222</span></li>
                                <li><p>Fantasy Point</p><span class="fp">16</span></li>
                                <li><p>문의내역</p><span class="count">6</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-item">
                        <div class="item-list">
                            <label><input type="radio" name="type" value="type1" checked>치장형</label>
                            <label><input type="radio" name="type" value="type2">편의형</label>
                            <label><input type="radio" name="type" value="type3">스페셜</label>
                        </div>
                        <div class="user-item-list scroll">
                            <ul>
                                <li class="active"><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li class="disabled"><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
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
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('html_element', {
                'sitekey' : 'your_site_key'
            });
        };
    </script>
</div>
</body>
</html>