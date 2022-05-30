<?php
include_once __DIR__.'/../_inc/config.php';

//마이페이지 변수
$_liClass6  = '';
$_liClass7  = '';
$_liClass8  = '';
$_liClass9  = '';
$_liClass10  = '';
$_liClass11 = '';

$_url   =   $_SERVER['REQUEST_URI'];
$_url_f     = explode('/',$_url);
$_url_f3    = explode('?', $_url_f[2])[0];

switch ($_url_f3) {
    case 'myaccount.php':
        $_liClass6  = 'active';
        break;
    case 'contactus_history.php':
        $_liClass7  = 'active';
        break;
    case 'cash_history.php';
        $_liClass8  = 'active';
        break;
    case 'fp_history.php':
        $_liClass9  = 'active';
        break;
    case 'hp_history.php':
        $_liClass10  = 'active';
        break;
    case 'howtoplay.php':
        $_liClass11  = 'active';
        break;
    default:
        break;
}
?>
<div class="category inner">
    <ul>
        <li class="<?=$_liClass6;?>"><a href="/myPage/myaccount.php">마이 페이지</a></li>
        <li class="<?=$_liClass7;?>"><a href="/myPage/contactus_history.php">문의 내역</a></li>
        <li class="<?=$_liClass8;?>"><a href="/myPage/cash_history.php">캐시 내역</a></li>
        <li class="<?=$_liClass9;?>"><a href="/myPage/fp_history.php">FP 내역</a></li>
        <li class="<?=$_liClass10;?>"><a href="/myPage/hp_history.php">전투력 내역</a></li>
        <li class="<?=$_liClass11;?>"><a href="/myPage/howtoplay.php">게임 가이드</a></li>
    </ul>
</div>
