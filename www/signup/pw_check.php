<?php
// config
require_once __DIR__ .'/../_inc/config.php';


try {

} catch (Exception $e) {
    p($e);
}

$mid ='INIiasTest';                            // 테스트 MID 입니다. 계약한 상점 MID 로 변경 필요
$apiKey ='TGdxb2l3enJDWFRTbTgvREU3MGYwUT09';   // 테스트 MID 에 대한 apiKey
$mTxId ='test_20210625';
$reqSvcCd ='01';

// 등록가맹점 확인
$plainText1 = hash("sha256",(string)$mid.(string)$mTxId.(string)$apiKey);
$authHash = $plainText1;

$userName = '홍길동';            // 사용자 이름
$userPhone = '01011112222';    // 사용자 전화번호
$userBirth ='19800101';        // 사용자 생년월일

$flgFixedUser = 'N';           // 특정사용자 고정시 Y

if($flgFixedUser=="Y")
{
    $plainText2 = hash("sha256",(string)$userName.(string)$mid.(string)$userPhone.(string)$mTxId.(string)$userBirth.(string)$reqSvcCd);
    $userHash = $plainText2;
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
<form name="saForm">
    <input type="hidden" name="mid" value="<?php echo $mid ?>">
    <input type="hidden" name="reqSvcCd" value="<?php echo $reqSvcCd ?>">
    <input type="hidden" name="mTxId" value="<?php echo $mTxId ?>">
    <input type="hidden" name="authHash" value="<?php echo $authHash ?>">
    <input type="hidden" name="flgFixedUser" value="<?php echo $flgFixedUser ?>">
    <input type="hidden" name="userName" value="<?php echo $userName ?>">
    <input type="hidden" name="userPhone" value="<?php echo $userPhone ?>">
    <input type="hidden" name="userBirth" value="<?php echo $userBirth ?>">
    <input type="hidden" name="userHash" value="<?php echo $userHash ?>">
    <input type="hidden" name="directAgency" value="">

    <input type="hidden" name="successUrl" value="https://<?=$_SERVER['SERVER_NAME']?>/signup/pw_checksuccess.php">
    <input type="hidden" name="failUrl" value="https://<?=$_SERVER['SERVER_NAME']?>/signup/pw_checksuccess.php">
    <!-- successUrl/failUrl 은 분리하여도 됩니다. !-->

</form>

<form id="loginFrm" name="loginFrm" method="post" action="id_return.php">
    <input type="hidden" name="url" id="url" value="id_return.php"/>
</form>
<div id="wrap" class="member">
    <!--content-->
    <div id="content">
        <!--sec-01-->
        <h1 class="logo"><a href="/main/index.php"><img src="../images/logo.png" alt="METAGAMES"></a></h1>
        <section class="sec sec-01">
            <div class="inner">
                <div class="title">
                    <ul class="step">
                        <li></li>
                        <li class="active"></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <h2>비밀번호 재설정</h2>
                </div>
                <div class="sub-content">
                    <h3>본인인증</h3>
                    <p class="sub-txt">
                        비밀번호 재설정을 위한 본인인증이 필요합니다.<br>
                        본인인증 시 제공되는 정보는 해당 인증기관에서<br>
                        직접 수집하며, 인증 이외의 용도로 이용 또는<br>
                        저장하지 않습니다.
                    </p>
                    <div class="confirm-wrap">
                        <div class="confirm-box">
                            <div>
                                <h4>핸드폰 인증</h4>
                                <p>본인 명의의 핸드폰으로 인증</p>
                            </div>
                            <button type="button" class="btn-blue btn-6" onclick="callSa()">인증하기</button>
                        </div>
                        <div class="confirm-box mT10">
                            <div>
                                <h4>신용/ 체크카드 인증</h4>
                                <p>본인 명의의 신용/체크카드로 인증</p>
                            </div>
                            <button type="button" class="btn-blue btn-6">인증하기</button>
                        </div>
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
</div>
</body>
<script type="text/javascript">


    function callSa()
    {
        let window = popupCenter();
        if(window != undefined && window != null)
        {
            document.saForm.setAttribute("target", "sa_popup");
            document.saForm.setAttribute("post", "post");
            document.saForm.setAttribute("action", "https://sa.inicis.com/auth");
            document.saForm.submit();
        }
    }

    function popupCenter() {
        let _width = 400;
        let _height = 620;
        var xPos = (document.body.offsetWidth/2) - (_width/2); // 가운데 정렬
        xPos += window.screenLeft; // 듀얼 모니터일 때
        openWin = window.open("", "sa_popup", "width="+_width+", height="+_height+", left="+xPos+", menubar=yes, status=yes, titlebar=yes, resizable=yes");
        return openWin;
    }
    function abcd(){
        opener.parent.location='이동할페이지?넘길변수=넘길값';
        window.close();
    }

</script>
</html>
