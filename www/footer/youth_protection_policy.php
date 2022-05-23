<?php
// config
require_once __DIR__ .'/../_inc/config.php';



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


<!--//head-->

<body>
<div id="wrap" class="member">
    <!--header-->
    <header id="header">
        <?php
        //header
        require_once __DIR__ .'/../common/header.php';
        ?>
    </header>
    <!--//header-->

    <!--container-->
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="../main/"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
        <section class="sec sec-01">
            <div class="inner maintenance policy-page">
                <div class="title">
                    <h2>청소년 보호정책</h2>
                </div>
                <div class="sub-content">
                    <p class="sub-txt">
                        주)주식회사 메타록 (이하 “회사”라 함)는 청소년이 건전한 인격체로 성장할 수 있도록 하기 위하여 정보통신망이용촉진 및 정보보호 등에 관 한 법률 및 청소년보호법에 근거하여 청소년 보호정책을 수립, 시행하고 있습니다. 회사는 방송통신심의위원회의 정보통신에 관한 심의규정 및 청소년보호법상의 청소년유해매체물 심의기준 등에 따라 19세미만의 청소년들이 유해정보에 접근할 수 없도록 방지하고 있는 바, 본 청소년 보호정책을 통하여 회사가 청소년보호를 위해 어떠한 조치를 취하고 있는지 알려드립니다.

                    </p>
                    <h2 class="mT50">제 1조수집하는 개인정보의 항목 및 수정방법</h2>
                    <h2 class="mT50">제 2조개인정보의 수정 및 이용목적 </h2>
                    <h2 class="mT50">제 3조개인정보의 공유 및 제공 </h2>
                    <h3 class="T10 mT50">제 1조 유해정보에 대한 청소년접근제한 및 관리조치 </h3>
                    <p class="sub-txt">회사는 청소년이 아무런 제한장치 없이 청소년 유해정보에 노출되지 않도록 청소년유해매체물에 대해서는 별도의 인증장치를 마련, 적용하며 청소년 유해정보가 노출되지 않기 위한 예방차원의 조치를 강구합니다.</p>
                    <h3 class="T10 mT50">제 2 조 유해정보로부터의 청소년보호를 위한 업무 담당자 교육 시행 </h3>
                    <p class="sub-txt">회사는 정보통신업무 종사자를 대상으로 청소년보호 관련 법령 및 제재기준, 유해정보 발견 시 대처방법, 위반사항 처리에 대한 보고절차 등을 교육하고 있습니다.</p>
                    <h3 class="T10 mT50">제 3조 유해정보로 인한 피해상담 및 고충처리</h3>
                    <p class="sub-txt">회사는 청소년 유해정보로 인한 피해상담 및 고충처리를 위한 전문인력을 배치하여 그 피해가 확산되지 않도록 하고 있습니다.</p>

                    <p class="sub-txt mT50">[시행일] 본 이용약관은 2022년 6월 1일부터 적용 받습니다. </p>
                </div>
            </div>
        </section>
        <!--//sec-01-->
        <!--//content-->
    </div>
    <!--//container-->

    <!--footer-->
    <footer id="footer">
        <?php
        //footer
        require_once __DIR__ .'/../common/footer.php';
        ?>
    </footer>
    <!--//footer-->
</div>
</body>
</html>