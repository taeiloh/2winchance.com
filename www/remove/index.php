<?php
// config
require_once __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스

try {

    $query = "SELECT * FROM members WHERE m_idx = '{$idx}'";
    $result = $_mysqli->query($query);
    $_arrMembers = $result->fetch_array();
    $m_id = !empty($_arrMembers['m_id']) ? $_arrMembers['m_id'] : '';

} catch (Exception $e) {
    p($e);
}


?>

<!doctype html>
<html lang="ko">
<!--//head-->
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>
<body>
<form id="pwdcheckFrm" name="pwdcheckFrm" method="post" action="RemoveAccept.php">
    <input type="hidden" name="m_idx" id="m_idx" />
    <div id="wrap" class="member">

        <!--content-->
        <div id="content">
            <!--sec-01-->
            <h1 class="logo"><a href="../main/index.php"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
            <section class="sec sec-01">
                <div class="inner">
                    <div class="title">
                        <h2>회원탈퇴</h2>
                    </div>
                    <form action="">
                        <div class="sub-content removeid">
                            <h3>본인 확인</h3>
                            <div class="login-box">
                                <div class="input-box">
                                    <label>아이디</label>
                                    <span><?=$m_id?></span>
                                </div>
                                <div class="input-box">
                                    <label for="">비밀번호</label>
                                    <input type="password" name="u_pw" id="u_pw" placeholder="비밀번호를 확인해주세요.">
                                    <p class="invalid-feedback">8자리 이상의 영문,숫자,특수문자 조합의 숫자를 입력하세요.</p>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-blue btn-6" onclick="next()">다음</button>
                    </form>
                </div>
            </section>
            <!--//sec-01-->
            <!--//content-->
        </div>

        <footer>
            ⓒ 2021-2022, Metarock Inc., All rights Reserved.
        </footer>
</form>
</div>
<!--<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : 'your_site_key'
        });
    };
</script>-->
<script type="text/javascript">
    function next(){


        if ($.trim($("#u_pw").val()) == "") {
            alert("비밀번호를 입력해 주세요.");
            $("#u_pw").focus();
            return false;
        }
        var pw = $("#u_pw").val();

        var postData = {
            "u_pw" : pw
        };

        $.ajax({
            url: "pwd_check.php",
            type: "POST",
            data: postData,
            success: function (data) {
                var json = JSON.parse(data);
                if (json.code == 200) {
                    $("#m_idx").val(json.id);
                    $("#pwdcheckFrm").submit();
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
