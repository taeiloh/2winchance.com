<?php
// 변수 정리
require_once __DIR__.'/../_inc/config.php';

// 파라미터 정리
checkmobile();
$cate       = !empty($_GET['cate'])     ? $_GET['cate']     : 20;

$_se_idx    =!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$_se_id     =!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$_se_name   =!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임
//$deposit=!empty($_SESSION['_se_deposit']) ? $_SESSION['_se_deposit'] : 0;    // 세션 포인트

$query = "
    SELECT *
        FROM members
        WHERE 1 and m_idx ='{$_se_idx}'
    ";
//p($query);
$mresult        = $_mysqli->query($query);
$_arrMembers    = $mresult->fetch_array();
$m_deposit      = !empty($_arrMembers['m_deposit'])     ? $_arrMembers['m_deposit']     : 0;
$m_fpbalance    = !empty($_arrMembers['m_fp_balance'])  ? $_arrMembers['m_fp_balance']  : 0;

//$queryfp = "
//    SELECT *
//        FROM fantasy_point_history
//    WHERE 1 and fph_m_idx ='{$idx}'
//    ";
//
//$fpresult = $_mysqli->query($queryfp);
//$fpdb = $fpresult->fetch_array();
//$m_fp = !empty($fpdb['fph_balance']) ? $fpdb['fph_balance'] : 0;


//변수 정리
$_liClass1  = '';
$_liClass2  = '';
$_liClass3  = '';
$_liClass4  = '';
$_liClass5  = '';
$_menu1     = '';
$_menu2     = '';

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
switch ($_url_f[2]){
    case '':
        $_menu1 = 'active';
        break;
    case 'item.php':
        $_menu2 = 'active';
        break;
    default:
        break;
}

try{
$sql = "SELECT * FROM members WHERE m_idx = '{$_se_idx}' ";
$result = $_mysqli->query($sql);
$arraymembers = $result->fetch_array();

$query4 = "SELECT i_src FROM m_item WHERE main_emblem =1 and m_idx = '{$_se_idx}'";
$result4 = $_mysqli->query($query4);
$main = $result4 ->fetch_array();
$main_src = !empty($main['i_src']) ? $main['i_src']:'';
}catch (Exception $e) {
    //p($e);
}
?>
<div class="inner">
    <h1 class="logo"><a href="/main/"><img src="/images/logo.png" alt="METAGAMES"></a></h1>
    <nav id="gnb">
        <ul>
            <li class="<?=$_liClass1;?>"><a href="/lobby/">로비</a>
                <ul class="sub-menu">
                    <!--                    <li class="--><?//=($cate==21)?'active':'';?><!--"><a href="/lobby/?cate=21">리그 오브 레전드</a></li>-->
                    <li class="<?=$_liClass1;?> <?=($cate==20)?'active':'';?>"><a href="/lobby/?cate=20">배틀그라운드</a></li>
                    <!--                    <li><a href="javascript:void(0)" onclick="alert('준비중입니다.');">DOTA2</a></li>-->
                    <!--                    <li><a href="javascript:void(0)" onclick="alert('준비중입니다.');">GS:GO</a></li>-->
                </ul>
            </li>
            <li class="<?=$_liClass2;?>"><a href="/lineups/">라인업</a></li>
            <li class="<?=$_liClass3;?>"><a href="/contests/">콘테스트</a></li>
            <li class="<?=$_liClass4;?>">
                <a href="/store/">스토어</a>
                <ul class="sub-menu">
                    <li class="<?=$_menu1?>"><a href="/store/">캐시</a></li>
                    <li class="<?=$_menu2?>"><a href="/store/item.php">아이템</a></li>
                </ul>
            </li>
            <li class="<?=$_liClass5;?>"><a href="/event/">이벤트</a></li>
        </ul>
    </nav>
    <div class="login-wrap">
        <!--로그인 전-->
        <?php
        if($_se_idx==""){
            ?>
            <div class="login-before">
                <div class="btn-group">
                    <button type="button" id="btnTopSignUp" class="join-btn" onclick="location.href='/signup/index.php'">회원가입</button>
                    <button type="button" id="btnTopLogin" class="login-btn" onclick="location.href='/login/index.php'">로그인</button>
                </div>
                <a href="/myPage/howtoplay.php">게임 가이드 <img src="/images/ico_triangle.svg" alt="HOW TO PLAY"></a>
            </div>
            <!--  로그인 전-->
            <?php
        }else{

            ?>
            <!--로그인 후    // css 처리 따로 없고 주석 처리만 되어 있습니다 -->
            <div class="login-after">
                <div class="profile-img">
                    <?php
                    if($main_src){?>
                    <img src="<?=$main_src?>" alt="유저 프로필 사진">
                    <?php
                    }else{?>
                        <img src="../images/@thumb_player_default.png" alt="유저 프로필 기본 사진">
                    <?php
                    }
                    ?>
                </div>
                <div class="user-info">
                    <p class="nickname"><?=$_se_name?></p>
                    <div class="charge">
                        <p><?=number_format($m_fpbalance)?></p>
                        <button type="button" class="charge-btn" onclick="location.href='../store/'">충전</button>
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