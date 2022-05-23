<?php
require __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$m_num     = isset($_POST['m_num'])        ?     $_POST['m_num']       :0;
$i_src     = isset($_POST['seleted_src'])        ?     $_POST['seleted_src']       :'';


//변수 정리
$msg    = '';

//변수 체크
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try{
    $sql = "UPDATE item SET main_item=0 ";
    $result = $_mysqli->query($sql);

    if($result) {
        $sql2 = "UPDATE item SET main_item=1 WHERE i_num = '{$m_num}'";
        $result1 = $_mysqli->query($sql2);

        if (!$result1) {
            $arrRtn['code'] = 502;
            $arrRtn['msg'] = "에러 발생";
            echo json_encode($arrRtn);
            exit;
        } else {
            $arrRtn['code'] = 200;
            $arrRtn['msg'] = "메인 엠블럼으로 저장하였습니다";

        }
    }


}catch (mysqli_sql_exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} catch (Exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} finally {
    echo json_encode($arrRtn);
}

?>