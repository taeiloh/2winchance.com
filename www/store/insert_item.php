<?php
require __DIR__ .'/../_inc/config.php';

$m_num     = isset($_POST['m_num'])        ?     $_POST['m_num']       :0;
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스


//변수 정리
$msg    = '';

//변수 체크
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);

try{
    $sql = "SELECT COUNT(1) AS CNT FROM m_item WHERE m_idx = '{$idx}' and m_num = '{$m_num}'";
    $result1 = $_mysqli->query($sql);

    if($result1) {
        $arrayitem = $result1->fetch_array();
        $CNT = $arrayitem['CNT'];

        if ($CNT > 0) {
            $arrRtn['code'] = 501;
            $arrRtn['msg'] = "이미 구매한 아이템입니다";
            //alertBack($msg);
            echo json_encode($arrRtn);
            exit;
        } else {
            $query = " insert into  m_item
                            (m_idx, m_num)
                        VALUES
                            ('{$idx}','{$m_num}')";
            $result = $_mysqli->query($query);

            if (!$result) {
                $arrRtn['code'] = 502;
                $arrRtn['msg'] = "에러 발생";
                echo json_encode($arrRtn);
                exit;
            } else {
                $arrRtn['code'] = 200;
                $arrRtn['msg'] = "아이템 구매 성공";
            }
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