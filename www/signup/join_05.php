<?php
// config
require_once __DIR__ .'/../_inc/config.php';

//function
require_once __DIR__ .'/../_inc/function.php';
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
                        <li></li>
                        <li class="active"></li>
                        <li></li>
                    </ul>
                    <h2>계정생성</h2>
                </div>
                <div class="sub-content">
                    <div class="approve-box">
                        <h4>계정 생성이 완료 되었습니다.</h4>
                        <p>
                            계정 인증을 완료하기 위해 이메일을 인증해주세요.<br>
                            등록하신 이메일로 인증메일이 전송됩니다.
                        </p>
                        <b>login010@naver.com</b>
                    </div>
                    <button type="button" class="btn-blue btn-6">이메일 인증</button>
                </div>
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