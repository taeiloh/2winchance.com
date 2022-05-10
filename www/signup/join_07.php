<?php
// config
require_once __DIR__ .'/../_inc/config.php';


$q      = isset($_GET['q'])     ? $_GET['q']    : '';

//파라미터 체크
if (empty($q)) {
    echo '필수 입력 항목이 누락되었습니다.';
    exit;
}

$q_decode   = base64_decode($q);
//p($q);
$arrV       = explode('&', $q_decode);
$arrVal     = explode('=',$arrV[0]); //id
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
    <form id="loginFrm" name="loginFrm" method="post" >
        <input type="hidden" name="m_id" id="m_id" value="<?=$arrVal[1]?>"/>
<div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="/main/index.php"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
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
                            <input type="text" name="m_name" id="m_name"placeholder="닉네임을 입력해주세요.">
                            <p class="invalid-feedback">6자 이상 입력해주세요.</p>
<!--                            <p class="invalid-feedback error">사용가능한 닉네임이 아닙니다.</p>-->
                        </div>
                        <div class="input-box">
                            <label for="">생년월일</label>
                            <input type="number" name="m_b_year" id="m_b_year" placeholder="생년월일 8자리를 입력해주세요.">
                        </div>
                        <div class="input-box">
                            <label for="">이메일</label>
                            <input type="email" placeholder="이메일을 입력해주세요." value="<?=$arrVal[1]?>" readonly>
                        </div>
                        <div class="input-box">
                            <label for="">연락처</label>
                            <input type="text" name="m_tel" id="m_tel" placeholder="전화번호를 입력해주세요.">
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

        if ($.trim($("#m_name").val()) == "") {
            alert("닉네임을 입력해 주세요.");
            $("#m_name").focus();
            return false;
        }
        if ($.trim($("#m_b_year").val()) == "") {
            alert("생년월일 입력해 주세요.");
            $("#m_b_year").focus();
            return false;
        }
        if ($.trim($("#m_tel").val()) == "") {
            alert("전화번호를 입력해 주세요.");
            $("#m_tel").focus();
            return false;
        }
        var sex = $('input[name=sex]:checked').val();

        if (sex == "") {
            alert("성별을 선택해 주세요.");
            return false;
        }
        var m_id=$("#m_id").val();
        var m_name=$("#m_name").val();
        var m_b_year=$("#m_b_year").val();
        var m_tel=$("#m_tel").val();


        var postData = {
            "m_id": m_id,
            "m_name": m_name,
            "m_b_year": m_b_year,
            "m_tel": m_tel,
            "sex": sex
        };

        $.ajax({
            url: "insert_id1.php",
            type: "POST",
            async: false,
            data: postData,
            success: function (data) {
                var json = JSON.parse(data);
                //console.log(json);return false;
                if (json.code == 200) {
                    location.href="join_06.php"
                }
            },
            beforeSend:function(){
                $(".wrap-loading").removeClass("display-none");
            },
            complete:function(){
                $(".wrap-loading").addClass("display-none");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });


    }

</script>
</body>
</html>