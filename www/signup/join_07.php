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
<div id="wrap" class="member">
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
                    <h2>계정 생성</h2>
                </div>
                <form action="">
                <div class="sub-content">
                    <h3>개인 정보 입력</h3>
                    <div class="login-box nick">
                        <h4>설정하신 닉네임은 변경하실 수 없습니다.</h4>
                        <div class="input-box">
                            <label for="">닉네임</label>
                            <input type="text" placeholder="닉네임을 입력해주세요.">
                            <p class="invalid-feedback">6자 이상 입력해주세요.</p>
<!--                            <p class="invalid-feedback error">사용가능한 닉네임이 아닙니다.</p>-->
                        </div>
                        <div class="input-box">
                            <label for="">생년월일</label>
                            <input type="number" placeholder="생년월일 8자리를 입력해주세요.">
                        </div>
                        <div class="input-box">
                            <label for="">이메일</label>
                            <input type="email" placeholder="이메일을 입력해주세요.">
                        </div>
                        <div class="input-box">
                            <label for="">연락처</label>
                            <input type="email" placeholder="전화번호를 입력해주세요.">
                        </div>
                        <div class="input-radio">
                            <span>성별</span>
                            <div class="radio-wrap">
                                <p class="checkbox">
                                    <input type="radio" name="sex" value="male" id="male">
                                    <label for="male" class="">남자</label>
                                </p>
                                <p class="checkbox">
                                    <input type="radio" name="sex" value="female" id="female">
                                    <label for="female" class="">여자</label>
                                </p>
                            </div>
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
</body>
</html>