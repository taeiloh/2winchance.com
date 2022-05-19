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
<!--//head-->

<body xmlns="http://www.w3.org/1999/html">
<div id="wrap" class="member">
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="../html/index.html"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
        <section class="sec sec-01">
            <div class="inner remove-policy">
                <div class="title">
                    <h2>회원탈퇴</h2>
                </div>
                <div>
                    <ul class="remove-acct">
                        <li><a href="javascript:void(0);"><span><?=$m_id?></span></a></li>
                        <li><a href="javascript:void(0);">정글못해먹겐네</a></li>
                    </ul>
                    <div class="recent-point">
                        <h3>잔여포인트</h3>
                        <div class="user-detail-info">
                            <ul>
                                <li><p>캐시</p><span class="fc-yellow coin">54,222</span></li>
                                <li><p>파이트 포인트</p><span class="fp">16</span></li>
                                <li><p>명예 포인트</p><span class="hp">16</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="sub-content removeid">
                    <div>
                        <p class="checkbox">
                            <input type="checkbox" class="" id="policy08">
                            <label for="policy08" class="">회원탈퇴 완료 후 환불이 불가한 것에 대해 인지하였으며 동의합니다.</label>
                        </p>
                        <p class="checkbox">
                            <input type="checkbox" class="" id="policy09" checked="checked">
                            <label for="policy09" class="">회원탈퇴 시 주의사항에 대해 확인하였으며 회원탈퇴에 동의합니다.</label>
                        </p>
                    </div>
                    <div class="confirm-wrap">
                        <button type="button" class="btn-red btn-6">동의 및 본인인증</button>
                    </div>
                </div>
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