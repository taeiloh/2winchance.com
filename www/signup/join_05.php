<?php
// config
require_once __DIR__ .'/../_inc/config.php';


$m_idx      = isset($_POST['m_idx'])        ?     $_POST['m_idx']       : '';
$m_id      = isset($_POST['m_id'])        ?     $_POST['m_id']       : '';
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
    <form id="loginFrm" name="loginFrm" method="post" action="join_07.php">
        <input type="hidden" name="m_idx" id="m_idx" value="<?=$m_idx?>"/>
    </form>
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
                        <li></li>
                        <li class="active"></li>
                        <li></li>
                    </ul>
                    <h2>계정생성</h2>
                </div>
                <div class="sub-content">
                    <div class="approve-box">
                        <h4>완료를 위해 이메일 인증을 진행합니다.</h4>
                        <p class="tL">
                            1. [이메일 인증] 버튼을 누르세요.<br/>
                            2. 등록 이메일로 인증 메일이 발송됩니다.<br/>
                            3. 수신된 이메일에서 '인증'하세요.<br/>

                            <small>주의사항: 인증이 완료되지 않으면 회원가입이 되지 않습니다.</small>
                        </p>
                        <b><?=$m_id?></b>
                    </div>
                    <button type="button" class="btn-blue btn-6" onclick="next()">이메일 인증</button>
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
<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : 'your_site_key'
        });
    };

    function next(){

        var m_idx=$("#m_idx").val();

        var postData = {
            "m_idx": m_idx
        };

        $.ajax({
            url: "send_mail.php",
            type: "POST",
            async: false,
            data: postData,
            success: function (data) {
                var json = JSON.parse(data);
                //console.log(json);return false;
                if (json.code == 200) {
                    alert("이메일이 전송되었습니다. 확인해주세요.");
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
