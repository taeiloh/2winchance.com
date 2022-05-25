<?php
// config
require_once __DIR__ .'/../_inc/config.php';



$m_sns_type       = !empty($_POST['m_sns_type'])           ? strtoupper($_POST['m_sns_type'])         : '';
$m_sns_id       = !empty($_POST['m_sns_id'])           ? strtoupper($_POST['m_sns_id'])         : '';
$userPhone      = !empty($_POST['userPhone'])           ? strtoupper($_POST['userPhone'])         : '';

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
<form id="loginFrm" name="loginFrm" method="post" action="join_05.php">
    <input type="hidden" name="m_sns_type" id="m_sns_type" value="<?=$m_sns_type ?>"/>
    <input type="hidden" name="m_sns_id" id="m_sns_id" value="<?=$m_sns_id?>"/>
    <input type="hidden" name="userPhone" id="userPhone" value="<?=$userPhone?>"/>
    <input type="hidden" name="m_idx" id="m_idx" />
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
                        <li></li>
                        <li class="active"></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <h2>계정 생성</h2>
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
                            <input type="password" name="m_pw" id="m_pw"  placeholder="비밀번호를 입력해주세요.">
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
    <footer>
        ⓒ 2021-2022, Metarock Inc., All rights Reserved.
    </footer>
</div>
</form>
<script type="text/javascript">
    function next(){

        if ($.trim($("#m_id").val()) == "") {
            alert("아이디 입력해 주세요.");
            $("#m_id").focus();
            return false;
        }

        var text = $("#m_id").val();
        var regEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/;
        if (regEmail.test(text) === false) {
            alert('이메일 형식이 아닙니다.');
            $("#m_id").focus();
            return false;
        }


        if ($.trim($("#m_pw").val()) == "") {
            alert("비밀번호를 입력해 주세요.");
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
            alert("비밀번호 확인을 입력해 주세요.");
            $("#m_pw_re").focus();
            return false;
        }
        if  (pw != $("#m_pw_re").val()) {
            alert("비밀번호가 일치하지 않습니다.\n확인 후 다시 입력해 주세요.");
            $("#m_pw_re").focus();
            return false;
        }
        var m_sns_type=$("#m_sns_type").val();
        var m_sns_id=$("#m_sns_id").val();
        var m_id=$("#m_id").val();
        var m_pw=$("#m_pw").val();
        var m_tel=$('#userPhone').val();


        var postData = {
            "m_sns_type": m_sns_type,
            "m_sns_id": m_sns_id,
            "m_id": m_id,
            "m_pw": m_pw,
            "m_tel": m_tel
        };

        $.ajax({
            url: "insert_id.php",
            type: "POST",
            async: false,
            data: postData,
            success: function (data) {
                var json = JSON.parse(data);
                //console.log(json);return false;
                if (json.code == 200) {
                    $("#m_idx").val(json.id);
                    $("#loginFrm").submit();
                }else if (json.code == 201){
                    alert(json.msg);
                    $("#m_idx").val(json.id);
                    $("#loginFrm").submit();
                }else{
                    alert(json.msg);
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
