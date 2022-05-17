<?php
//config
require __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스

//리퍼러 체크

//파라미터 정리
//p($_POST);
$pw      = isset($_POST['u_pw'])        ?     $_POST['u_pw']       : '';
$ip=$_SERVER['REMOTE_ADDR'];

//변수 정리
$msg    = '';

//변수 체크
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try {
    $query = "SELECT * FROM members WHERE m_idx = '{$idx}'";
    $result = $_mysqli->query($query);
    $_arrMembers = $result->fetch_array();
    $m_pw = !empty($_arrMembers['m_pw']) ? $_arrMembers['m_pw'] : '';

    if(password_verify($pw, $m_pw)){
        $arrRtn['code'] = 200;
        $arrRtn['id'] = $idx;
        $arrRtn['msg'] = "비밀번호 일치";
    }
    else{
        $arrRtn['code'] = 502;
        $arrRtn['msg'] = "비밀번호가 불일치 합니다";
        echo json_encode($arrRtn);
        exit;
    }
} catch (Exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();
} finally {
    echo json_encode($arrRtn);
}