<?php
// config


require_once __DIR__ .'/../libs/INIStdPayUtil.php';
require_once __DIR__ .'/../libs/HttpClient.php';

require_once __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스

try {

    $util = new INIStdPayUtil();
    $mid 			= $_REQUEST["mid"];     					// 가맹점 ID 수신 받은 데이터로 설정
    $signKey 		= "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; 		// 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
    $timestamp 		= $util->getTimestamp();   					// util에 의해서 자동생성
    $charset 		= "UTF-8";        							// 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)
    $format 		= "JSON";        							// 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)

    $authToken 		= $_REQUEST["authToken"];   				// 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)
    $authUrl 		= $_REQUEST["authUrl"];    					// 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)
    $netCancel 		= $_REQUEST["netCancelUrl"];   				// 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

    $mKey 			= hash("sha256", $signKey);					// 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)

    //#####################
    // 2.signature 생성
    //#####################
    $signParam["authToken"] 	= $authToken;  	// 필수
    $signParam["timestamp"] 	= $timestamp;  	// 필수
    // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
    $signature = $util->makeSignature($signParam);


    //#####################
    // 3.API 요청 전문 생성
    //#####################
    $authMap["mid"] 			= $mid;   		// 필수
    $authMap["authToken"] 		= $authToken; 	// 필수
    $authMap["signature"] 		= $signature; 	// 필수
    $authMap["timestamp"] 		= $timestamp; 	// 필수
    $authMap["charset"] 		= $charset;  	// default=UTF-8
    $authMap["format"] 			= $format;  	// default=XML
    $httpUtil = new HttpClient();

    $authResultString = "";
    $httpUtil->processHTTP($authUrl, $authMap);
    $authResultString = $httpUtil->body;


    $resultMap = json_decode($authResultString, true);


    $query  = "
    SELECT *  FROM members
    WHERE 1=1
        AND m_idx = '{$idx}'
        ";
    //p($query);
    $result = $_mysqli->query($query);

    if (!$result) {

    }
    $_arrMembers    = $result->fetch_array();
    $m_deposit    = !empty($_arrMembers['m_deposit']) ? $_arrMembers['m_deposit'] : 0;
    $m_limit_deposit    = !empty($_arrMembers['m_limit_deposit']) ? $_arrMembers['m_limit_deposit'] : 0;

    $dh_deposit = !empty($resultMap["TotPrice"]) ? $resultMap["TotPrice"] : "";
    $dh_amount = !empty($resultMap["goodsName"]) ? $resultMap["goodsName"] : "";
    $dh_amount = (int)str_replace('C','', $dh_amount);
    $dh_pay_key = !empty($resultMap["tid"]) ? $resultMap["tid"] : "";
    $dh_content = !empty($resultMap["resultMsg"]) ? $resultMap["resultMsg"] : "";
    $dh_pay_key = !empty($resultMap["tid"]) ? $resultMap["tid"] : "";

    if($m_limit_deposit != 0){

    }

    $sql  = " insert into  deposit_history
        (dh_u_idx, dh_deposit, dh_amount, dh_paymethod ,dh_pay_key, dh_content, dh_condition,dh_balance,  dh_req_date)
    VALUES
        ('{$idx}','{$dh_deposit}','{$dh_amount}',1,'{$dh_pay_key}', '{$dh_content}',1 , $m_deposit,  now())";
    //echo $sql;
    //exit;
    $result1 = mysqli_query($_mysqli, $sql);
    if (!$result1) {
        $arrRtn['code'] = 502;
        $arrRtn['msg']  = "에러 발생";
        echo json_encode($arrRtn);
        exit;
    }else{
        $sql = " update members set    
            m_deposit=m_deposit+{$dh_amount}
            where 1=1
                and m_idx='{$idx}'
        ";
        $result2 = mysqli_query($_mysqli, $sql);
        if (!$result2) {
            $arrRtn['code'] = 502;
            echo $sql;
            exit;
        }
    }
    //echo $sql;
//exit;
    $query  = "
        SELECT * FROM members
        WHERE 1=1
            AND m_idx = '{$idx}'
        LIMIT 1
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if ($result) {
        $_dbAdmins = $result->fetch_assoc();
    }
    $_SESSION['_se_deposit']       = $_dbAdmins['m_deposit'];
} catch (Exception $e) {
    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
    echo $s;
} finally {
    header('Location:/main/');
}

?>