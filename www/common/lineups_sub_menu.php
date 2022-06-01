<?php
include_once __DIR__.'/../_inc/config.php';

// 메뉴 변수
$_liClass1  = '';
$_liClass2  = '';
$_liClass3  = '';
$_liClass4  = '';

$_url   =   $_SERVER['REQUEST_URI'];
$_url_f     = explode('/',$_url);
$_url_f3    = explode('?', $_url_f[2])[1];

switch ($_url_f3) {
    case '':
        $_liClass1  = 'active';
        break;
    case 'sub=upcoming':
        $_liClass1  = 'active';
        break;
    case 'sub=live':
        $_liClass2  = 'active';
        break;
    case 'sub=finish';
        $_liClass3  = 'active';
        break;

    default:
        break;
}
?>

<ul>
<!--    <li class="active"><a href="/lineups/">ALL</a></li>-->
    <li class="<?=$_liClass1;?>"><a href="/lineups/?sub=upcoming">대기</a></li>
    <li class="<?=$_liClass2;?>"><a href="/lineups/?sub=live">LIVE</a></li>
    <li class="<?=$_liClass3;?>"><a href="/lineups/?sub=finish">결과</a></li>
</ul>