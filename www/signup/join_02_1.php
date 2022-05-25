<?php
// config
require_once __DIR__ .'/../_inc/config.php';

$resultCode       = !empty($_POST['resultCode'])           ? $_POST['resultCode']        : '';
$userBirthday       = !empty($_POST['userBirthday'])           ? $_POST['userBirthday']        : '';
$userBirthday = substr($userBirthday,0,4);
$userPhone = !empty($_POST['userPhone'])           ? $_POST['userPhone']        : '';

$year = date("Y");

if($resultCode==""){
    alertBack("잘 못 된 접근 입니다.");
}

if($userBirthday and $userPhone) {
    $age = $year - $userBirthday;
    $query = "SELECT COUNT(*) FROM members WHERE m_tel = '{$userPhone}'";
    $Result = $_mysqli->query($query);
    $usercnt = mysqli_fetch_row($Result);
    $cnt = $usercnt[0];
}

if($age < 18)
{
    $action="../main/";
}else if($cnt > 0)
{
    $action="../signup/id_check.php";
}else{
    $action="join_02_2.php";
}


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
<form id="loginFrm" name="loginFrm" method="post" action="<?=$action?>">
    <input type="hidden" name="userPhone" id="userPhone" value="<?=$userPhone?>"/>
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
                        </p>
                        <button type="submit" class="btn-blue btn-6" onclick="next()" >다음</button>
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
<script type="text/javascript">
    function next(){

        if((<?=$age?>)<18){
            alert("만18세 미만은 이용하실 수 없습니다.");
        }
        if((<?=$cnt?>)>0){
            alert("해당 휴대폰번호로 가입된 계정이 있습니다.");
        }
    }
</script>
</body>
</html>
