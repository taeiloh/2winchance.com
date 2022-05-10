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
<div id="wrap" class="member">
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="/main/index.php"><img src="/images/logo.png" alt="METAGAMES"></a></h1>
        <section class="sec sec-01">
            <div class="inner">
                <div class="title">
                    <h2><!--img src="/images/img_title_bg.svg" alt="계정생성"--> 로그인</h2>
                </div>
                <form action="">
                    <div class="sub-content">
                        <h3>기본 정보 입력</h3>
                        <div class="login-box">
                            <div class="input-box">
                                <label for="">아이디</label>
                                <input type="email" placeholder="아이디를 입력해주세요.">
                                <p class="invalid-feedback">영문으로 시작하는 e-mail 주소를 입력해 주세요.</p>
                            </div>
                            <div class="input-box">
                                <label for="">비밀번호</label>
                                <input type="password" placeholder="비밀번호를 입력해주세요.">
                                <p class="invalid-feedback">8자리 이상의 영문,숫자,특수문자 조합의 숫자를 입력하세요.</p>
                            </div>
                            <div class="find-wrap">
                                <a href="javascript:void(0)" class="fc-blue">회원가입</a>
                                <a href="javascript:void(0)">아이디찾기</a>
                                <a href="javascript:void(0)">비밀번호찾기</a>
                            </div>
                        </div>
                        <button type="button" class="btn-blue btn-6">로그인</button>
                        <div class="sns-login">
                            <p>간편 로그인</p>
                            <ul>
                                <li><a href="javascript:void(0)"><img src="/images/ico_facebook.png" alt="페이스북 로그인"></a></li>
                                <li><a href="javascript:void(0)"><img src="/images/ico_naver.png" alt="네이버 로그인"></a></li>
                                <li><a href="javascript:void(0)"><img src="/images/ico_twitter.png" alt="트위터 로그인"></a></li>
                                <li><a href="javascript:void(0)"><img src="/images/ico_kakao.png" alt="카카오 로그인"></a></li>
                            </ul>
                        </div>
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