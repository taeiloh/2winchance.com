<?php
require_once __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$deposit=!empty($_SESSION['_se_deposit']) ? $_SESSION['_se_deposit'] : 0;    // 세션 포인트
$fp=!empty($_SESSION['_se_fp']) ? $_SESSION['_se_fp'] : 0; // fantasy-point 잔액

try {

    $query = "SELECT * FROM members WHERE m_idx = '{$idx}'";
    $result = $_mysqli->query($query);
    $_arrMembers = $result->fetch_array();
    $m_id = !empty($_arrMembers['m_id']) ? $_arrMembers['m_id'] : '';
    $m_name = !empty($_arrMembers['m_name']) ? $_arrMembers['m_name'] : '';
    $m_sns_type = !empty($_arrMembers['m_sns_type']) ? $_arrMembers['m_sns_type'] : '';
    $m_fp_balance = !empty($_arrMembers['m_fp_balance']) ? $_arrMembers['m_fp_balance'] : 0;

    $query2 = "SELECT * FROM honor_point_history WHERE hph_m_idx = '{$idx}'";
    $result2 = $_mysqli->query($query2);
    $honormem = $result2->fetch_array();
    $hph_balance = !empty($honormem['hph_balance']) ?$honormem['hph_balance'] : 0;

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
<form id="checked" name="checked" method="post" action="SelfCertification.php">
    <body xmlns="http://www.w3.org/1999/html">
    <div id="wrap" class="member">
        <!--content-->
        <div id="content">
            <!--sec-01-->
            <h1 class="logo"><a href="../main/index.php"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
            <section class="sec sec-01">
                <div class="inner remove-policy">
                    <div class="title">
                        <h2>회원탈퇴</h2>
                    </div>
                    <div>
                        <ul class="remove-acct">
                            <?php
                            if($m_id){
                                ?>
                                <li><a href="javascript:void(0);"><?=$m_id?></a></li>
                                <li><a href="javascript:void(0);"><?=$m_name?></a></li>
                                <?php
                            }else{?>
                                <li><a href="javascript:void(0);"><?=$m_sns_type?> 계정</a></li>
                                <li><a href="javascript:void(0);"><?=$m_name?></a></li>
                                <?php
                            }?>
                        </ul>
                        <div class="recent-point">
                            <h3>잔여포인트</h3>
                            <div class="user-detail-info">
                                <ul>
                                    <li><p>COIN</p><span class="fc-yellow coin"><?=$deposit?></span></li>
                                    <li><p>Fight Point</p><span class="fp"><?=$m_fp_balance?></span></li>
                                    <li><p>Honor Point</p><span class="fp"><?=$hph_balance?></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="sub-content removeid">
                        <div>
                            <p class="checkbox">
                                <input type="checkbox" class="" id="policy08" name="policy08">
                                <label for="policy08" class="">회원탈퇴 완료 후 환불이 불가한 것에 대해 인지하였으며 동의합니다.</label>
                            </p>
                            <p class="checkbox">
                                <input type="checkbox" class="" id="policy09" name="policy09">
                                <label for="policy09" class="">회원탈퇴 시 주의사항에 대해 확인하였으며 회원탈퇴에 동의합니다.</label>
                            </p>
                        </div>
                        <div class="confirm-wrap">
                            <button type="button" class="btn-red btn-6"  onclick="next()">동의 및 본인인증</button>
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
</form>
</div>
<script type="text/javascript">
    var onloadCallback = function () {
        grecaptcha.render('html_element', {
            'sitekey': 'your_site_key'
        });
    };
    function next(){
        var chk1 = document.checked.policy08.checked;
        var chk2 = document.checked.policy09.checked;

        if(!chk1 || !chk2)
        {
            alert("약관에 동의 하여 주세요");
            return false;
        }
        else
        {
            location.href = "SelfCertification.php";
        }

    }
</script>
</body>
</html>
