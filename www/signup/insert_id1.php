<?php
//config
require __DIR__ .'/../_inc/config.php';


//리퍼러 체크

//파라미터 정리
//p($_POST);

$m_id      = isset($_POST['m_id'])        ?     $_POST['m_id']       : '';
$m_sns_id      = isset($_POST['m_sns_id'])        ?     $_POST['m_sns_id']       : '';
$m_name      = isset($_POST['m_name'])        ?     $_POST['m_name']       : '';
/*$m_b_year      = isset($_POST['m_b_year'])        ?     $_POST['m_b_year']       : '';*/
/*$m_tel = isset($_POST['m_tel'])        ?     $_POST['m_tel']       : '';*/
$sex      = isset($_POST['sex'])        ?     $_POST['sex']       : '';
$ip=$_SERVER['REMOTE_ADDR'];




//변수 정리
$msg    = '';


//변수 체크
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try {

    check_word($m_name);

    $query  = "
            SELECT COUNT(1) AS CNT FROM members
            WHERE 1=1
                AND m_name = '{$m_name}'
        ";
    //p($query);
    $result = $_mysqli->query($query);
    if ($result) {
        $_arrMembers    = $result->fetch_array();
        $cnt            = $_arrMembers['CNT'];

        if ($cnt > 0) {
            $arrRtn['code'] = 501;
            $arrRtn['msg']  = "이미 가입된 닉네임입니다.";
            //alertBack("이미 가입된 닉네임입니다.");
            echo json_encode($arrRtn);
            exit;
        }

    }

    if($m_id!="") {
        //변수 체크
        $sql = " update members set    
                m_name='{$m_name}',
                    sex='{$sex}'
            where 1=1
                and m_id='{$m_id}'
                ";
    }else{
        //변수 체크
        $sql = " update members set    
                m_name='{$m_name}',
                    sex='{$sex}'
            where 1=1
                and m_sns_id='{$m_sns_id}'
                ";
    }
    //echo $sql;
    //exit;
    $result = mysqli_query($_mysqli, $sql);
    if (!$result) {
        $arrRtn['code'] = 502;
        echo $sql;
        exit;
    }


    $arrRtn['code'] = 200;
    $arrRtn['msg']  = "성공";

    

} catch (mysqli_sql_exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} catch (Exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} finally {
    echo json_encode($arrRtn);
}
