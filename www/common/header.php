<?php
// 파라미터 정리
checkmobile();
$cate       = !empty($_GET['cate'])     ? $_GET['cate']     : '';

// 변수 정리
include_once __DIR__.'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임
$deposit=!empty($_SESSION['_se_deposit']) ? $_SESSION['_se_deposit'] : 0;    // 세션 포인트

//변수 정리
$_liClass1  = '';
$_liClass2  = '';
$_liClass3  = '';
$_liClass4  = '';
$_liClass5  = '';



$_url   =   $_SERVER['REQUEST_URI'];
$_url_f     = explode('/',$_url);
$_url_f3    = explode('?', $_url_f[1])[0];

switch ($_url_f3) {
    case 'lobby':
        $_liClass1  = 'active';
        break;
    case 'lineups';
        $_liClass2  = 'active';
        break;
    case 'contests':
        $_liClass3  = 'active';
        break;
    case 'store':
        $_liClass4  = 'active';
        break;
    case 'event':
        $_liClass5  = 'active';
        break;
    default:
        break;
}

?>
<div class="inner">
    <h1 class="logo"><a href="/main/"><img src="/images/logo.png" alt="METAGAMES"></a></h1>
    <nav id="gnb">
        <ul>
            <li class="<?=$_liClass1;?>"><a href="/lobby/">로비</a>
                <ul class="sub-menu">
                    <li class="<?=($cate==21)?'active':'';?>"><a href="/lobby/?cate=21">리그 오브 레전드</a></li>
                    <li class="<?=($cate==20)?'active':'';?>"><a href="/lobby/?cate=20">배틀그라운드</a></li>
                    <li><a href="javascript:void(0)" onclick="alert('준비중입니다.');">DOTA2</a></li>
                    <li><a href="javascript:void(0)" onclick="alert('준비중입니다.');">GS:GO</a></li>
                </ul>
            </li>
            <li class="<?=$_liClass2;?>"><a href="/lineups/">LINEUPS</a></li>
            <li class="<?=$_liClass3;?>"><a href="/contests/">콘텐츠</a></li>
            <li class="<?=$_liClass4;?>">
                <a href="/store/">스토어</a>
                <ul class="sub-menu">
                    <li><a href="/store/">CASH</a></li>
                    <li><a href="/store/item.php">ITEM</a></li>
                </ul>
            </li>
            <li class="<?=$_liClass5;?>"><a href="/event/">이벤트</a></li>
        </ul>
    </nav>
    <div class="login-wrap">
        <!--로그인 전-->
        <?php
        if($idx==""){
        ?>
        <div class="login-before">
            <div class="btn-group">
                <button type="button" id="btnTopSignUp" class="join-btn" onclick="location.href='/signup/index.php'">회원가입</button>
                <button type="button" id="btnTopLogin" class="login-btn" onclick="location.href='/login/index.php'">로그인</button>
            </div>
            <a href="/myPage/howtoplay.php">HOW TO PLAY <img src="/images/ico_triangle.svg" alt="HOW TO PLAY"></a>
        </div>
        <!--  로그인 전-->
        <?php
        }else{

        ?>
            <!--로그인 후    // css 처리 따로 없고 주석 처리만 되어 있습니다 -->
            <div class="login-after">
              <div class="profile-img"><img src="/images/item1.png" alt="유저 프로필 사진"></div>
              <div class="user-info">
                  <p class="nickname"><?=$name?></p>
                  <div class="charge">
                      <p><?=number_format($deposit)?></p>
                      <button type="button" class="charge-btn">충전</button>
                  </div>
                  <div class="mypage">
                      <button type="button" class="mypage-btn" onclick="location.href='/myPage/myaccount.php'">마이페이지 <img src="/images/ico_arrow_blue.svg" alt="마이페이지 메뉴 펼치기"></button>
                      <ul class="mypage-menu">
                          <li><a href="javascript:void(0)">MY ACCOUNT</a></li>
                          <li><a href="javascript:void(0)">1 : 1 TICKET</a></li>
                          <li><a href="javascript:void(0)">GOLD</a></li>
                          <li><a href="javascript:void(0)">FP</a></li>
                          <li><a href="javascript:void(0)">HOW TO PLAY</a></li>
                      </ul>
                  </div>
              </div>
              <button type="button" class="logout-btn" onclick="location.href='/login/logout.php'">로그아웃</button>
          </div>
        <!--//로그인 후-->
    <?php
        }
        ?>
    </div>
</div>