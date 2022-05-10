<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function p($arr) {
    if (ISOFFICE) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}

function alert($msg) {
    echo <<<SCRIPT
        <script>
            alert("{$msg}");
        </script>
SCRIPT;
    exit;
}

function alertBack($msg) {
    echo <<<SCRIPT
        <script>
            alert("{$msg}");
            history.back();
        </script>
SCRIPT;
    exit;
}

function alertReplace($msg, $url) {
    echo <<<SCRIPT
        <script>
            alert("{$msg}");
            location.replace("{$url}");
        </script>
SCRIPT;
    exit;
}

function locationReplace($url) {
    echo <<<SCRIPT
        <script type="text/javascript">
            location.replace("{$url}");
        </script>
SCRIPT;
    exit;
}

// 리퍼러 체크
function check_referer($url='') {
    if (strpos($_SERVER['HTTP_REFERER'], $url) === FALSE) {
        $msg    = '잘못된 접근입니다.';
        $url    = '/main/';
        alertReplace($msg, $url);
        exit;
    }
}

function sendEmail($email, $title, $html) {
    //Load Composer's autoloader
    require __DIR__ .'/../vendor/autoload.php';
    //echo $email;
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->CharSet    = "UTF-8";
        $mail->Encoding   = "base64";
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'dev@idevel.co.kr';                     //SMTP username
        $mail->Password   = 'dkdlelqpf!210@';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('dev@idevel.co.kr', '2winchance');
        //$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress($email);               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $html;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //echo 'Message has been sent';

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

//페이징
function paging($page,$total_page,$move_page,$url) {
    /*
    if($page > 1) {
        echo "<a href=".$url."><li class='prev'></li></a>";//처음
    } else {
        echo "";
    }
    */

    $start_page=0;

    $start_page = (((int)(($page-1)/$move_page))*$move_page)+1;
    $end_page = $start_page + ($move_page -1);
    if($end_page >= $total_page) {
        $end_page = $total_page;
    }
//    if($start_page > 1) {
//        echo  " <li class='prev'><a href=".$url.($start_page-1)."></a> </li>";//이전
//    } else {
//        echo "";
//    }
    if($total_page >= 1)
        for($now_page=$start_page;$now_page<=$end_page;$now_page++)
            if($page != $now_page) {
                echo  "<a href='".$url.$now_page."'> ".$now_page."</a>";
            } else {
                echo "<a class='active' href='javascript:void(0)'>".$now_page."</a>";
            }
//    if($total_page > $end_page) {
//        echo  "<li class='next'><a href=".$url.($end_page+1)." ></a></li>";//다음
//    } else {
//        echo "";
//    }
    /*
    if($page < $total_page) {
        echo  "<a href=".$url.$total_page." ><li class='next'></li></a>";//맨끝
    } else {
        echo "";
    }
    */
}