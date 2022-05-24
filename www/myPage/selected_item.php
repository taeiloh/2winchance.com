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
    $query = "SELECT count(*) FROM m_item WHERE m_num = '{$m_num}'";
    $result2 = mysqli_query($_mysqli, $query);
    $count_num = mysqli_fetch_row($result2);
    $cnt = $count_num[0];

    if($cnt > 0) {
        $sql = "UPDATE m_item SET main_emblem=0 WHERE m_idx = '{$idx}'";
        $result = $_mysqli->query($sql);

        if ($result) {
            $sql2 = "UPDATE m_item SET main_emblem=1 WHERE m_idx = '{$idx}' and m_num = '{$m_num}'";
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
    }
    else{
        $arrRtn['code'] = 503;
        $arrRtn['msg'] = "구매하지 않은 엠블럼입니다";
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