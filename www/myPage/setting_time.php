<?php
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디

if (!$idx) {
    $url    = $_SERVER['REQUEST_URI'];
    $msg    = '로그인 페이지로 이동합니다.';
    $url    = '/login/index.php?rtnUrl='. $url;
    alertReplace($msg, $url);
    exit;
}
try {



}catch (Exception $e) {
    p($e);
}


?>
<!doctype html>
<html lang="ko" xmlns="http://www.w3.org/1999/html">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>

<!--//head-->

<body>
<div id="wrap" class="sub myqna">
    <!--header-->
    <header id="header">
        <?php
        // header
        require_once __DIR__ .'/../common/header.php';
        ?>
    </header>
    <!--//header-->

    <!--container-->
    <div id="container">
        <!--content-->
        <div id="content" >
            <!--sec-01-->
            <section class="sec sec-01 T0 myAcct">
                <div class="contents-cont inner item-page">
                    <div class="inner">
                        <div class="title">
                            <h2>게임입장 제한기간 설정</h2>
                        </div>
                        <form action="">
                            <div class="sub-content">
                                    <h3>이용자 요청 게임 입장 제한 기간 설정</h3>
                                <div class="limit-input-wrap">
                                    <input type="text" id="set_time" name="set_time" placeholder="1~100까지 입력 가능">
                                </div>
                                <div class="sub-content">
                                    <h3>● 게임 입장 제한 기능을 이용하시면 설정한 일정 동안 <br> 2WinChance를 이용할 수 없습니다.<br>
                                        ● 게임 입장 제한 기능을 이용 시 로그인이 제한되며,<br> 설정 기간 변경이 어떠한 방법으로도 불가능합니다.<br>
                                </div>
                                <button type="button" class="btn-blue btn-6 mT50" id="saveBtn" onclick="save()">적용하기</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <!--//sec-01-->
        </div>
        <!--//content-->
    </div>
    <!--//container-->
    <footer>
        ⓒ 2021-2022, Metarock Inc., All rights Reserved.
    </footer>
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('html_element', {
                'sitekey' : 'your_site_key'
            });
        };
        function save(){
            if ($.trim($("#set_time").val()) == "" || $.trim($("#set_time").val()) > 100 || $.trim($("#set_time").val()) <= 0) {
                alert("1~100까지 중 입력해 주세요.");
                $("#set_time").focus();
                return false;
            }

            var set_time = $("#set_time").val();

            var postData = {
                "set_time" : set_time
            };

            $.ajax({
                url: "setting_time_proc.php",
                type: "POST",
                async: false,
                data: postData,
                success: function (data) {
                    var json = JSON.parse(data);
                    //console.log(json);return false;
                    if (json.code == 200) {
                        alert(json.msg);
                        location.href='../login/logout.php';
                    }
                    else{
                        alert("현재 비밀번호가 일치하지 않습니다");
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
</div>
</body>
</html>
