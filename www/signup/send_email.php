<?php
//config
require __DIR__ .'/../_inc/config.php';


//리퍼러 체크

//파라미터 정리
//p($_POST);
$m_id      = isset($_POST['m_id'])        ?     $_POST['m_id']       : '';
$m_pw      = isset($_POST['m_pw'])        ?     $_POST['m_pw']       : '';
$m_sns_type      = isset($_POST['m_sns_type'])        ?     $_POST['m_sns_type']       : '';
$m_sns_id      = isset($_POST['m_sns_id'])        ?     $_POST['m_sns_id']       : '';
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
    //아이디 중복 확인
    $query  = "
            SELECT COUNT(1) AS CNT FROM MEMBERS
            WHERE 1=1
                AND m_id = '{$m_id}'
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
        }
    }


    //변수 체크
    $sql  = " insert into  MEMBERS
                (m_id, m_pw, m_sns_type, m_sns_id, m_ip, m_enter_datetime)
            VALUES
                ('{$m_id}','{$m_pw}','{$m_sns_type}','{$m_sns_id}','{$ip}', now())";
    //p($sql);
    $result = mysqli_query($_mysqli, $sql);
    if (!$result) {
        $arrRtn['code'] = 502;
        echo $sql;
        exit;
    }

    $m_idx   =   $_mysqli->insert_id;


    //회원 정보 가져오기
    $query = "
        SELECT 
            *
        FROM MEMBERS
        WHERE 1=1
            AND m_idx  = '{$m_idx}'
    ";

    $result = $_mysqli->query($query);

    if ($result) {

        $_arrMembers    = $result->fetch_array();
        $db_seq         =   !empty($_arrMembers['m_idx'])    ?    $_arrMembers['m_idx']     :   '';
        $db_id         =   !empty($_arrMembers['m_id']) ?      $_arrMembers['m_id']   : '';
        if ($db_seq!="") {
            //비밀번호 링크 이메일 발송
            //메일 발송
            if ($db_id!="") {
                $title          = '메타게임 로그인 인증';
                $html           = '';
                $today          = date('Y-m-d H:i:s', time());
                $_querystring   = "m_id={$db_id}&key={$pw}";
                include_once __DIR__ .'/../login/join_auth_html.php';


                //echo $html;
                $log    = sendEmail($db_id, $title, $html);

               if($log){
                   //성공
                   $arrRtn['code'] = 200;
                   $arrRtn['msg']  = "이메일 전송 성공";
               }else{
                   //성공
                   $arrRtn['code'] = 500;
                   $arrRtn['msg']  = "이메일 전송 실패";
               }

            }
        }
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
