<?php
// config
require_once __DIR__ .'/../_inc/config.php';
checkmobile();
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$user_phone = !empty($_POST['userPhone']) ? $_POST['userPhone'] : "";

$query = "SELECT count(*) from members where m_tel = '{$user_phone}'";
$tresult = mysqli_query($_mysqli,$query);
$row = mysqli_fetch_row($tresult);
$total_count = $row[0];

$sql = "SELECT m_id,m_sns_type from members where m_tel = '{$user_phone}'";
$result1 = $_mysqli->query($sql);
$memarray = $result1->fetch_array();
$m_id = $memarray['m_id'];
$m_sns_type = $memarray['m_sns_type'];

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
<form id="loginFrm" name="loginFrm" method="post" action="../myPage/myaccount.php">
    <input type="hidden" name="m_idx" id="m_idx" />
    <input type="hidden" name="userPhone" id="userPhone" value="<?=$user_phone?>">
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
                            <h3>본인인증이 완료되었습니다.</h3>
                            <?php
                            if($total_count > 1 ){?>
                                <p class="sub-txt">
                                    귀하의 휴대폰 번호로 가입 된 계정이 <?=$total_count?>개 입니다.</br>
                                    본 사이트는 1인 1계정만 가입가능 합니다.
                                    관리자에게 문의바랍니다.
                                </p>
                                <div>
                                </div>
                                <button type="button" class="btn-blue btn-6" onclick="location.href='../main/'">메인으로 돌아가기</button>
                            <?php
                            }
                            else if($total_count == 1)
                            {
                                if($m_sns_type == ""){
                                ?>
                                <p class="sub-txt">
                                    귀하의 계정 : <?=$m_id?></br>
                                    비밀번호 재설정을 해주시길 바랍니다.
                                </p>
                                <div class="login-box">
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
                                <?php
                                }else{?>
                                    <p class="sub-txt">
                                        귀하는 간편 로그인 계정으로 가입되어있습니다.
                                        해당 SNS 사이트에서 비밀번호 찾기를 진행하여주십시오.
                                    </p>
                                    <div>
                                    </div>
                                    <button type="button" class="btn-blue btn-6" onclick="location.href='../main/'">메인으로 돌아가기</button>
                                <?php
                                }
                            }else{?>
                                <p class="sub-txt">
                                    귀하의 휴대폰 번호로 가입 된 계정이 없습니다.
                                </p>
                                <div>
                                </div>
                                <button type="button" class="btn-blue btn-6" onclick="location.href='../main/'">메인으로 돌아가기</button>
                            <?php
                            } ?>
                        </div>
                    </form>
                </div>
            </section>
            <!--//sec-01-->
            <!--//content-->
        </div>
</form>
<footer>
    ⓒ 2021-2022, Metarock Inc., All rights Reserved.
</footer>
</div>
<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : 'your_site_key'
        });
    };
    function next(){
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
        var m_pw = $("#m_pw").val();
        var userPhone = $("#userPhone").val();

        var postData = {
            "m_pw" : m_pw,
            "userPhone" : userPhone
        };

        $.ajax({
            url: "reset_pw.php",
            type: "POST",
            async: false,
            data: postData,
            success: function (data) {
                var json = JSON.parse(data);
                /*console.log(json);return false;*/
                if (json.code == 200) {
                    alert(json.msg);
                    $("#m_idx").val(json.id);
                    $("#loginFrm").submit();
                }
                else{
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
