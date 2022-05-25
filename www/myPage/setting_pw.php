<?php
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임
$deposit=!empty($_SESSION['_se_deposit']) ? $_SESSION['_se_deposit'] : 0;    // 세션 포인트
$fp=!empty($_SESSION['_se_fp']) ? $_SESSION['_se_fp'] : 0; // fantasy-point 잔액

if (!$idx) {
    $url    = $_SERVER['REQUEST_URI'];
    $msg    = '로그인 페이지로 이동합니다.';
    $url    = '/login/index.php?rtnUrl='. $url;
    alertReplace($msg, $url);
    exit;
}
try {
    $sql = "select count(*) from contactus where 1=1 and cu_u_idx = '{$idx}'";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수

    $query = "
        SELECT *
        FROM contactus
        WHERE 1 and cu_u_idx ='{$idx}'
    ";

    $result = $_mysqli->query($query);

    $query2 = "
    SELECT *
        FROM members
        WHERE 1 and m_idx ='{$idx}'
    ";
    $mresult = $_mysqli->query($query2);
    $_arrMembers = $mresult->fetch_array();
    $m_sns_type = !empty($_arrMembers['m_sns_type']) ? $_arrMembers['m_sns_type'] : '';

}catch (Exception $e) {
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
                            <h2>비밀번호 확인</h2>
                        </div>
                        <form action="setting_cash.php" name="pwFrm" id="pwFrm" method="post">
                            <div class="sub-content">
                                <h3>회원정보를 안전하게 관리하기 위해 비밀번호를 한번 더 입력해 주세요.<br>
                                    비밀번호는 타인에게 노출 되지 않도록 주의가 필요 합니다.
                                </h3>
                                <div class="login-box">
                                    <input type="password" name="m_pw" id="m_pw" placeholder="비밀번호를 입력해주세요.">
                                    <p class="invalid-feedback">비밀번호를 입력해주세요</p>
                                    <!--        이메일 에러시 <p class="invalid-feedback error">비밀번호가 일치하지 않습니다. 다시 한번 확인해 주세요.
</p>-->
                                </div>
                                <button type="button" class="btn-blue btn-6 mT50" onclick="check()">확인</button>
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
</div>
<script type="text/javascript">
    function check(){

        if ($.trim($("#m_pw").val()) == "") {
            alert("비밀번호를 입력해 주세요");
            $("#m_pw").focus();
            return false;
        }

        var postData = {
            "m_pw" : $("#m_pw").val()
        };

        $.ajax({
            url: "setting_pw_proc.php",
            type: "POST",
            async: false,
            data: postData,
            dataType: "JSON",
            success: function (data){
                alert(data.msg);
                if(data.code == 200){
                    $("#pwFrm").submit();
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>
</body>
</html>
