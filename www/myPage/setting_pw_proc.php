<?php
//config
require __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디


$m_pw  = isset($_POST['m_pw'])  ?     $_POST['m_pw'] : '';
$ip=$_SERVER['REMOTE_ADDR'];

$msg    = '';

$pw         = password_hash($m_pw, PASSWORD_DEFAULT);

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);

try {
    //트랜잭션
    $_mysqli->begin_transaction();

    //파라미터 정리
    $passwd = isset($_POST['m_pw'])   ? $_POST['m_pw']  : '';

//    if (empty($passwd)) {
//        $code           = 404;
//        $msg            = "비밀번호를 입력해 주세요";
//        throw new Exception($msg, $code);
//    }

    //비밀번호 확인
    $query = "
        SELECT * FROM members
        WHERE 1
           AND m_idx = '{$idx}'
    ";
    //p($query);
    $_result = $_mysqli->query($query);
    if ($_result) {
        $_dbTmp    = $_result->fetch_assoc();

        //비밀번호 비교
        if (password_verify($passwd, $_dbTmp['m_pw'])) {

            //성공
            $arrRtn['code']    = 200;
            $arrRtn['msg']     = "비밀번호가 일치합니다.";
        } else {
            //비밀번호 일치X
            $arrRtn['code']    = 404;
            $arrRtn['msg']     = "비밀번호가 일치하지 않습니다.";
        }
    }

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