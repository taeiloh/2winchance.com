<?php
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
                    <li class="active"><a href="javascript:void(0)">리그 오브 레전드</a></li>
                    <li><a href="javascript:void(0)">배틀그라운드</a></li>
                    <li><a href="javascript:void(0)">DOTA2</a></li>
                    <li><a href="javascript:void(0)">GS:GO</a></li>
                </ul>
            </li>
            <li class="<?=$_liClass2;?>"><a href="/lineups/">LINEUPS</a></li>
            <li class="<?=$_liClass3;?>"><a href="/contests/">콘텐츠</a></li>
            <li class="<?=$_liClass4;?>"><a href="/store/">스토어</a></li>
            <li class="<?=$_liClass5;?>"><a href="/event/">이벤트</a></li>
        </ul>
    </nav>
    <div class="login-wrap">
        <!--로그인 전-->
        <div class="login-before">
            <div class="btn-group">
                <button type="button" id="btnTopSignUp" class="join-btn">회원가입</button>
                <button type="button" id="btnTopLogin" class="login-btn">로그인</button>
            </div>
            <a href="javascript:void(0)">HOW TO PLAY <img src="/images/ico_triangle.svg" alt="HOW TO PLAY"></a>
        </div>
        <!--  로그인 전-->


        <!--로그인 후    // css 처리 따로 없고 주석 처리만 되어 있습니다 -->
        <!--  <div class="login-after">
              <div class="profile-img"><img src="/images/item1.png" alt="유저 프로필 사진"></div>
              <div class="user-info">
                  <p class="nickname">정글못해먹겐네</p>
                  <div class="charge">
                      <p>695,165,300</p>
                      <button type="button" class="charge-btn">충전</button>
                  </div>
                  <div class="mypage">
                      <button type="button" class="mypage-btn">마이페이지 <img src="/images/ico_arrow_blue.svg" alt="마이페이지 메뉴 펼치기"></button>
                      <ul class="mypage-menu">
                          <li><a href="javascript:void(0)">MY ACCOUNT</a></li>
                          <li><a href="javascript:void(0)">1 : 1 TICKET</a></li>
                          <li><a href="javascript:void(0)">GOLD</a></li>
                          <li><a href="javascript:void(0)">FP</a></li>
                          <li><a href="javascript:void(0)">HOW TO PLAY</a></li>
                      </ul>
                  </div>
              </div>
              <button type="button" class="logout-btn">로그아웃</button>
          </div>-->
        <!--//로그인 후-->
    </div>
</div>