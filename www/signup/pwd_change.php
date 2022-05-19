<?php
// config
require_once __DIR__ .'/../_inc/config.php';
checkmobile();

try {

} catch (Exception $e) {
    p($e);
}
?>
<!doctype html>
<html lang="ko">
<!--//head-->
<head>
    <?php
    // head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>
<body>
<div id="wrap" class="member">
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="../html/index.html"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
        <section class="sec sec-01">
            <div class="inner">
                <div class="title">
                    <ul class="step">
                        <li></li>
                        <li></li>
                        <li class="active"></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <h2>비밀번호 변경</h2>
                </div>
                <form action="">
                    <div class="sub-content">
                        <h3>비밀번호는 주기적으로 변경해주시기 바랍니다.</h3>
                        <div class="login-box">
                            <div class="input-box">
                                <label for="">현재 비밀번호</label>
                                <input type="password" placeholder="현재 비밀번호를 입력해주세요.">
                                <!--<p class="invalid-feedback">영문으로 시작하는 e-mail 주소를 입력해 주세요.</p>-->
                            </div>
                            <div class="input-box">
                                <label for="">신규 비밀번호</label>
                                <input type="password" placeholder="비밀번호를 입력해주세요.">
                            </div>
                            <div class="input-box">
                                <label for="">비밀번호 확인</label>
                                <input type="password" placeholder="비밀번호를 확인해주세요.">
                                <p class="invalid-feedback">8자리 이상의 영문,숫자,특수문자 조합의 숫자를 입력하세요.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-blue btn-6">다음</button>
                    </div>
                </form>
            </div>
        </section>
        <!--//sec-01-->
        <!--//content-->
    </div>
    <footer>
        © 2022 METAGAMES, Inc. All Rights Reserved.
    </footer>
</div>
<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : 'your_site_key'
        });
    };
</script>
</body>
</html>