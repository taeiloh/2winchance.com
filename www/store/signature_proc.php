<?php
require_once __DIR__ .'/../_inc/config.php';
require_once __DIR__ .'/../libs/INIStdPayUtil.php';
$SignatureUtil = new INIStdPayUtil();

$price     = isset($_POST['price'])        ?     $_POST['price']       :0;


$mid = "INIpayTest";  // 가맹점 ID(가맹점 수정후 고정)
//인증
$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성

$orderNumber = $mid . "_" . $SignatureUtil->getTimestamp(); // 가맹점 주문번호(가맹점에서 직접 설정)


$cardNoInterestQuota = "11-2:3:,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
$cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
//###################################
// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
//###################################
$mKey = $SignatureUtil->makeHash($signKey, "sha256");

$params = array(
    "oid" => $orderNumber,
    "price" => $price,
    "timestamp" => $timestamp
);
$sign = $SignatureUtil->makeSignature($params, "sha256");

    $arrRtn['code'] = 200;
    $arrRtn['oid'] = $orderNumber;
    $arrRtn['price'] = $price;
    $arrRtn['timestamp'] = $timestamp;
    $arrRtn['sign'] = $sign;
    $arrRtn['mKey'] = $mKey;


    echo json_encode($arrRtn);
?>