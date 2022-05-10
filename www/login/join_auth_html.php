<?php
$_auth_url  = "http://2winchance.com/signup/join_05.php?q=". $_querystring;

$html       =
    "<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tr>
        <td>
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='560' style='border-collapse: collapse; background-color: #eeeeee;'>
                <tr>
                    <td style='padding: 26px 40px;'>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse; background-color: #eeeeee;'>
                            <tr>
                                <td style='padding: 36px 40px;'>
                                    <!-- 사이트의 이미지 주소를 넣어주세요 -->
                                    <a href=http://2winchance.com' target='_blank'><img src='http://2winchance.com/images/logo.png'></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='border: solid 1px #dbdbdb; background-color: #ffffff;'>
                                        <tr>
                                            <td style='padding: 48px 40px;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                        <td style='padding-bottom: 8px; font-size: 18px;'>
                                                            <font color='#002664'><strong>메타게임 회원가입</strong> 안내</font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding: 32px 0; font-size: 15px; line-height: 1.6;'>
                                                            <font color='#525252'>
                                                                안녕하세요.<br/>
                                                                메타게임 회원가입 해주셔서 감사합니다.<br/>
                                                            </font>
                                                            <font color='#222222'><strong>메타게임 회원가입을 위해 아래 버튼을 클릭해 주세요.</strong><br/></font>
                                                            <font color='#525252'>
                                                                (본 재설정 메일은 8시간 동안 유효합니다.)
                                                            </font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <!-- 이메일 주소 인증 링크를 넣어주세요 -->
                                                            <a href='". $_auth_url ."' target='_blank' style='text-decoration: none;'>
                                                                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='background-color: #002664;'>
                                                                    <tr>
                                                                        <td style='padding: 16px; font-size: 15px; font-weight: 500; text-align: center;'>
                                                                            <font color='#ffffff'>메타게임 회원가입 인증</font>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>                    
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>";