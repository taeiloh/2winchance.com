<?php
require_once __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스

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
                        <h3>아래 약관에 동의해주세요.</h3>
                        <div class="policy">
                            <p class="checkbox">
                                <input type="checkbox" class="" id="policy03" checked="checked">
                                <label for="policy03" class="">약관을 확인하였습니다.</label>
                            </p>
                            <div class="policy-txt scroll">
                                <p>
                                    회원탈퇴 시 주의사항 안내</br></br>
                                    회원 탈퇴 시 홈페이지 및 게임 접속이 제한되며, 클라이언트에 로그인 된 상태에서는 </br>
                                    신청하실 수 없습니다.
                                    회원 가입 시 입력하신 개인 정보 및 결제 정보 등은 즉시 파기되며 복구하실 수 없습니다 .</br>
                                    탈퇴 시 계정 내 구매한 모든 상품 및 화폐가 삭제되므로 탈퇴 전 잔여 화폐에 대한 환불을 신청해 주시기 바랍니다 . </br>
                                    회원 탈퇴를 하더라도 사용중인 소환사명을 즉시 재생성하실 수 없으면 최대 10 일 정도 기간이 소요될 수 있습니다 . </br>
                                    소셜 계정과 연결되어 있는 경우 본 절차는 회원 탈퇴 절차이며 라이엇 계정으로 업그레이드한 외부 계정을 분리하는 절차가 아닌 점 주의해 주시기 바랍니다 .</br>
                                    소셜 계정을 라이엇 계정으로 업그레이드한 이력이 있는 경우 회원 탈퇴 시 외부 계정을 통해 구매하셨던 모든 상품도 함께 삭제되므로 주의해 주시기 바랍니다 . </br>
                                    탈퇴 후 해당 외부 계정으로 라이엇 서비스에 다시 접속하시더라도 과거 상품들은 복구되지 않는 점 다시 한번 확인해 주시기 바랍니다
                                </p>
                            </div>
                        </div>
                        <button type="button" class="btn-blue btn-6" onclick="location.href='RemoveInfo.php'">다음</button>
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
<script type="text/javascript">
    var onloadCallback = function () {
        grecaptcha.render('html_element', {
            'sitekey': 'your_site_key'
        });
    };
</script>
</body>
</html>
