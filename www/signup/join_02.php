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
                        <li class="active"></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <h2>계정생성</h2>
                </div>
                <div class="sub-content">
                    <h3>본인인증</h3>
                    <p class="sub-txt">
                      회원가입을 위한 본인인증이 필요합니다.<br>
                      본인인증 시 제공되는 정보는 해당 인증기관에서<br>
                      직접 수집하며, 인증 이외의 용도로 이용 또는<br>
                      저장하지 않습니다.
                    </p>
                    <div class="confirm-wrap">
                        <div class="confirm-box">
                            <div>
                                <h4>핸드폰 인증</h4>
                                <p>본인 명의의 핸드폰으로 인증</p>
                            </div>
                            <button type="button" class="btn-blue btn-6">인증하기</button>
                        </div>
                        <div class="confirm-box mT10">
                            <div>
                                <h4>신용/ 체크카드 인증</h4>
                                <p>본인 명의의 핸드폰으로 인증</p>
                            </div>
                            <button type="button" class="btn-blue btn-6">인증하기</button>
                        </div>
                    </div>
                    <div class="sns-login">
                        <p>간편 로그인</p>
                        <ul>
                            <li><a href="javascript:void(0)"><img src="../images/ico_facebook.png" alt="페이스북 로그인"></a></li>
                            <li><a href="javascript:void(0)"><img src="../images/ico_naver.png" alt="네이버 로그인"></a></li>
                            <li><a href="javascript:void(0)"><img src="../images/ico_twitter.png" alt="트위터 로그인"></a></li>
                            <li><a href="javascript:void(0)"><img src="../images/ico_kakao.png" alt="카카오 로그인"></a></li>
                        </ul>
                    </div>
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
</body>
</html>