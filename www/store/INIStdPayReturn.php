<?php
// config


require_once __DIR__ .'/../libs/INIStdPayUtil.php';
require_once __DIR__ .'/../libs/HttpClient.php';

require_once __DIR__ .'/../_inc/config.php';
$idx=!empty($_GET['id']) ? $_GET['id'] : "";      // 세션 시퀀스
$query  = "
        SELECT * FROM members
        WHERE 1=1
            AND m_idx = '{$idx}'
        LIMIT 1
    ";
$result = $_mysqli->query($query);
$_dbAdmins = $result->fetch_assoc();
//비밀번호 확인

$_SESSION['_se_idx']        = $_dbAdmins['m_idx'];
$_SESSION['_se_id']         = $_dbAdmins['m_id'];
$_SESSION['_se_name']       = $_dbAdmins['m_name'];
$_SESSION['_se_deposit']       = $_dbAdmins['m_deposit'];
$_SESSION['_se_fp']         = $_dbAdmins['m_fp_balance'];

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
    //$dh_amount = (int)str_replace('C','', $dh_amount);
    $dh_pay_key = !empty($resultMap["tid"]) ? $resultMap["tid"] : "";
    $dh_content = !empty($resultMap["resultMsg"]) ? $resultMap["resultMsg"] : "";
    $dh_pay_key = !empty($resultMap["tid"]) ? $resultMap["tid"] : "";
    $ins_cash_type = !empty($resultMap["payMethod"]) ? $resultMap["payMethod"] : "";
    $ins_tid = !empty($resultMap["tid"]) ? $resultMap["tid"] : "";


    if($m_limit_deposit != 0){

    }
    $dh_amount1 = 0;
    switch ($dh_amount){
        case '100C' :
            $dh_amount1 = 100;
            break;
        case '200C' :
            $dh_amount1 = 200;
            break;
        case '500C' :
            $dh_amount1 = 500;
            break;
        case '웰컴팩' :
            $dh_amount1 = 100;
            break;
        case '아머 이건1' :
            $dh_amount1 = 210;
            break;
        case '아머 이건2' :
            $dh_amount1 = 230;
            break;
        case '아머 이건3' :
            $dh_amount1 = 3220;
            break;
        case '아머 이건4' :
            $dh_amount1 = 8050;
            break;
        case '보너스 팩' :
            $dh_amount1 = 8050;
            break;
        case '월 구독' :
            $dh_amount1 = 10;
            break;
    }


        $sql = " update members set    
            m_deposit=m_deposit+{$dh_deposit}
            where 1=1
                and m_idx='{$idx}'
        ";
        $result2 = mysqli_query($_mysqli, $sql);
        if (!$result2) {
            $arrRtn['code'] = 502;
            echo $sql;
            exit;
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
    $m_deposit= !empty($_dbAdmins['m_deposit']) ? $_dbAdmins['m_deposit'] : 0;
    $_SESSION['_se_deposit']       = $m_deposit;

    $sql  = " insert into  deposit_history
        (dh_u_idx, dh_deposit, dh_amount, dh_paymethod ,dh_cash_type,dh_pay_key, dh_content, dh_condition,dh_balance,  dh_req_date)
    VALUES
        ('{$idx}','{$dh_deposit}','{$dh_amount1}', 1,'{$ins_cash_type}','{$dh_pay_key}', '캐시 구매 완료',1 , '{$m_deposit}',  now())";
    //echo $sql;
    //exit;
    $result1 = mysqli_query($_mysqli, $sql);
    if (!$result1) {
        $arrRtn['code'] = 502;
        $arrRtn['msg']  = "에러 발생";
        echo $sql;
        echo json_encode($arrRtn);
        exit;
    }


} catch (Exception $e) {
    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
    echo $s;
} finally {
    header('Location:/main/');
}

?>