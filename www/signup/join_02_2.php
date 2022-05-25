<?php
// config
require_once __DIR__ .'/../_inc/config.php';

$m_sns_type       = !empty($_POST['m_sns_type'])           ? strtoupper($_POST['m_sns_type'])         : '';
$m_sns_id       = !empty($_POST['m_sns_id'])           ? strtoupper($_POST['m_sns_id'])         : '';
$userPhone = !empty($_POST['userPhone'])           ? $_POST['userPhone']        : '';

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


<form id="snsLoginFrm" name="snsLoginFrm" method="post" action="sns_insert_proc.php">
    <input type="hidden" name="m_sns_type" id="m_sns_type" value="<?=$m_sns_type ?>"/>
    <input type="hidden" name="m_sns_id" id="m_sns_id" value="<?=$m_sns_id?>"/>
    <input type="hidden" name="userPhone" id="userPhone" value="<?=$userPhone?>"/>
</form>
<form id="loginFrm" name="loginFrm" method="post" action="join_04.php">
    <input type="hidden" name="userPhone" id="userPhone" value="<?=$userPhone?>"/>
<div id="wrap" class="member">
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="/main/index.php"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
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
                    <h2>계정 타입 선택</h2>
                </div>
                <div class="sub-content">
                    <!--<h3>본인인증</h3>
                    <p class="sub-txt">
                        회원가입을 위한 본인인증이 필요합니다.<br>
                        본인인증 시 제공되는 정보는 해당 인증기관에서<br>
                        직접 수집하며, 인증 이외의 용도로 이용 또는<br>
                        저장하지 않습니다.
                    </p>-->
                    <div class="confirm-wrap">
                        <div class="confirm-box">
                            <div>
                                <h4>일반 이메일 계정 회원</h4>
                                <p>이메일로 인증 (예:네이버,구글 등)</p>
                            </div>
                            <button type="submit" class="btn-blue btn-6">인증하기</button>
                        </div>
                        <!--<div class="confirm-box mT10">
                            <div>
                                <h4>신용/ 체크카드 인증</h4>
                                <p>본인 명의의 신용/체크카드로 인증</p>
                            </div>
                            <button type="button" class="btn-blue btn-6">인증하기</button>
                        </div>-->
                    </div>
                </form>
                    <div class="sns-login">
                        <p>간편 인증으로 가입하기</p>
                        <ul>
                            <!--<li><a href="javascript:void(0)"><img src="../images/ico_facebook.png" alt="페이스북 로그인"></a></li>
                            <li><a href="javascript:void(0)"><img src="../images/ico_naver.png" alt="네이버 로그인"></a></li>
                            <li><a href="javascript:void(0)"><img src="../images/ico_twitter.png" alt="트위터 로그인"></a></li>-->
                            <li><a href="javascript:void(0)" onclick="javascript:joinKakao1();"><img src="../images/ico_kakao.png" alt="카카오 로그인"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--//sec-01-->
        <!--//content-->
    </div>
    <footer>
        ⓒ 2021-2022, Metarock Inc., All rights Reserved.
    </footer>
</div>
</body>
<script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
<script type="text/javascript">
    /*function loginKakao1() {
        $("#loginFrm").submit();

    }*/

    Kakao.init('01857bbef00f6cb15e0499c126201dde');
    console.log(Kakao.isInitialized());
        function joinKakao1() {
            Kakao.Auth.login({
            success: function(authObj) {
                //console.log(JSON.stringify(authObj));
                Kakao.API.request({
                    url: '/v2/user/me',
                    success: function(res) {
                        //console.log(JSON.stringify(res));
                        var sns_id = JSON.stringify(res.id);
                        $("#m_sns_type").val("kakao");
                        $("#m_sns_id").val(sns_id);
                        $("#snsLoginFrm").submit();
                    },
                    fail: function(error) {
                        alert("본인인증 중 오류가 발생했습니다.\r\n다시 시도해 주세요.");
                    },
                })
            },
            fail: function(err) {
                alert("카카오 로그인 실패하였습니다.\r\n관리자에게 문의해 주세요.");
                return false;
            },
        })

    }

    //카카오 로그인
    function loginKakao() {
        location.href = "https://kauth.kakao.com/oauth/authorize?client_id=77dd1dcd5ebf629806e3557a187d1591&redirect_uri=http://2winchance.com/login/kakaoLoginProc.php&response_type=code";
    }

    //네이버 로그인
    function loginNaver() {
        location.href = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=JR3jWioSO8V8DZw_foqk&redirect_uri=https%3A%2F%2Fmomschoice.wtest.biz%2Fmember%2FnaverLoginProc.php&state=4e50ac1d41";
    }

    //애플 로그인
    function loginApple() {
        location.href = "https://appleid.apple.com/auth/authorize?response_type=code&response_mode=form_post&client_id=com.idevelapp.momschoice&client_secret=eyJhbGciOiJFUzI1NiIsImtpZCI6Ik0zSFY3M0o4RkwifQ.eyJpc3MiOiJVSDMzMlRGWFdNIiwiaWF0IjoxNjUyMTY0MDc3LCJleHAiOjE2NTIxNjc2NzcsImF1ZCI6Imh0dHBzOlwvXC9hcHBsZWlkLmFwcGxlLmNvbSIsInN1YiI6ImNvbS5pZGV2ZWxhcHAubW9tc2Nob2ljZSJ9.oz6PQ2Vi7184qOWI0AO0j7cwp82cOxbYVuZSv7vzpLhjwQptZUefKPr-K9xEhP_iLU3Nf4yUT5bSC0llMS7YSw&redirect_uri=https%3A%2F%2Fmomschoice.wtest.biz%2Fmember%2FappleAuth.php&state=3f03370810&scope=name+email";
    }


    function callSa()
    {
        let window = popupCenter();
        if(window != undefined && window != null)
        {
            document.saForm.setAttribute("target", "sa_popup");
            document.saForm.setAttribute("post", "post");
            document.saForm.setAttribute("action", "https://sa.inicis.com/auth");
            document.saForm.submit();
        }
    }

    function popupCenter() {
        let _width = 400;
        let _height = 620;
        var xPos = (document.body.offsetWidth/2) - (_width/2); // 가운데 정렬
        xPos += window.screenLeft; // 듀얼 모니터일 때
        openWin = window.open("", "sa_popup", "width="+_width+", height="+_height+", left="+xPos+", menubar=yes, status=yes, titlebar=yes, resizable=yes");
        return openWin;
    }
    function abcd(){
        opener.parent.location='이동할페이지?넘길변수=넘길값';
        window.close();
    }

</script>
</html>
