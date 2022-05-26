<?php
require __DIR__ .'/../_inc/config.php';

$m_num     = isset($_POST['m_num'])        ?     $_POST['m_num']       :0;
$price     = isset($_POST['price'])        ?     $_POST['price']       :0;
$fp     = isset($_POST['fp'])        ?     $_POST['fp']       :0;
$i_src = isset($_POST['i_src']) ? $_POST['i_src'] : '';
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$ip=$_SERVER['REMOTE_ADDR'];

//변수 정리
$msg    = '';

//변수 체크
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);

try{
    /*$sql = "SELECT COUNT(1) AS CNT FROM m_item WHERE m_idx = '{$idx}' and m_num = '{$m_num}'";
    $result1 = $_mysqli->query($sql);*/

   /* if($result1) {*/
        /*$arrayitem = $result1->fetch_array();
        $CNT = $arrayitem['CNT'];*/

        /*if ($CNT > 0) {
            $arrRtn['code'] = 501;
            $arrRtn['msg'] = "이미 구매한 아이템입니다";
            //alertBack($msg);
            echo json_encode($arrRtn);
            exit;
        } else {*/
            $query = " insert into  m_item
                            (m_idx, m_num, i_src)
                        VALUES
                            ('{$idx}','{$m_num}','{$i_src}')";
            $result = $_mysqli->query($query);

            $query2 = "insert into deposit_history
                    (dh_u_idx, dh_deposit,dh_amount,dh_paymethod,dh_pay_key,dh_content,dh_condition, dh_balance, dh_req_date, dh_res_date)
                    VALUES
                     ('{$idx}','0','-{$price}','0','Buy item', 'item', '1', '0',now(),now())";
            $result2 = $_mysqli->query($query2);

            $query3 = "UPDATE members SET m_fp_balance = m_fp_balance + '{$fp}' WHERE m_idx = '{$idx}'";
            $result3 = $_mysqli->query($query3);

            $quert5 = "SELECT * FROM members WHERE m_idx = '{$idx}'";
            $result5 = $_mysqli->query($quert5);
            $mem = $result5->fetch_array();
            $m_fp_balance = !empty($mem['m_fp_balance']) ? $mem['m_fp_balance'] : 0;


            /*$query3 = "UPDATE item SET i_status = 1 where i_num = '{$m_num}'";
            $result3 = $_mysqli->query($query3);*/
            $query4 = "insert into fantasy_point_history
                            (fph_m_idx, fph_content,fph_point,fph_balance,fph_trigger_type,created_at)
                            VALUES
                             ('{$idx}','Buy_item','{$price}',{$m_fp_balance},'item', now())";
            $result4 = $_mysqli->query($query4);

            if (!$result) {
                $arrRtn['code'] = 502;
                $arrRtn['msg'] = "에러 발생";
                echo json_encode($arrRtn);
                exit;
            } else {
                $arrRtn['code'] = 200;
                $arrRtn['msg'] = "해당 아이템을 구매하였습니다.";

            }
       /* }*/
   /* }*/
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