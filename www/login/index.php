<?php
// config
require_once __DIR__ .'/../_inc/config.php';
$rtnUrl     = !empty($_GET['rtnUrl'])       ? $_GET['rtnUrl']       : '/';


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
    <form id="loginFrm" name="loginFrm" method="post" action="">
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
                                <input type="email" name="m_id" id="m_id" placeholder="아이디를 입력해주세요.">
                                <p class="invalid-feedback">영문으로 시작하는 e-mail 주소를 입력해 주세요.</p>
                            </div>
                            <div class="input-box">
                                <label for="">비밀번호</label>
                                <input type="password" name="m_pw" id="m_pw" placeholder="비밀번호를 입력해주세요.">
                                <p class="invalid-feedback">8자리 이상의 영문,숫자,특수문자 조합의 숫자를 입력하세요.</p>
                            </div>
                            <div class="find-wrap">
                                <a href="javascript:void(0)" class="fc-blue" onclick="location.href='/signup/index.php'">회원가입</a>
                                <a href="javascript:void(0)">아이디찾기</a>
                                <a href="javascript:void(0)">비밀번호찾기</a>
                            </div>
                        </div>
                        <button type="button" class="btn-blue btn-6" onclick="login()">로그인</button>
                        <div class="sns-login">
                            <p>간편 로그인</p>
                            <ul>
                                <li><a href="javascript:void(0)"><img src="/images/ico_facebook.png" alt="페이스북 로그인"></a></li>
                                <li><a href="javascript:void(0)"><img src="/images/ico_naver.png" alt="네이버 로그인"></a></li>
                                <li><a href="javascript:void(0)"><img src="/images/ico_twitter.png" alt="트위터 로그인"></a></li>
                                <li><a href="javascript:void(0)" onclick="loginKakao()"><img src="/images/ico_kakao.png" alt="카카오 로그인"></a></li>
                            </ul>
                        </div>
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
<script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
<script type="text/javascript">
    function login(){
        if ($.trim($("#m_id").val()) == "") {
            alert("아이디를 입력해 주세요");
            $("#m_id").focus();
            return false;
        }


        if ($.trim($("#m_pw").val()) == "") {
            alert("비밀번호를 입력해 주세요");
            $("#m_pw").focus();
            return false;
        }

        var formData = new FormData($("#loginFrm")[0]);

        console.log(FormData);
        $.ajax({
            url: "login_proc.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                var json = JSON.parse(data);
                console.log(data);
                alert(json.msg);
                if (json.code == 200) {
                    location.href = "../main/index.php";
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }



        Kakao.init('01857bbef00f6cb15e0499c126201dde');
        console.log(Kakao.isInitialized());
        function loginKakao() {
            Kakao.Auth.login({
                success: function(authObj) {
                    //console.log(JSON.stringify(authObj));
                    Kakao.API.request({
                        url: '/v2/user/me',
                        success: function(res) {
                            //console.log(JSON.stringify(res));
                            var sns_id = JSON.stringify(res.id);
                            var postData = {
                                "m_sns_type": "kakao",
                                "m_sns_id": sns_id
                            };

                            $.ajax({
                                url: "check_sns_id.php",
                                type: "POST",
                                data: postData,
                                success: function (data) {
                                    var json = JSON.parse(data);
                                    console.log(data);
                                    if (json.code == 200) {
                                        <?php
                                        if($rtnUrl=="/"){
                                            echo 'location.href = "../main/index.php"';
                                        }else{
                                            echo 'location.href = "'.$rtnUrl.'"';
                                        }
                                        ?>

                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                }
                            });


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


</script>
</body>
</html>