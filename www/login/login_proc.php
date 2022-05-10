<?php
//config
include_once __DIR__.'/../_inc/config.php';

//변수 정리
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);


try{
    //파라미터 정리
    $m_id        = isset($_POST['m_id'])        ?   $_POST['m_id']     : '';
    $m_pw        = isset($_POST['m_pw'])        ?   $_POST['m_pw']     : '';

    //필수 파라미터 체크
    if(empty($m_id) || empty($m_pw)) {
        $code       = 501;
        $msg        = '필수 항목을 입력해 주세요';
        throw new Exception($msg, $code);
    }

    //trim
    $m_id    = trim($m_id);
    $m_pw    = trim($m_pw);

    //escape
    $m_id    = $_mysqli->real_escape_string($m_id);
    $m_pw    = $_mysqli->real_escape_string($m_pw);

    //DB
    $query  = "
        SELECT * FROM members
        WHERE 1=1
            AND m_id = '{$m_id}'
        LIMIT 1
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if ($result) {
        $_dbAdmins = $result->fetch_assoc();

        //비밀번호 확인
        if (password_verify($m_pw, $_dbAdmins['m_pw'])) {
            //승인여부 체크

            //세션 생성
            $_SESSION['_se_idx']        = $_dbAdmins['m_idx'];
            $_SESSION['_se_id']         = $_dbAdmins['m_id'];
            $_SESSION['_se_name']       = $_dbAdmins['m_name'];

            //성공
            $arrRtn['code']    = 200;
            $arrRtn['msg']     = "로그인 성공하였습니다";
            echo json_encode($arrRtn);
            exit;

        } else {
            $code    = 502;
            $msg     = "아이디와 비밀번호가 일치하지 않습니다.\n다시 확인 후 시도해 주세요.";
            throw new mysqli_sql_exception($msg, $code);
        }
    } else {
        $code    = 503;
        $msg     = "로그인 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
        throw new mysqli_sql_exception($msg, $code);
    }

} catch (mysqli_sql_exception $e) {
    $arrRtn['code']    = $e->getCode();
    $arrRtn['msg']     = $e->getMessage();
    echo json_encode($arrRtn);

} catch (Exception $e) {
    $arrRtn['code']    = $e->getCode();
    $arrRtn['msg']     = $e->getMessage();
    echo json_encode($arrRtn);

}