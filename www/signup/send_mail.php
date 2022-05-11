<?php
//config
require __DIR__ .'/../_inc/config.php';


//리퍼러 체크

//파라미터 정리
//p($_POST);

$m_idx      = isset($_POST['m_idx'])        ?     $_POST['m_idx']       : '';





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
        SELECT 
            *
        FROM members
        WHERE 1=1
            AND m_idx  = '{$m_idx}'
    ";

    $result = $_mysqli->query($query);

    if ($result) {

        $_arrMembers    = $result->fetch_array();
        $db_seq         =   !empty($_arrMembers['m_idx'])    ?    $_arrMembers['m_idx']     :   '';
        $db_id         =   !empty($_arrMembers['m_id']) ?      $_arrMembers['m_id']   : '';
        $m_pw         =   !empty($_arrMembers['m_pw']) ?      $_arrMembers['m_pw']   : '';
        $pw         = password_hash($m_pw, PASSWORD_DEFAULT);


        $title          = '메타게임 회원가입 인증';
        $_querystring   = base64_encode("m_id={$db_id}&key={$pw}");;
        $_auth_url  = "http://d-www.2winchance.com//signup/join_07.php?q=". $_querystring;

        $html       ='<a href="'.$_auth_url.'" target="_blank">메타게임 회원가입 인증</a>';


        //echo $html;
        $log    = sendEmail($db_id, $title, $html);

       if($log){
           //성공
           $arrRtn['code'] = 200;
           $arrRtn['id'] = $m_idx;
           $arrRtn['msg']  = "이메일 전송 성공";
       }else{
           //성공
           $arrRtn['code'] = 500;
           $arrRtn['msg']  = "이메일 전송 실패";
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
