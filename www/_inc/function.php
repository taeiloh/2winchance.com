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
        //$mail->Username   = 'hello@2winchance.com';                     //SMTP username
        //$mail->Password   = 'y*Z8UUH56';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->SetFrom('hello@2winchance.com', '2winchance');
        //$mail->addAddress('hello@2winchance.com', '2winchance');     //Add a recipient
        $mail->addAddress($email);               //Name is optional
        //$mail->addReplyTo('hello@2winchance.com', '2winchance');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        //$mail->Sender='dev@idevel.co.kr';
        //$mail->SetFrom('hello@2winchance.com', '2winchance', FALSE);

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
        return 99;
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
    if($start_page > 1) {
        echo  " <a href=".$url.($start_page-1)."><</a>";//이전
    } else {
        echo "";
    }
    if($total_page >= 1)
        for($now_page=$start_page;$now_page<=$end_page;$now_page++)
            if($page != $now_page) {
                echo  "<a href='".$url.$now_page."'> ".$now_page."</a>";
            } else {
                echo "<a class='active' href='javascript:void(0)'>".$now_page."</a>";
            }
    if($total_page > $end_page) {
        echo  "<a href=".$url.($end_page+1)." >></a>";//다음
    } else {
        echo "";
    }

    if($page < $total_page) {
        echo  "<a href=".$url.$total_page." >>></a>";//맨끝
    } else {
        echo "";
    }

}

function checkmobile(){

//check mobile
    $mAgent = array("iPhone","iPod","Android","Blackberry",
        "Opera Mini", "Windows ce", "Nokia", "sony" );
    $chkMobile = false;
    for($i=0; $i<sizeof($mAgent); $i++){
        if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
            $chkMobile = true;
            break;
        }
    }
    if($chkMobile){
        echo <<<SCRIPT
        <script> location.replace("http://m.2winchance.com");
        </script>
        SCRIPT;
    }
}

function check_word($search){
$filter = "18,588,18sex,18x,2wc,2winchace,3썸,갈보,갓양남,강간,강추야동,강한성인영화,개년,개놈,개뇬,개보지,개삽년,개새끼,개세이,개쉐이,개자식,개자지,개지랄,갱뱅,게시판섹스,게시판아동,게시판sex,게임머니,갬머니,겜머니,고객샌타,고객샌터,고객센타,고객센터,고공섹스,고자,고자섹스,공짜성인사이트,공짜야설,공짜포르노,과부촌,관리자,관잦,관좆,광년이보지,교제알선,구멍,군무새,귀두,그룹섹스,근친상간,글래머샵,김치남,김치녀,꼬추,나체,난교,냄져,네토,네토라레,누나몰카,누드,누드겔러리,누드동영상,누드섹스,누드쇼,누드집,누드커플,누드화보,니미,니미랄,니미럴,니애미,니에미,다음섹스,대디충,도우미,도찰,도촬,동거사이트,뒷치기,등신,딜도,딸딸이,떡걸,떡치기,또라이,러브젤,러브호텔,레즈비언,로리타,롤리타,리얼섹스플레이,리엘섹스,마나보지,마니아섹스,마스터베이션,만화보지,맛있는섹스,망가,망가짱,망까,매갈,매니저,매니져,메갈,메니저,메니져,메로나,메타록,멜섭,멜섹,모노섹스,몰카,몰카동영상,몰카리스트,몰카사이트,몰카사진,무료누드,무료망가,무료몰카,무료성인,무료성인게시판,무료성인동영상,무료성인만화,무료성인방송,무료성인사이트,무료성인소설,무료성인싸이트,무료성인야설,무료성인엽기,무료성인영화,무료성인정보,무료섹스,무료섹스동영상,무료섹스사이트,무료섹스페티쉬,무료야동,무료야설,무료페티쉬,무료포르노,무료포르노동영상,무료포르노사이트,무료헨타이,무삭제원판,무전망가,미국뽀르노,미국포르노,미소녀,미소녀게임,미소녀사진,미소녀섹스가이드,미스터콘돔,미스토픽닷컴,미스토픽성인용품점,미시촌,미쎄스터,미씨촌,미아리,미아리2000,미아리588,미아리섹스하리,미아리쇼,미아리야동,미아리텍사스,미아리tv,미야리야동,미친넘,미친년,미친년놈,미친놈,미친놈년,미친뇬,미친새끼,미친색히,바이브레이터,배충이,번개팅,번색,번섹,번쌕,벗기는고스톱,베충이,변태,변태게임,변태만화,변태사이트,변태사진,변태섹스,변태이야기,병신,보댕이,보빨,보이루,보지,보지나라,보지따기,보지먹기,보지보지,보지빨기,보지자지,보지털,보짓,보짓물,본디지,본디지,부랄,부부교환,부부교환섹스,부부나라,부부섹스,불로깅,불륜,불법,불법토토,불알,븅신,빙신,빠구리,빠구리,빠구리야동,빠굴,빠굴,빠꾸리,빠꾸리,빠라,빠라줘,빠순이,빡우리,빡울,빡촌,빨간궁뎅이,빨간마후라,빨간티브이섹스,빨강마후라,빨기,빨아,빨어,빽보지,뻐르너,뻐르노,뻐킹,뻘노,뽀로노,뽀르너,뽀르노,뽀르노,뽀지,뽈노,삐리넷,사까시,사까치,사설,사설토토,사이버섹스,사창가,삽입,새꺄,새끈,새끈남,새끈녀,새끼,색골,색남,색녀,색스코리아,색쓰,색폰,서양동영상,서양뽀르노,성감대,성게시판,성고민상담,성섹스,성기,성보조기구,성인누드,성인동영상,성인망가,성인메로나,성인무료,성인무료동영상,성인무료사이트,성인무료영화,성인무비,성인물,성인물,성인미스랭크,성인미팅,성인미팅방,성인방송,성인방송69채널,성인방송국,성인방송안내,성인배우,성인번개,성인벙개,성인별곡,성인비됴,성인비디오,성인사이트,성인사이트소개,성인사진,성인상품,성인생방송,성인샵,성인서적,성인섹스민국,성인섹스코리아,성인소녀경,성인소라가이드,성인소설,성인소설,성인쇼,성인쇼핑,성인쇼핑몰,성인시트콤,성인싸이트,성인애니,성인애니메이션,성인야설,성인야화,성인에로무비,성인에로영화,성인엽기,성인영상,성인영화,성인영화,성인영화관,성인영화나라,성인영화방,성인영화세상,성인영화천국,성인용,성인용품,성인용품,성인용품도매센터,성인용품에로존,성인용품할인매장,성인용CD,성인유머,성인이미지,성인인터넷방송,성인일본,성인자료,성인자료실,성인잡지,성인전용,성인전용관,성인전용서비스,성인전용정보,성인전화,성인정보,성인정보검색,성인채팅,성인챗,성인천국,성인체위,성인카툰,성인컨텐츠,성인퀸카,성인클럽,성인킹카,성인포르노,성인폰팅,성인플래쉬,성인플래시,성인화상,성인화상채팅,성인BJ,성인CD,성잉영화,성재기,성체위,성클리닉,성테크닉,성폭행,성행위,세꺄,세미누드,세엑,섹,섹,섹, 스,섹 스,섹걸,섹걸닷컴,섹골,섹골닷컴,섹녀,섹녀,섹도우즈,섹마,섹무비,섹보지,섹소리,섹쉬,섹쉬뱅크,섹쉬썸머타임,섹쉬엽기,섹스,섹스,섹스,섹스19,섹스25시,섹스2TV,섹스588섹스,섹스6mm,섹스700,섹스89,섹스가이드,섹스갤러리,섹스게시판,섹스경험담,섹스고고,섹스굿,섹스나라,섹스나라69,섹스나이트,섹스노예,섹스다음,섹스다크,섹스닷컴,섹스데이타100,섹스도우미,섹스동,섹스동영상,섹스드라마,섹스라이브,섹스라이브TV,섹스로봇,섹스리아,섹스리얼,섹스링크,섹스마스터,섹스만화,섹스망가,섹스매거진,섹스모델,섹스모아TV,섹스몰,섹스몰카,섹스무비,섹스무사,섹스뮤직,섹스믹스,섹스바부제펜,섹스벨리,섹스보드,섹스보조기구,섹스보조용품,섹스부인,섹스브라,섹스비디오,섹스비안,섹스사랑,섹스사이트,섹스사진,섹스살롱,섹스샘플,섹스샵,섹스샵2080,섹스샵21,섹스서치,섹스선데이,섹스성인만화,섹스셀카,섹스소나타,섹스소라가이드,섹스소리,섹스시네,섹스심리,섹스씬,섹스아이디,섹스알리바바,섹스애니마나,섹스앤샵,섹스야다이즈,섹스야동,섹스야시네,섹스야호,섹스에니메이션,섹스에로,섹스에로스TV,섹스에로시안,섹스엔바이,섹스엔샵,섹스엠티비닷컴,섹스영상,섹스영화,섹스왈,섹스용품,섹스월,섹스월드,섹스웰,섹스인형,섹스일기,섹스자료실,섹스자세,섹스자진,섹스잡지,섹스재팬만화,섹스정보,섹스제이제이,섹스제팬,섹스제펜,섹스조선,섹스조아,섹스조인,섹스존,섹스지존,섹스짱,섹스찌찌닷콤,섹스채널,섹스챗79,섹스천사,섹스천하,섹스체위,섹스촌,섹스캠프,섹스코러스,섹스코리아,섹스코리아,섹스코리아21,섹스코리아79,섹스코리아걸,섹스코리아넷,섹스코리아라이브,섹스코리아무비,섹스코리아성인엽기,섹스코리아섹스섹스코리아,섹스코리아소라가이드,섹스코리아소라의가이드,섹스코리아앤드섹스코리아,섹스코리아엑스섹스코리아,섹스코리아조선,섹스코리아포르노,섹스코리아하우스,섹스코리아DAMOIM,섹스코리아jp,섹스코리아MOLCA,섹스코리아OK,섹스코리아TV,섹스코리아warez,섹스코치,섹스크림,섹스클럽,섹스킴,섹스타임,섹스타임69,섹스테잎,섹스테크닉,섹스토이샵,섹스토이코리아,섹스투데이,섹스트립,섹스파일,섹스파크,섹스포르노,섹스포르노샵,섹스포르노트위스트김,섹스포르노molca,섹스포섹스티비,섹스포유,섹스포인트,섹스포탈,섹스프리덤,섹스피아,섹스하까,섹스하네,섹스하리,섹스한국,섹스해죠,섹스헨타이,섹스호빠,섹스홀,섹스and포르노,섹스damoim,섹스daum,섹스DC,섹스Koreana,섹스molca,섹스Molca섹스코리아,섹스molca코리아,섹스molca코리아TV,섹스molca포르노,섹스molcaTV,섹스molka,섹스sayclub,섹스SHOW,섹스TV,섹스warez,섹스yadong,섹시,섹시갤러리,섹시걸,섹시게이트,섹시나라,섹시나이트,섹시녀사진,섹시누드,섹시뉴스,섹시동영상성생활,섹시맵,섹시무비,섹시사진,섹시샵,섹시성인용품,섹시섹스코리아,섹시스타,섹시신문,섹시씨엔엔,섹시아이제이,섹시에로닷컴,섹시엔몰,섹시엔TV,섹시연예인,섹시재팬,섹시제팬,섹시제펜,섹시조선,섹시존,섹시짱,섹시촌,섹시코디,섹시코리아,섹시클럽,섹시클릭,섹시팅하자,섹시팬티,섹시포유,섹시TV,섹시wave,섹쑤,섹쓰,섹티즌,섹할,센스디스,센스디스무비,셀카,셀프누드,셀프카메라,소라가이드,소라가이드야설,소라야설,소라야설공작소,소라의가이드,소라의섹스코리아가이드,소라의야설,소라의야설가이드,소라의야설공작소,소라즈가이드,소추,쇼걸클럽,쇼우망가,쇼킹,쇼킹동영상,쇼킹섹스,쇼킹에로,수간,수음,수타킹,숙모보지,쉬팔,쉬펄,스너프,스뤼썸,스리섬,스발,스와핑,스와핑모임,스와핑몰카,스왑,스쿨걸,스타샵,스타킹페티쉬,스타킹포유,스탭,스텝,스트립쑈,슬림페티쉬,시발,시벌,시파,시펄,신고센터,십팔금,싸죠,쌍넘,쌍년,쌍놈,쌔,쌔깐,쌔끈,쌕쉬,쌕스,쌕쓰,쌕폰,쌩몰카,쌩보지,쌩보지쑈,쌩쇼,쌩쑈,쌩포르노,썅,썅넘,썅년,썅놈,썅놈,쎄끈,쎅스,쎅시넷,쒸팔,쒸펄,쓰뤼썸,쓰리섬,쓰리썸,쓰바,씌팍,씨바,씨발,씨발넘,씨발년,씨발놈,씨발뇬,씨방,씨방새,씨버럴,씨벌,씨보랄,씨보럴,씨부랄,씨부럴,씨부리,씨불,씨불,씨브랄,씨파,씨파,씨팍,씨팔,씨팔,씨펄,씹,씹,씹물,씹물,씹보지,씹새,씹새끼,씹색,씹세,씹세이,씹쉐,씹쉐이,씹쌔,씹쌔기,씹자지,씹창,씹탱,씹탱구리,씹팔,씹펄,씹할,아줌마보지,아줌마섹스,아줌마야동,아줌마페티쉬,알몸,애널,애로,애로영화,애마부인,애무,애비충,애액,애자매,야겜,야겜usa,야근병동,야껨,야덩,야동,야동,야동,야동게시판,야동자료실,야똥,야사,야사,야사,야설,야설,야설,야설게시판,야설공작소,야설신화,야설의문,야섹,야시,야시걸,야시꾸리,야시네,야시녀,야시랭크,야시룸,야시시,야애니,야오이,야캠,야캠,야하네,야하다,야한,야한,야한거,야한걸,야한것,야한게임,야한그림,야한놈,야한놈엽기,야한누드,야한동영상,야한동영상,야한만화,야한미소녀,야한밤,야한사이트,야한사진,야한소설,야한쇼닷컴,야한영화,야한이야기,야한클럽,야해,야해요,야해요야동,어덜트10000,어덜트라이프,어덜트랜드,어덜트존,어덜트탑10,어덜트피아,어덜트TV,어드민,에니탑,에로,에로걸즈,에로게이트,에로게임,에로관,에로극장,에로니폰,에로닷컴,에로당,에로데이,에로동,에로동영상,에로디비,에로무비,에로물,에로뮤직비디오,에로바다,에로방티브,에로배우,에로비,에로비디오,에로비안나이트,에로샵,에로세일,에로섹스TV,에로소라가이드,에로쇼,에로스데이,에로스아시아,에로스재팬,에로스코리아,에로스쿨,에로스타,에로스타일,에로스토토,에로스페셜,에로스포유,에로스TV,에로시네마,에로시안닷컴,에로시티,에로씨네,에로아시아,에로앤섹스,에로야,에로에스,에로엔조이,에로영화,에로영화관,에로올,에로와이프,에로이브,에로존,에로주,에로촬영현장,에로카,에로클릭,에로키위,에로투유,에로틱코리아,에로파크,에로패티시,에로팬티,에로플래쉬,에로필름,엑스노브라,엑스모텔,엑스터시,엑스투어덜트,여고생몰카,여고야동,여성성인용품,여성자위기구,여성자위시대,여자누드,여자따먹기,여자보지,여자옷벗기기,여자옷벗기기게임,여자자위,연예인누드,엽기에로,엽기적인섹스,영계,오나니,오랄,오랄,오럴,오럴섹스,오르가즘,오마담,오마이에로,오마이포르노,오빠아파,오빠아파닷컴,오빠아퍼,오사카섹스,오성인,오섹스,오섹스야,오섹스테레비,오아시스걸,오예성인영화,오이섹스,오케이섹스,오케이섹스티비,옷벗기기,옷벗기기게임,와우섹스,왕가슴,용주골,운영자,운지,울트라소세지,울트라쏘세지,원조,원조교재,원조교제,원조교제,원조교제,원조tv,월드섹스,유흥,육갑,육봉,윤간,음독,음독,음란,음란,음모,음부,음욕,음탕,이기야,이반,이발소몰카,이섹스,인터넷성인방송,일베,일배,일배충,배충이,일베충,일본동영상,일본망가,일본미소녀,일본뽀르노,일본성인만화,일본성인방송,일본섹스,일본포르노,자댕이,자살,자위,자위기구,자위방법,자위씬,자위용품,자위코리아,자위행위,자이루,자지,자지빨기,자지털,잠지,잠지만화,잠지털게임,잠지hentai,잡년,잡놈,재랄,재벌딸동영상,재벌딸포르노,재벌포르노,재팬마나,재팬만화,재팬팬티,저년,전화방,정력강화용품,정력팬티,정력포탈,정사,정사씬모음,정사채널,정양,정품게임,젖,젖꼭지,젖탱,젖탱,젖탱이,젼나,조까,조까,조루,졸라,졸라섹스,졸라야한닷컴,좃,좃나,좃나게,좃물,좆,좆같,좆꼴리,좆나,좆나게,좆물,좆빠,좇,좇,좇같,좇꼴려,좇꼴리,좇빠,지랄,지미랄,쪼가리,쫒,찌찌,참수,청산가루,청산가리,체모,체위,체위동영상,최음제,치마속,카섹스,칼라섹스,캠색,캠섹,컴색,컴섹,케이섹스,코리아섹스,콘돔,콘돔나라,콘돔닥터,콘돔몰,콘돔예스,콘돔피아,쿰척쿰척,크리토리스,크림걸,클럽에로,클럽AV스타,클리토리스,타부코리아,테마가게,테마몰,테마상점,테마샵,토탈에로,토토,퇴폐이발소,특수콘돔,파오후,패니스,패션앤섹스,패티쉬,패티쉬우먼,패티시,팬티캔디,퍼르노,페니스,페이퍼,페티걸,페티쉬,페티쉬러브,페티쉬매거진,페티쉬우먼,페티쉬즘,페티쉬코리아,페티시,페팅,펜트하우스,펜티,펨돔,펨섭,포경,포노,포로노,포르너,포르노,포르노24시,포르노그라피,포르노로,포르노마나,포르노만화,포르노바다,포르노배우,포르노비디오,포르노사이트,포르노사진,포르노세상,포르노섹스,포르노섹스마나,포르노섹스소라가이드,포르노섹스코리아,포르노섹스코리아소라가이드,포르노섹스트위스트김,포르노섹스TV,포르노스타,포르노업,포르노오팔팔,포르노월드,포르노자키,포르노집닷컴,포르노천국,포르노천사,포르노키위,포르노테이프,포르노테입,포르노테잎,포르노티비2580,포르노파티,포르노플레이보이,포르노bozi,포르노CINEMA,포르노CNN,포르노molca티비,포르노porno섹스코리아,포르노TV,포르노worldcup,포르노yadong,포르노yadong섹스코리아,포르느,포르로,포카리섹스,폰색,폰섹,폰섹스,폰쌕,폰쎅,폰팅,프로토,프리섹스샵,프리섹스성인용품,프리섹스코리아,플레이보이,플레이보이2030,플레이보이소라가이드,플레이보이온라인,플레이보지,플레이섹스,피임기구,피임용품,하소연,한국야동,한국포르노,한글섹스사이트,한남충,핫성인용품,핫섹스,핫섹스재팬,핫섹스코리아,핫포르노,핫포르노섹스,항문섹스,해피투섹스,핸타이,향기콘돔,헤라러브샵,헤어누드,헨타이,헨타이망가,헬로우콘돔,헬프섹스,헴타이,현금,현금교환,호로새끼,호빠,호스테스바,호스트바,호스트빠,혼음,홈섹스TV,화상색,화상섹,화상폰팅,화장실몰카,환금,환전,후이즈섹스,후장,훔쳐보기,흉자,히든포르노,히로뽕,adult,Adulthumor,adultlife,ADULTMANA,AdultSearch,AdultSexshop,adultvideo,adultzon,Adultzone,asiangirl,AV갤러리,av배우,av섹스코리아,AV재팬,AVmolca,awoodong,backbojytv,bbagury,bdsm,beheading,bestbozi,binya,BJ,bj,BJ라이브,BJ생방송,BJ에로쇼,BJ특별코너,BJSEX,bo지,Bojyty,bozi,Bozicam,bubunara,byuntaesex,c2joy,carporno,carsex,cash,clubero,condom,cosex,damoimsex,dildo,ecstasy,enterchannel,ero2030,ero69,eroasia,erocine,erosasia,erosian,erostyle,fetish,fetish7,fetishwoman,fuck,gabozi,gagasexy,gangbang,GM,GO588TV,GO섹시클럽,goadult,gocinepia,gojasex,h양,h양비디오,h양섹스비디오,haduri,hardcore,HardcorePorno,hentai,hidden,hidden-korea,hiddencam,hotbojy,hotsex,hotsexkorea,HOTWEB,HOTZONE,ilovesex,jaji,jasal,jfantasy,jgirls,joungyang,jungyang,K양,k양비디오,kgirlmolca,kgirls,kingsex,Korea포르노,KRTV,ksex,kukikorea,MC무현,metarock,molca,mrcondom,noode,nopants,NTR,nudcouple,nude,nudlnude,ogrish,oral,oralsextv,penis,penthouse,playbog,playboy,playbozi,PleyboG,Pleyboy,porn,porner,porno,porno-tape,Porno바다,PORNO애니,PORNOBOZI,pornomana,pornoplayboy,pornsex,prno,runsex,seheene,sex,sexy,sora's,sora'sguide,soraguide,soranet,sorasguide,SOSSEX,suck,swap,swaping,togoero,tv섹스코리아,TV플레이보이,videokiller,X등급,xxx,ya-han,yadong,yessex,youngsex";
/*
    $filter = explode(",", $filter);
    for ($i=0; $loop=count($filter); $i++) {
        if(strpos($search,$filter[$i]) !== false){
            $arrRtn['code'] = 600;
            $arrRtn['msg']  = "금지어";
            echo json_encode($arrRtn);
            exit;
        }
    }
*/

    $filter = str_replace("," , "|" , $filter); // 정규식을 사용하기 위해 콤마를 | 로 바꿈

    if (preg_match_all('/('.$filter.')/', $search, $match) == true) {
        for ($i=0, $loop=count($match[0]); $i<$loop; $i++) {
            //echo $match[0][$i].'<br>';
        }

        $arrRtn['code'] = 600;
        $arrRtn['msg']  = "금지어 입니다.";
        echo json_encode($arrRtn);
        exit;
        return false;
    }


}

//로그인 체크
function check_login($idx) {
    if (!$idx) {
        $url    = $_SERVER['REQUEST_URI'];
        $msg    = '로그인 페이지로 이동합니다.';
        $url    = '/login/index.php?rtnUrl='. $url;
        alertReplace($msg, $url);
        exit;
    }
}

// 20220528 진경수 (배지 이미지)
function get_badge_img($g_prize) {
    $img    = '<div class="badge">';
    switch ($g_prize) {
        case 0:
            $img    .= '<img src="/images/Contest_Mod_Free.png" alt="FREE ZONE"/>';
            break;
        case 1:
            $img    .= '<img src="/images/Contest_Mod_50.png" alt="50/50"/>';
            break;
        case 2:
            $img    .= '<img src="/images/Contest_Mod_TOP.png" alt="TOP 랭킹"/>';
            break;
        case 3:
            $img    .= '<img src="/images/Contest_Mod_TOP.png" alt="TOP 랭킹"/>';
            break;
        case 4:
            $img    .= '<img src="/images/Contest_Mod_TOP.png" alt="TOP 랭킹"/>';
            break;
        case 5:
            $img    .= '<img src="/images/Contest_Mod_TOP.png" alt="TOP 랭킹"/>';
            break;
        case 6:
            $img    .= '<img src="/images/Contest_Mod_TOP.png" alt="TOP 랭킹"/>';
            break;
        case 7:
            $img    .= '<img src="/images/Contest_Mod_2X.png" alt="더블 랭킹"/>';
            break;
        case 8:
            $img    .= '<img src="/images/Contest_Mod_3X.png" alt="트리플 랭킹"/>';
            break;
        case 9:
            $img    .= '<img src="/images/Contest_Mod_10X.png" alt="데카 랭킹"/>';
            break;

        default:
            break;
    }
    $img    .= '</div>';

    return $img;
}

function get_player_info($_mysqli, $player_id, $cate)
{
    /*$db_conn    = new DB_conn;
    $conn       = $db_conn->dbconnect_game();*/
    //
    //$cate_name  = cage_name($cate);
    $cate_name  = "pubg";
    //p($cate_name);
    //
    $query = "
      SELECT * FROM {$cate_name}_team_profile_player 
      WHERE 1=1
        AND idx = {$player_id}
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if ($result) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

// FP 지급
function give_fp($_mysqli, $m_idx, $fp_content, $fp, $trigger_type='', $trigger_idx=0) {
    //현재 FP
    $query  = "
        SELECT
          m_fp_balance 
        FROM members
        WHERE 1=1
          AND m_idx = {$m_idx}
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        throw new Exception('db error');
    }
    $_data      = $result->fetch_assoc();
    $fp_balance = $_data['m_fp_balance'] + $fp;

    //지급 (members)
    $query  = "
        UPDATE members
        SET
          m_fp_balance = m_fp_balance + {$fp}
        WHERE 1=1
          AND m_idx = {$m_idx}
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        throw new Exception('db error');
    }

    //지급 (history)
    $query  = "
        INSERT INTO fantasy_point_history
          (fph_m_idx, fph_content, fph_point, fph_balance,
          fph_trigger_type, fph_trigger_idx,
          created_at, created_by, created_ip)
        VALUES 
          ({$m_idx}, '{$fp_content}', {$fp}, {$fp_balance},
          '{$trigger_type}', {$trigger_idx},
          NOW(), '', '{$_SERVER['REMOTE_ADDR']}')
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        throw new Exception('db error');
    }
}

// 만능 4칙연산
function digitMath($value1, $value2, $type = 'plus') {
    if (is_numeric($value1) && is_numeric($value2)) {
        $num1 = $value1 * 100000000;
        $num2 = $value2 * 100000000;

        $digits = 8;

        $base = pow(10, $digits);

        $num1 = round($num1 * $base) / $base;
        $num2 = round($num2 * $base) / $base;

        $result1 = floor($num1);
        $result2 = floor($num2);

        switch ($type) {
            case 'plus' :
                $result = $result1 + $result2;
                break;

            case 'minus' :
                $result = $result1 - $result2;
                break;

            case 'multiply' :
                $result = $result1 * $result2;
                break;

            case 'divide' :
                $result = $result1 / $result2;
                break;

            default :
                $result = $result1 + $result2;
                $str = ' + ';
        }

        $result = $result / 100000000;
    } else {
        $result = null;
    }

    return $result;
}

function chg_pos($cate, $pos) {
    switch ($cate) {
        case 1:
        case 8:
            return $pos;
            break;

        case 2:
            if ($pos == 'RP' || $pos == 'SP') {
                return 'P';
            } else if ($pos == 'CF' || $pos == 'RF' || $pos == 'LF') {
                return 'OF';
            } else {
                return $pos;
            }
            break;
        //
        case 3:
            return $pos;
            break;

        case 4:
        case 5:
        case 7:
            return $pos;
            break;
        case 20:
            return $pos;
            break;
    }
}

//한글 substr
function utf8_substr($str, $start, $len=NULL) {
    $str_len    = mb_strlen($str, 'UTF-8');

    if ($len == NULL) {
        $len    = mb_strlen($str, 'UTF-8') - $start;
    }

    if ($str_len <= $len) {
        $rtn    = mb_substr($str, $start, $len, 'UTF-8');
    } else {
        $rtn    = mb_substr($str, $start, $len, 'UTF-8') .'...';
    }

    return $rtn;
}