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
<form id="loginFrm" name="loginFrm" method="post" action="/">
    <input type="hidden" name="m_idx" id="m_idx" />
<div id="wrap" class="member">
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="../main/index.php"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
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
                                <input type="password" name="now_pw" id="now_pw" placeholder="현재 비밀번호를 입력해주세요.">
                                <!--<p class="invalid-feedback">영문으로 시작하는 e-mail 주소를 입력해 주세요.</p>-->
                            </div>
                            <div class="input-box">
                                <label for="">신규 비밀번호</label>
                                <input type="password" name="m_pw" id="m_pw" placeholder="비밀번호를 입력해주세요.">
                            </div>
                            <div class="input-box">
                                <label for="">비밀번호 확인</label>
                                <input type="password" name="m_pw_re" id="m_pw_re" placeholder="비밀번호를 확인해주세요.">
                                <p class="invalid-feedback">8자리 이상의 영문,숫자,특수문자 조합의 숫자를 입력하세요.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-blue btn-6" onclick="next()">다음</button>
                    </div>
                </form>
            </div>
        </section>
        <!--//sec-01-->
        <!--//content-->
    </div>
    </form>
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
    function next(){

        if ($.trim($("#now_pw").val()) == "") {
            alert("현재 비밀번호를 입력해 주세요.");
            $("#now_pw").focus();
            return false;
        }

        if ($.trim($("#m_pw").val()) == "") {
            alert("신규 비밀번호를 입력해 주세요.");
            $("#m_pw").focus();
            return false;
        }
        var pw = $("#m_pw").val();
        var checkNumber = pw.search(/[0-9]/g);
        var checkEnglish = pw.search(/[a-z]/ig);

        if(pw.length < 8 || pw.length > 20){
            alert("8자리 ~ 20자리 이내로 입력해주세요.");
            return false;
        }else if(!/^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,25}$/.test(pw)){
            alert('숫자+영문자+특수문자 조합으로 8자리 이상 사용해야 합니다.');
            return false;
        }else if(checkNumber <0 || checkEnglish <0){
            alert("숫자와 영문자를 혼용하여야 합니다.");
            return false;
        }else if(/(\w)\1\1\1/.test(pw)){
            alert('같은 문자를 4번 이상 사용하실 수 없습니다.');
            return false;
        }else {
            console.log("통과");
        }
        if ($.trim($("#m_pw_re").val()) == "") {
            alert("신규 비밀번호 확인을 입력해 주세요.");
            $("#m_pw_re").focus();
            return false
        }
        if  (pw != $("#m_pw_re").val()) {
            alert("비밀번호가 일치하지 않습니다.\n확인 후 다시 입력해 주세요.");
            $("#m_pw_re").focus();
            return false;
        }
    }
</script>
</body>
</html>