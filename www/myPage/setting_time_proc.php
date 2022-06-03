<?php
//config
require __DIR__ .'/../_inc/config.php';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$set_time=!empty($_POST['set_time']) ? $_POST['set_time'] : "";
date_default_timezone_set('Asia/Seoul');
//리퍼러 체크

//파라미터 정리
//p($_POST);

//변수 정리
$msg    = '';
$today = date('Y-m-d h:i:s.n', time());
$set_date = date('Y-m-d h:i:s.n',strtotime("+".$set_time." day",strtotime($today)));

//변수 체크
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try {
    $query  = "UPDATE members SET set_time = '{$set_date}' where m_idx='{$idx}'";
    //p($query);
    $result = $_mysqli->query($query);

    if(!$result)
    {
        $arrRtn['code'] = 501;
        $arrRtn['msg']  = "제한기간 설정 불가";
        echo json_encode($arrRtn);
        exit;
    }
    else{
        $arrRtn['code'] = 200;
        $arrRtn['msg']  = "본인 요청으로 게임입장 제한기간 설정에 따라 로그인이 제한 되었습니다. 설정기간 후 로그인이 가능합니다";
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
