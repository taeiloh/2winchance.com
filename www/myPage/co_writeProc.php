<?php
include_once __DIR__ .'/../_inc/config.php';

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try {

    //트랜잭션
    $_mysqli->begin_transaction();

    //파라미터 정리
    $cu_topic   = isset($_POST['cu_topic'])     ?   $_POST['cu_topic']      : '';
    $cu_mail    = isset($_POST['cu_mail'])      ?   $_POST['cu_mail']       : '';
    $cu_subject = isset($_POST['cu_subject'])   ?   $_POST['cu_subject']    : '';
    $cu_message = isset($_POST['cu_message'])   ?   $_POST['cu_message']    : '';
    //$cu_status  = isset($_POST['cu_status'])    ?   $_POST['cu_status']     : '';
    $cu_response_id = isset($_POST['cu_response_id'])  ?   $_POST['cu_response_id'] : '';

    //태그제거
    $cu_topic = strip_tags($cu_topic);
    $cu_mail = strip_tags($cu_mail);
    $cu_subject = strip_tags($cu_subject);
    $cu_message = strip_tags($cu_message);
    //$cu_status = strip_tags($cu_status);
    //$cu_response_id = strip_tags($cu_response_id);


    //변수정리
    //$ip         = $_SERVER['REMOTE_ADDR'];
    $thread     = 1000;
    $nowdate    = date('Y-m-d-h-i-s');
    //DB 변수
    $cu_topic        = $_mysqli->real_escape_string($cu_topic);
    $cu_mail         = $_mysqli->real_escape_string($cu_mail);
    $cu_subject      = $_mysqli->real_escape_string($cu_subject);
    $cu_message      = $_mysqli->real_escape_string($cu_message);
    //$cu_status       = $_mysqli->real_escape_string($cu_status);
    $cu_response_id  = $_mysqli->real_escape_string($cu_response_id);

    $query="
        INSERT INTO contactus
            (cu_topic, cu_mail, cu_subject, cu_message, cu_response ,cu_req_date, cu_response_id,cu_status)
        VALUES
            ('{$cu_topic}', '{$cu_mail}', '{$cu_subject}', '{$cu_message}', '', NOW(), '{$cu_response_id}', 0 )
    
    ";

    $_result = $_mysqli->query($query);
    //print $query; //주석 필수

    if (!$_result) {
        $code = 501;
        $msg = "등록 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
        throw new mysqli_sql_exception($msg, $code);
    }

    //커밋
    $_mysqli->commit();


    //성공
    $arrRtn['code']    = 200;
    $arrRtn['msg']     = "등록되었습니다.";

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();
    $arrRtn['code']    = $e->getCode();
    $arrRtn['msg']     = $e->getMessage();

} catch (Exception $e) {
    $_mysqli->rollback();
    $arrRtn['code']    = $e->getCode();
    $arrRtn['msg']     = $e->getMessage();

} finally {
    echo json_encode($arrRtn);
}