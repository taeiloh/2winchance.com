<?php
//config
require_once __DIR__ . '/../_inc/config.php';

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try {
    //파라미터 정리
    //p($_POST['carArr']);
    $type       = !empty($_POST['type'])           ? strtoupper($_POST['type'])         : '';
    $sns_id     = !empty($_POST['sns_id'])         ? $_POST['sns_id']                   : 0;

    //세션
    $mem_seq     = SE_SEQ;
    $mem_name    = SE_NM;

    //변수 정리
    $ip         = IP;

    //
    $query  = "
        SELECT
            COUNT(1) AS CNT
        FROM MEMBERS
        WHERE 1 
            AND m_sns_type = '{$type}'
            AND m_sns_id  = {$sns_id}
    ";
    $result = $_mysqli->query($query);
    if (!$result) {
        $arrRtn['code'] = 501;
        $arrRtn['msg']  = "error 1";
        p($query);
    }
    $db     = $result->fetch_assoc();
    $cnt    = $db['CNT'];

    //아이디가 1개인 경우 로그인 처리
    if ($cnt == 1) {
        //회원 정보 확인
        $query  = "
            SELECT
                *
            FROM MEMBERS
            WHERE 1 
                AND m_sns_type = '{$type}'
                AND m_sns_id = {$sns_id}
            LIMIT 1
        ";
        $result = $_mysqli->query($query);
        if (!$result) {
            $arrRtn['code'] = 502;
            $arrRtn['msg']  = "조회 오류가 발생했습니다.\n관리자에게 문의해 주세요.";
            p($query);
        }
        $db      = $result->fetch_assoc();
        $db_seq  = !empty($db['SEQ'])       ? $db['SEQ']          : 0;
        $db_id   = !empty($db['USR_ID'])     ? $db['USR_ID']      : '';
        $db_nm   = !empty($db['USR_NM'])     ? $db['USR_NM']      : '';

        //세션
        $_SESSION['SE_SEQ']     = $db_seq;
        $_SESSION['SE_ID']      = $db_id;
        $_SESSION['SE_NM']      = $db_nm;
    }

    //성공
    $arrRtn['code'] = 200;
    $arrRtn['cnt']  = (int) $cnt;
    $arrRtn['msg']  = "아이디 중복 확인";

} catch (mysqli_sql_exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} catch (Exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} finally {
    echo json_encode($arrRtn);
}