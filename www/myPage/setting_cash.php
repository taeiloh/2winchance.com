<?php
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임
$deposit=!empty($_SESSION['_se_deposit']) ? $_SESSION['_se_deposit'] : 0;    // 세션 포인트
$fp=!empty($_SESSION['_se_fp']) ? $_SESSION['_se_fp'] : 0; // fantasy-point 잔액

$m_pw      = isset($_POST['m_pw'])        ?     $_POST['m_pw']       : '';

if (!$idx) {
    $url    = $_SERVER['REQUEST_URI'];
    $msg    = '로그인 페이지로 이동합니다.';
    $url    = '/login/index.php?rtnUrl='. $url;
    alertReplace($msg, $url);
    exit;
}
try {
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
                            <h2>한도 설정</h2>
                        </div>
                        <form action="">
                            <div class="sub-content">
                                <div class="money-limit">
                                    <h3>캐시 구매 잔여 한도 내역</h3>
                                    <div class="limit-days">
                                        <p>월 현재 잔여 한도 - <span class="limit-money">500,000</span><span><img src="../images/ico_alert_small.png" alt="알림">매월 1일 초기화</span></p>
                                        <p>월 현재 잔여 한도 - <span class="limit-money">500,000</span><span><img src="../images/ico_alert_small.png" alt="알림">매일 오전 09:00 초기화</span></p>
                                    </div>
                                </div>
                                <div class="limit-input-wrap">
                                    <h3>FP 사용 한도 설정</h3>
                                    <div class="input-box limit-input">
                                        <label for="">누적한도 설정</label>
                                        <div class="limit-select">
                                            <section id="drop3" class="dropdown">
                                                <div class="select">
                                                    <div class="text">해당사항 없음</div>
                                                    <ul class="option-list">
                                                        <li class="option">해당사항 없음</li>
                                                        <li class="option">10,000</li>
                                                        <li class="option">15,000</li>
                                                        <li class="option">20,000</li>
                                                        <li class="option">25,000</li>
                                                        <li class="option">30,000</li>
                                                        <li class="option">35,000</li>
                                                        <li class="option">40,000</li>
                                                        <li class="option">45,000</li>
                                                        <li class="option">50,000</li>
                                                    </ul>
                                                </div>
                                            </section>
                                            <!-- 한도 설정 완료 후 <p>10,000</p> -->
                                            <span>FP</span>
                                        </div>
                                    </div>
                                    <div class="input-box limit-input">
                                        <label for="">초기화 시간</label>
                                        <div class="limit-select">
                                            <section id="drop4" class="dropdown">
                                                <div class="select">
                                                    <div class="text">해당사항 없음</div>
                                                    <ul class="option-list">
                                                        <li class="option">해당사항 없음</li>
                                                        <li class="option">6</li>
                                                        <li class="option">8</li>
                                                        <li class="option">10</li>
                                                        <li class="option">12</li>
                                                        <li class="option">14</li>
                                                        <li class="option">16</li>
                                                        <li class="option">18</li>
                                                        <li class="option">20</li>
                                                        <li class="option">22</li>
                                                        <li class="option">24</li>
                                                    </ul>
                                                </div>
                                            </section>
                                            <!-- 시간 설정 완료 후 <p>10,000</p> -->
                                            <span>시간</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-blue btn-6 mT50">저장</button>
                                <span class="save-alert save">정보 저장이 성공적으로 완료 되었습니다.</span>
                                <!-- <span class="save-alert error">정보 저장에 실패 하였습니다. 다시 시도하여 주시기 바랍니다..</span> -->

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
        © 2022 METAGAMES, Inc. All Rights Reserved.
    </footer>
</div>
</body>
</html>