<?php

// -------------------- 인증 수신 -------------------------------------------

extract($_POST);

echo '<인증결과내역>'."<br/><br/>";
echo 'resultCode : '.$_REQUEST["resultCode"]."<br/>";
echo 'resultMsg : '.$_REQUEST["resultMsg"]."<br/>";
echo 'authRequestUrl : '.$_REQUEST["authRequestUrl"]."<br/>";
echo 'txId : '.$_REQUEST["txId"]."<br/><br/><br/>";

$mid ='INIiasTest';    // 테스트 MID 입니다. 계약한 상점 MID 로 변경 필요
 
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

echo '<승인결과내역>'."<br/><br/>"; 
echo $response;

}else {   //  인증이 resultCode===0000 아닐경우 아래 인증 실패를 출력함
echo 'resultCode : '.$_REQUEST["resultCode"]."<br/>";
echo 'resultMsg : '.$_REQUEST["resultMsg"]."<br/>";

}
  
?>