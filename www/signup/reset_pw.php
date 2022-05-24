<?php
//config
require __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디

//리퍼러 체크

//파라미터 정리
//p($_POST);
$m_pw      = isset($_POST['m_pw'])        ?     $_POST['m_pw']       : '';
$ip=$_SERVER['REMOTE_ADDR'];

//변수 정리
$msg    = '';

$pw         = password_hash($m_pw, PASSWORD_DEFAULT);

//변수 체크
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try {
    $sql = "update members SET m_pw = '{$pw}' where m_idx = '{$idx}'";
    $result2 = mysqli_query($_mysqli, $sql);

    if($result2){
    $arrRtn['code'] = 200;
        $arrRtn['msg']  = "비밀번호가 변경되었습니다.";
    }
    else{
        $arrRtn['code'] = 501;
        $arrRtn['msg']  = "비밀번호 변경에 실패하였습니다.";
        echo json_encode($arrRtn);
        exit;
    }

} catch (mysqli_sql_exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} catch (Exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} finally {
    echo json_encode($arrRtn);
}
