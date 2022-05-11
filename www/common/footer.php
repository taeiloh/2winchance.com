<?php
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
    <ul class="footer-list">
<!--        <li class="--><?//=$_liClass1;?><!--"><a href="/footer/companyinfo.php">회사정보</a></li>-->
        <li class="<?=$_liClass2;?>"><a href="/footer/notice_list.php">공지사항</a></li>
        <li class="<?=$_liClass3;?>"><a href="/footer/contactus.php">제휴문의</a></li>
        <li class="<?=$_liClass4;?>"><a href="/footer/terms_of_service.php">이용약관</a></li>
        <li class="<?=$_liClass5;?>"><a href="/footer/privacy_policy.php">개인정보 처리방침</a></li>
    </ul>
    <h1 class="footer-logo">
        <a href="/main/"><img src="/images/logo_ft_gray.png" alt="METAGAMES"></a>
    </h1>
</div>