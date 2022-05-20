<?php

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임



//변수 정리
$_liClass1  = '';
$_liClass2  = '';
$_liClass3  = '';
$_liClass4  = '';
$_liClass5  = '';


$_url   =   $_SERVER['REQUEST_URI'];
$_url_f     = explode('/',$_url);
$_url_f3    = explode('?', $_url_f[2])[0];

switch ($_url_f3) {
    case 'companyinfo.php':
        $_liClass1  = 'active';
        break;
    case 'notice_list.php';
        $_liClass2  = 'active';
        break;
    case 'contactus.php':
        $_liClass3  = 'active';
        break;
    case 'terms_of_service.php':
        $_liClass4  = 'active';
        break;
    case 'privacy_policy.php':
        $_liClass5  = 'active';
        break;
    default:
        break;
}
?>
<div class="inner">
    <div class="ft-left">
        <h1 class="footer-logo">
            <a href="/main/"><img src="../images/logo_footer.png" alt="METAGAMES"></a>
        </h1>
        <ul class="footer-list">
            <li class="<?=$_liClass2;?>"><a href="/footer/notice_list.php">공지사항</a></li>
            <li class="<?=$_liClass3;?>"><a href="/footer/contactus.php">제휴문의</a></li>
            <li class="<?=$_liClass4;?>"><a href="/footer/terms_of_service.php">이용약관</a></li>
            <li class="<?=$_liClass5;?>"><a href="/footer/privacy_policy.php">개인정보 처리방침</a></li>
        </ul>
        <ul class="business-info">
            <li>서울시 강남구 선릉로 703 H&S타워 8F</li>
            <li>TEL : +82-2-515-0630 / FAX +82-0-000-0000</li>
            <li>상호 : ㈜매타록 대표이사 : 서해영</li>
            <li>게임 관련 문의 00000@Metarock.co.kr | 사업 문의 00000@Metarock.co.kr</li>
            <li>사업자번호: 831-87-01160 | 통신판매업 신고번호: ~~(신고 진행 중, 자리 비워둘 것 )~~</li>
            <li>ⓒ 2021-2022, Metarock Inc., All rights Reserved.</li>
        </ul>
    </div>
    <div class="ft-right">
        <div class="footer-permission">
            <img src="../images/img_footer.png" alt="심의">
        </div>
    </div>

</div>