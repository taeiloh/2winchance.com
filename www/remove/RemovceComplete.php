<?php
// config
require_once __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
try {

    $query = "DELETE FROM members WHERE m_idx = '{$idx}'";
    $result = $_mysqli->query($query);

} catch (Exception $e) {
    p($e);
}
?>
<!--//head-->
<!doctype html>
<html lang="ko">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>

<body xmlns="http://www.w3.org/1999/html">
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
                <div class="sub-content removeid">
                    <h3>
                        회원 탈퇴가 완료 되었습니다.</br>
                        이용해 주셔서 감사합니다.
                    </h3>
                    <div class="confirm-wrap">
                        <a href="../login/logout.php"><button type="button" class="btn-blue btn-6">홈으로</button>
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
</body>
</html>