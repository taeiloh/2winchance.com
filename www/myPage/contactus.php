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
                <div class="contents-cont inner qna-wrap">
                    <div class="footer-inner">
                        <h3 class="footer-sub-title">문의하기</h3>
                        <div class="footer-cont ask">
                            <div>
                                <h4>문의 내용을 선택해주세요.</h4>
                                <section id="dropdown">
                                    <div class="select">
                                        <div class="text">종류를 선택해주세요.</div>
                                        <ul class="option-list">
                                            <li class="option">계정 제한</li>
                                            <li class="option">광고</li>
                                            <li class="option">보너스</li>
                                            <li class="option">상점</li>
                                            <li class="option">불만 사항</li>
                                            <li class="option">콘테스트</li>
                                            <li class="option">기타</li>
                                            <li class="option">로그인</li>
                                            <li class="option">제안</li>
                                            <li class="option">기술적 문제</li>
                                        </ul>
                                    </div>
                                </section>
                            </div>
                            <div>
                                <h4>유저 이름</h4>
                                <p class="fc-blue">정글못해먹겐네</p>
                            </div>
                            <div>
                                <h4>E-mail</h4>
                                <input type="email" placeholder="이메일을 입력해주세요.">
                            </div>
                            <div>
                                <h4>문의 제목</h4>
                                <input type="text" placeholder="제목을 입력해주세요.">
                                <span class="alert"><img src="../images/ico_alert_blue.svg" alt="입력조건">10자 이상의 내용을 작성해주세요.</span>
                            </div>
                            <div>
                                <h4>문의 내용</h4>
                                <textarea name="askCont" id="askCont" placeholder="문의하실 내용을 입력해주세요."></textarea>
                                <span class="alert"><img src="../images/ico_alert_blue.svg" alt="입력조건">2000자 이내로 내용을 작성해주세요.</span>
                            </div>
                        </div>
                        <div class="captcha">
                            <form action="?" method="POST">
                                <div id="html_element"></div>
                                <!--                                    <br>-->
                                <!--                                    <input type="submit" value="Submit">-->
                            </form>
                            <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
                                    async defer>
                            </script>
                        </div>
                        <div class="btn-center mT50">
                            <button type="button" class="btn-blue">저장</button>
                        </div>
                        <div class="add-ask">
                            <div>
                                <p>MON ~ FRI</p>
                                <span>09:00 ~ 18:00</span>
                            </div>
                            <div>
                                <p>SAT ~ SUN</p>
                                <span>09:00 ~ 14:00</span>
                            </div>
                            <h4>추가 문의</h4>
                            <a href="Support@Metagame.com">Support@Metagame.com</a>
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