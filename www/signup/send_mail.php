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
        $_auth_url  = "https://2winchance.com//signup/join_07.php?q=". $_querystring;

        $html       ='<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>METAGAMES</title>

</head>
<style>
    @import url("https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css");
</style>
<body style="max-width: 620px; margin: 0 auto;">
<span style="white-space: normal; letter-spacing: normal; text-transform: none; word-spacing: 0px;float:none; color:#ffffff; \ -webkit-text-stroke-width:0px;">
<table align="center" border="0" cellspacing="0" cellpadding="0"
       style=" width:100%; max-width: 620px; background-color:#000000; border-top: 8px solid #1e8fff; letter-spacing: -1px">
    <tbody>
    <tr>
        <td align="center">
            <div style="max-width: 520px; margin:0 auto">
                <table cellpadding="0" cellspacing="0"
                       style="width:100%; margin:0 auto; background-color:#000000;  -webkit-text-size-adjust: 100%; text-align: left;">
                    <tbody>
                        <tr>
                            <td colspan="3" height="50"></td>
                        </tr>
                        <tr>
                            <td width="20"></td>
                            <td>
                                <table cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0;">
                                    <tbody>
                                        <tr>
                                            <td style="margin:0; padding: 0;" valign="top" align="center">
                                               <a href="tml" target="_blank"><img
                                                       src="https://syryu.wtest.biz/metagames/html/pc/images/logo_white.svg"
                                                       alt="METAGAMES" width="224" height="43"
                                                       style="border:0; margin-right:5px;"></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" height="30"></td>
                        </tr>
                        <tr>
                            <td width="20"></td>
                            <td style=" background-image: url("https://syryu.wtest.biz/metagames/html/images/img_title_bg.svg"); background-repeat:no-repeat; background-position: center; background-size: contain; height: 123px; line-height: 123px; text-align: center; font-size: 30px; font-weight: 600;  color: #fff;">
            이메일 인증 완료
        </td>
                            <td width="20"></td>
                        </tr>
                        <tr>
                            <td colspan="3" height="30"></td>
                        </tr>
                        <tr>
                            <td width="20"></td>
                            <td>
                                <table cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0;">
                                    <tbody>
                                        <tr>

                                            <td style="vertical-align: top; font-size: 24px;  color: #fff;">
            안녕하세요! <b
                                                    style="font-size: 30px; color:#1e8fff; padding: 0 10px; font-weight: bold;">'.$db_id.'</b>님
                                            </td>
                                        </tr>
                                        <tr>
                                             <td colspan="3" height="40"></td>
                                        </tr>
                                         <tr>
                                            <td style=" color: #ffffff; font-size: 20px; line-height: 30px;">
            이메일 인증이 완료되었습니다.
                                                <br>
        이제 메타게임 계정을 이용하실 수 있습니다.
                                            </td>
                                        </tr>
                                        <tr>
                                             <td colspan="3" height="50"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                             <td width="20"></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="3">
                                <div style="display: inline-block; width: 520px; max-width: 100%; vertical-align: top;">
                                     <table cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%; background:#1e8fff; ">
                                        <tbody>
                                            <tr>
                                                <td height="80" style="text-align: center;">
                                                     <a href="'.$_auth_url.'" target="_blank" style="display:block; font-size: 35px; text-decoration:none; color:#ffffff; ">닉네임 설정하기</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <tr>
                                 <td colspan="3" height="50"></td>
                            </tr>
                            <td align="center" colspan="3">
                                <div style="display: inline-block; width: 520px; max-width: 100%; vertical-align: top;">
                                     <table cellpadding="0" cellspacing="0" >
                                        <tbody>
                                            <tr>
                                                <td  style="text-align: center;">
                                                     <a href="javascript:void(0)" target="_blank" style="display:block; font-size: 12px; text-decoration:none; color:#9f9f9f; ">ⓒ 2021-2022, Metarock Inc., All rights Reserved.</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                            <tr>
                                <td colspan="3" height="50"></td>
                            </tr>
                        </tr>

                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    </tbody>
</table>
</span>
</body>
</html>
';


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
