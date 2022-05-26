<?php
//config
require __DIR__ .'/../_inc/config.php';


//리퍼러 체크

//파라미터 정리
//p($_POST);

$m_sns_type      = isset($_POST['m_sns_type'])        ?     $_POST['m_sns_type']       : '';
$m_sns_id      = isset($_POST['m_sns_id'])        ?     $_POST['m_sns_id']       : '';
$userPhone = isset($_POST['userPhone'])        ?     $_POST['userPhone']       : '';
$userBirthday = isset($_POST['$userBirthday'])        ?     $_POST['$userBirthday']       : '';

$ip=$_SERVER['REMOTE_ADDR'];



//변수 정리
$msg    = '';

//변수 체크
$arrRtn     = array(
    'code'  => 500,
    'msg'   => '1'
);
try {

    //회원 정보 가져오기
    $query = "
        SELECT COUNT(1) AS CNT FROM members
        WHERE 1=1
            AND m_sns_type  = '{$m_sns_type}'
            and m_sns_id ='{$m_sns_id}'
    ";

    $result = $_mysqli->query($query);

    if ($result) {
        $_arrMembers    = $result->fetch_array();
        $cnt            = $_arrMembers['CNT'];

        if ($cnt > 0) {
            $arrRtn['code'] = 501;
            $arrRtn['msg']  = "이미 가입된 계정입니다.\n해당 계정으로 로그인 혹은 다른 이메일로 회원 가입을 진행해 주세요.";
            alertReplace("이미 가입된 계정입니다.", '/signup/index.php');
            exit;
        }
    }
    //변수 체크
    $sql = " insert into  members
            (m_sns_type, m_sns_id,m_tel, m_ip,m_b_year, m_enter_datetime)
        VALUES
            ('{$m_sns_type}','{$m_sns_id}','{$userPhone}','{$ip}','{$userBirthday}', now())";
    //p($sql);
    $result = mysqli_query($_mysqli, $sql);
    if (!$result) {
        $arrRtn['code'] = 502;
        echo 502;
        echo $sql;
        exit;
    }

    $pw = password_hash($m_sns_type, PASSWORD_DEFAULT);

    $_querystring = base64_encode("m_sns_id={$m_sns_id}");;
    $_auth_url = "/signup/join_07.php?q=" . $_querystring;

    //성공
    $arrRtn['code'] = 200;
    $arrRtn['id'] = $m_sns_id;
    $arrRtn['msg'] = "이메일 전송 성공";

    locationReplace($_auth_url);
    

} catch (mysqli_sql_exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} catch (Exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} finally {

}
