<?php
include_once __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try{
    //트랜잭션
    $_mysqli->begin_transaction();

    //파라미터 정리
    $fp_limit = isset($_POST['limit_fp']) ? $_POST['limit_fp'] : 0;
    $time_reset = isset($_POST['reset_time']) ? $_POST['reset_time'] : 0;

    //태그제거
    $fp_limit = strip_tags($fp_limit);
    $time_reset = strip_tags($time_reset);

    $ip         = $_SERVER['REMOTE_ADDR'];

    $fp_limit = $_mysqli->real_escape_string($fp_limit);
    $time_reset = $_mysqli->real_escape_string($time_reset);

    $query = "
        UPDATE members SET m_fp_limit = '{$fp_limit}' , reset_time='{$time_reset}' where m_idx='{$idx}'
    ";

    $result = $_mysqli->query($query);

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