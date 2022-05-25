<?php
// config
require_once __DIR__ .'/../_inc/config.php';

$resultCode       = !empty($_POST['resultCode'])           ? $_POST['resultCode']        : '';
$userName       = !empty($_POST['userName'])           ? $_POST['userName']        : '';
$userPhone = !empty($_POST['userPhone'])           ? $_POST['userPhone']        : '';
$userBirthday = !empty($_POST['userBirthday'])           ? $_POST['userBirthday']        : '';

try {

    $query = "SELECT * FROM members WHERE m_tel = {$userPhone}";
    $result = $_mysqli->query($query);
    $_arrMembers = $result->fetch_array();
    $u_id = !empty($_arrMembers['m_id']) ? $_arrMembers['m_id'] : '';
    $sns_id = !empty($_arrMembers['m_sns_id']) ? $_arrMembers['m_sns_id'] : '';
    $sns_type = !empty($_arrMembers['m_sns_type']) ? $_arrMembers['m_sns_type'] : '';

} catch (Exception $e) {
    p($e);
}
?>
<!doctype html>
<html lang="ko">
<head>
    <?php
    // head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>
<?php
// config
require_once __DIR__ .'/../_inc/config.php';


try {

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

<!--//head-->

<body>
<form id="loginFrm" name="loginFrm" method="post" action="../login/index.php">
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
                        <h2>계정 생성</h2>
                    </div>
                    <div class="sub-content">
                        <h3>본인 확인</h3>
                        <p class="sub-txt">
                            본인 인증이 완료 되었습니다.
                            <?php
                            if($u_id || $sns_id)
                            {
                                if($u_id){?>
                                    <?=$userName?>님의 계정은 다음과 같습니다<br>
                                    <?=$u_id?>
                                    <?php
                                }else if($sns_id){?>
                                    <?=$userName?>님은 <br>
                                    <?=$sns_type?>계정으로 가입되어있습니다.<br>
                                    <?php
                                }else{?>
                                    등록된 계정이 없습니다.<br>
                                    <?php
                                }
                            }else
                            {?>
                                <?=$userName?> 이름으로 <br>
                                등록된 계정이 없습니다.<br>
                                <?php
                            }?>
                        </p>
                        <button type="submit" class="btn-blue btn-6" >다음</button>
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
</form>
</body>
</html>
