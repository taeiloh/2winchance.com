<?php
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임
$deposit=!empty($_SESSION['_se_deposit']) ? $_SESSION['_se_deposit'] : 0;    // 세션 포인트
$fp=!empty($_SESSION['_se_fp']) ? $_SESSION['_se_fp'] : 0; // fantasy-point 잔액
$on = !empty($_GET['on']) ?$_GET['on'] : "";

$m_pw      = isset($_POST['m_pw'])        ?     $_POST['m_pw']       : '';

if (!$idx) {
    $url    = $_SERVER['REQUEST_URI'];
    $msg    = '로그인 페이지로 이동합니다.';
    $url    = '/login/index.php?rtnUrl='. $url;
    alertReplace($msg, $url);
    exit;
}
try {
    $query2 = "
    SELECT *
        FROM members
        WHERE 1 and m_idx ='{$idx}'
    ";
    $mresult = $_mysqli->query($query2);
    $_arrMembers = $mresult->fetch_array();
    $m_sns_type = !empty($_arrMembers['m_sns_type']) ? $_arrMembers['m_sns_type'] : '';
    $m_fp_limit = !empty($_arrMembers['m_fp_limit']) ? $_arrMembers['m_fp_limit'] : 0;
    $m_time_reset = !empty($_arrMembers['reset_time']) ? $_arrMembers['reset_time'] : 0;
    //$m_limit_deposit = !empty($_arrMembers['m_limit_deposit']) ? $_arrMembers['m_limit_deposit'] : 500000;
    //$m_day_deposit = !empty($_arrMembers['m_day_deposit']) ? $_arrMembers['m_day_deposit'] : 300000;
    $m_deposit =  !empty($_arrMembers['m_deposit']) ? $_arrMembers['m_deposit'] : 0;

    $query3 = " 
        SELECT sum(dh_deposit) as total_deposit, DATE_FORMAT(dh_req_date, '%Y%m%d') FROM deposit_history
        WHERE 1 AND dh_u_idx='{$idx}'
        GROUP BY DATE_FORMAT(dh_req_date, '%Y%m%d')
    ";
    $dayresult = $_mysqli->query($query3);
    $_arrDeposit = $dayresult->fetch_array();
    $day_limit = !empty($_arrDeposit['total_deposit']) ? $_arrDeposit['total_deposit'] : 0;
    //print $day_limit;




}catch (Exception $e) {
    p($e);
}


?>
<!doctype html>
<html lang="ko">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>

<!--//head-->

<body>
<div id="wrap" class="sub myqna">
    <!--header-->
    <header id="header">
        <?php
        // header
        require_once __DIR__ .'/../common/header.php';
        ?>
    </header>
    <!--//header-->

    <!--container-->
    <div id="container">
        <!--content-->
        <div id="content" >
            <!--sec-01-->
            <section class="sec sec-01 T0 myAcct">
                <div class="contents-cont inner item-page">
                    <div class="inner">
                        <div class="title">
                            <h2>한도 설정</h2>
                        </div>
                        <form action="">
                            <div class="sub-content">
                                <div class="money-limit">
                                    <h3>캐시 구매 잔여 한도 내역</h3>
                                    <div class="limit-days">
                                        <p>월 현재 잔여 한도 - <span class="limit-money"><?=number_format(500000-$m_deposit)?></span><span><img src="../images/ico_alert_small.png" alt="알림">매월 1일 초기화</span></p>
                                        <p>일 현재 잔여 한도 - <span class="limit-money"><?=number_format(300000-$day_limit)?></span><span><img src="../images/ico_alert_small.png" alt="알림">매일 오전 09:00 초기화</span></p>
                                    </div>
                                </div>
                                <div class="limit-input-wrap">
                                    <h3>FP 사용 한도 설정</h3>
                                    <div class="input-box limit-input">
                                        <label for="">누적한도 설정</label>
                                        <div class="limit-select">
                                            <?php
                                            if($on == ''){
                                            ?>
                                            <section id="drop3" class="dropdown">
                                                <div class="select" id="selectfp">
                                                    <div class="text"><?php if($m_fp_limit == 0){ echo '해당사항 없음'; } else { echo number_format($m_fp_limit); }?></div>
                                                    <ul class="option-list setting">
                                                        <li class="option" value="0">해당사항 없음</li>
                                                        <li class="option" value="10000">10,000</li>
                                                        <li class="option" value="15000">15,000</li>
                                                        <li class="option" value="20000">20,000</li>
                                                        <li class="option" value="25000">25,000</li>
                                                        <li class="option" value="30000">30,000</li>
                                                        <li class="option" value="35000">35,000</li>
                                                        <li class="option" value="40000">40,000</li>
                                                        <li class="option" value="45000">45,000</li>
                                                        <li class="option" value="50000">50,000</li>
                                                    </ul>
                                                </div>
                                            </section>
                                            <?php
                                            }else{
                                            ?>
                                                <p><?php  echo number_format($m_fp_limit); ?></p>
                                            <?php
                                            }
                                            ?>
                                            <!-- 한도 설정 완료 후-->
                                            <span>FP</span>
                                        </div>
                                    </div>
                                    <div class="input-box limit-input">
                                        <label for="">초기화 시간</label>
                                        <div class="limit-select">
                                            <?php
                                            if($on == ''){
                                            ?>
                                            <section id="drop4" class="dropdown">
                                                <div class="select" id="selecttime">
                                                    <div class="text"><?php if($m_time_reset == 0){ echo '해당사항 없음'; } else { echo number_format($m_time_reset); }?></div>
                                                    <ul class="option-list reset_time">
                                                        <li class="option" value="0">해당사항 없음</li>
                                                        <li class="option" value="6">6</li>
                                                        <li class="option" value="8">8</li>
                                                        <li class="option" value="10">10</li>
                                                        <li class="option" value="12">12</li>
                                                        <li class="option" value="14">14</li>
                                                        <li class="option" value="16">16</li>
                                                        <li class="option" value="18">18</li>
                                                        <li class="option" value="20">20</li>
                                                        <li class="option" value="22">22</li>
                                                        <li class="option" value="24">24</li>
                                                    </ul>
                                                </div>
                                            </section>

                                            <?php
                                            }else{
                                            ?>
                                                <p><?php  echo number_format($m_time_reset); ?></p>
                                            <?php
                                            }
                                            ?>
                                            <!-- 시간 설정 완료 후 <p>10,000</p> -->
                                            <span>시간</span>
                                        </div>
                                    </div>
                                </div>
<!--                                <button type="button" class="btn-blue btn-6 mT50" id="saveBtn" onclick="save()">적용하기</button>-->
<!--                                <span class="save-alert save" id="save" style="display: none;">정보 저장이 정상적으로 완료 되었습니다.</span>-->

                                <!-- <span class="save-alert error">정보 저장에 실패 하였습니다. 다시 시도하여 주시기 바랍니다..</span> -->
                                <?php
                                    if($on==1){
                                   ?>
                                        <button type="button" class="btn-blue btn-6 mT50" onclick="location.href='/lobby/'">홈으로</button>
                                        <span class="save-alert save">정보 저장이 정상적으로 완료 되었습니다.</span>
                                <?php
                                    }else{
                                ?>
                                        <button type="button" class="btn-blue btn-6 mT50" id="saveBtn" onclick="save()">적용하기</button>

                                <?php
                                    }
                                ?>

                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <!--//sec-01-->
        </div>
        <!--//content-->
    </div>
    <!--//container-->
    <footer>
        © 2022 METAGAMES, Inc. All Rights Reserved.
    </footer>
    <script type="text/javascript">
         var setting_limit_fp = 0;
         var time_reset = 0;

        $(document).ready(function (){
            $('ul.setting li').click(function (){
                var limit_fp = $(this).val();

                setting_limit_fp = limit_fp;
                //alert(setting_limit_fp);
            });

        });

        $(document).ready(function (){
            $('ul.reset_time li').click(function (){
                var reset_time = $(this).val();

                time_reset = reset_time;

                //alert(time_reset);
            });
        });


        function save(){
            var postData = {
                "limit_fp" : setting_limit_fp,
                "reset_time" : time_reset
            };

            $.ajax({
                url: "setting_cash_proc.php",
                type: "POST",
                data: postData,
                dataType:"JSON",
                success:function (data){
                    console.log(data);
                    if(data.code == 200){
                        //alert("적용 되었습니다.");
                        location.href="setting_cash.php?on=1";


                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    </script>
</div>
</body>
</html>