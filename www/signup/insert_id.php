<?php
//config
require __DIR__ .'/../_inc/config.php';


//리퍼러 체크

//파라미터 정리
//p($_POST);
$m_id      = isset($_POST['m_id'])        ?     $_POST['m_id']       : '';
$m_pw      = isset($_POST['m_pw'])        ?     $_POST['m_pw']       : '';
/*$m_sns_type      = isset($_POST['m_sns_type'])        ?     $_POST['m_sns_type']       : '';
$m_sns_id      = isset($_POST['m_sns_id'])        ?     $_POST['m_sns_id']       : '';*/
$m_tel = isset($_POST['m_tel'])        ?     $_POST['m_tel']       : '';
$m_birthday = isset($_POST['m_birthday'])        ?     $_POST['m_birthday']       : '';

$m_birthday2 = intval($m_birthday);

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
    check_word($m_id);
    //아이디 중복 확인
    $query  = "
            SELECT COUNT(1) AS CNT FROM members
            WHERE 1=1
                AND m_id = '{$m_id}' and m_name is NOT NULL
        ";
    //p($query);
    $result = $_mysqli->query($query);
    if ($result) {
        $_arrMembers    = $result->fetch_array();
        $cnt            = $_arrMembers['CNT'];

        if ($cnt > 0) {
            $arrRtn['code'] = 501;
            $arrRtn['msg']  = "이미 가입된 계정입니다.\n해당 계정으로 로그인 혹은 다른 이메일로 회원 가입을 진행해 주세요.";
            //alertBack($msg);
            echo json_encode($arrRtn);
            exit;
        }
    }

    /*$query  = "
            SELECT COUNT(1) AS CNT FROM members
            WHERE 1=1
                AND m_id = '{$m_id}' and m_name is null
        ";
    //p($query);
    $result = $_mysqli->query($query);
    if ($result) {
        $_arrMembers    = $result->fetch_array();
        $cnt            = $_arrMembers['CNT'];

        if ($cnt > 0) {
            $sql2  = " update  members set
                m_pw='{$pw}',
                m_ip='{$ip}', 
                m_enter_datetime=now()
                where m_id='{$m_id}'
                ";
            //p($sql);
            $result2 = mysqli_query($_mysqli, $sql2);
            if (!$result2) {
                $arrRtn['code'] = 503;
                $arrRtn['msg']  = "이미 있는 아이디입니다";
                echo json_encode($arrRtn);
                echo $sql2;
                exit;
            }*/


    $query1  = "
            SELECT m_idx FROM members
            WHERE 1=1
                AND m_id = '{$m_id}' and m_name is null and m_sns_id is null";

    //p($query);
    $result1 = $_mysqli->query($query1);
    $_arrMembers1    = $result1->fetch_array();
    $m_idx            = $_arrMembers1['m_idx'];
    if($m_idx){
        $arrRtn['code'] = 201;
        $arrRtn['id'] = $m_idx;
        $arrRtn['msg']  = "이메일 인증이 안된 계정입니다.\n다음 페이지에서 이메일 인증버튼을 눌러주세요.";
        //alertBack($msg);
        echo json_encode($arrRtn);
        exit;
    }else{
        //변수 체크
        $sql  = " insert into  members
                (m_id, m_pw, m_ip, m_tel, m_b_year, m_enter_datetime)
            VALUES
                ('{$m_id}','{$pw}','{$ip}','{$m_tel}','{$m_birthday2}', now())";
        //p($sql);
        $result = mysqli_query($_mysqli, $sql);
        if (!$result) {
            $arrRtn['code'] = 502;
            $arrRtn['msg']  = "에러 발생";
            echo json_encode($arrRtn);
            exit;
        }
        $m_idx   =   $_mysqli->insert_id;

        /*}*/
    }
    //회원 정보 가져오기
    $query = "
        SELECT 
            *
        FROM members
        WHERE 1=1
            AND m_idx  = '{$m_idx}'
    ";

    $result = $_mysqli->query($query);

    if ($result) {
        $arrRtn['code'] = 200;
        $arrRtn['id'] = $m_idx;
        $arrRtn['msg']  = "이메일 전송 성공";
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
