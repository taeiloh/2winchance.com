<?php
extract($_POST);

$mid  = 'INIiasTest';    // 부여받은 MID(상점ID) 입력(영업담당자 문의)

if ($_REQUEST["resultCode"] === "0000") {
    $data = array(
        'mid' => $mid,
        'txId' => $txId
    );

    $post_data = json_encode($data);

// curl 통신 시작
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_REQUEST["authRequestUrl"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);


// -------------------- 결과 수신 -------------------------------------------

    $response = trim($response);
    $response = ltrim($response,'{');
    $response = rtrim($response, '}');
    $response = str_replace(':', '',$response);
    $response = str_replace(',', '',$response);
    $response = str_replace('""','"',$response);

    echo $response;
    $str_arr = explode('"',$response);
    $userName = $str_arr[20];
    $userBirthday = $str_arr[24];
    $userPhone = $str_arr[6];

}else {   // resultCode===0000 아닐경우 아래 인증 실패를 출력함
    echo 'resultCode : '.$_REQUEST["resultCode"]."<br/>";
    echo 'resultMsg : '.$_REQUEST["resultMsg"]."<br/>";
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
<script>
    $(function(){

        var f= document.forms.popupForm;
        opener.name = "id_check.php";
        f.target = opener.name;
        f.submit();
        self.close();
    })
</script>
<form name="popupForm" action="id_return.php" method="post">
    <input type="text" name="resultCode" value="<?=$_REQUEST["resultCode"]?>">
    <input type="text" name="userName" value="<?=$userName?>">
    <input type="text" name="userPhone" value="<?=$userPhone?>">
    <input type="text" name="userBirthday" value="<?=$userBirthday?>">
</form>
</body>
</html>
