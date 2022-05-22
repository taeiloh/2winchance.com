<?php
include_once __DIR__.'/../_inc/config.php';

//메뉴 변수
$_liClass1  = '';
$_liClass2  = '';
$_liClass3  = '';

$_url   =   $_SERVER['REQUEST_URI'];
$_url_f     = explode('/',$_url);
$_url_f3    = explode('?', $_url_f[2])[0];

switch ($_url_f3) {
    case '':
        $_liClass1  = 'active';
        break;
    case 'live.php':
        $_liClass2  = 'active';
        break;
    case 'finished.php';
        $_liClass3  = 'active';
        break;
    default:
        break;
}
?>
<ul class="">
    <li class="<?=$_liClass1;?>"><a href="/contests/">대기</a></li>
    <li class="<?=$_liClass2;?>"><a href="/contests/live.php">LIVE</a></li>
    <li class="<?=$_liClass3;?>"><a href="/contests/finished.php">결과</a></li>
</ul>