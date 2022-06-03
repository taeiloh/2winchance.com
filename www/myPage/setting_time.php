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
        and DATE_FORMAT(DATE_ADD(dh_req_date, INTERVAL 1 MONTH), '%Y%m01') > DATE_FORMAT(CURDATE(), '%Y%m%d')
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
<html lang="ko" xmlns="http://www.w3.org/1999/html">
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
                            <h2>게임입장 제한기간 설정</h2>
                        </div>
                        <form action="">
                            <div class="sub-content">
                                    <h3>이용자 요청 게임 입장 제한 시간 설정</h3>
                                <div class="limit-input-wrap">
                                    <input type="text" id="set_time" name="set_time" value="1~100까지 입력 가능">
                                </div>
                                <div class="sub-content">
                                    <h3>설정 후 로그인이 제한되며, 설정 기간 변경은 불가능합니다.</h3>
                                </div>
                                <button type="button" class="btn-blue btn-6 mT50" id="saveBtn" onclick="save()">적용하기</button>

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
        ⓒ 2021-2022, Metarock Inc., All rights Reserved.
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
