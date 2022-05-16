<?php
// config
require_once __DIR__ .'/../_inc/config.php';
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디


try {

} catch (Exception $e) {
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
<div id="wrap" class="sub">
    <!--header-->
    <header id="header">
        <?php
        //header
        require_once __DIR__ .'/../common/header.php';
        ?>
    </header>
    <!--//header-->

    <!--container-->
    <div id="container">

        <form id="SendPayForm_id" name="" method="POST" >

            <input type="text"    name="goodname" id="goodname" value="" >
            <input type="text"    name="buyername" id="buyername" value="홍길동" >
            <input type="text"    name="buyertel" id="buyertel" value="010-1234-5678" >
            <input type="text"    name="buyeremail" id="buyeremail" value="<?=$id?>" >
            <input type="text"    name="price" id="price" value="11000" >
            <input type="hidden"  name="mid" value="INIpayTest" ><!-- 에스크로테스트 : iniescrow0, 빌링(정기과금)테스트 : INIBillTst -->
            <input type="text"  name="gopaymethod" id="gopaymethod" value="Card" >
            <input type="hidden"  name="mKey" value="3a9503069192f207491d4b19bd743fc249a761ed94246c8c42fed06c3cd15a33" >
            <input type="hidden"  name="signature" value="9e21ff2e1629e8f8dbf08a9c7aca2439c31c926b9102c03c16f025010a677480" >
            <input type="hidden"  name="oid" value="INIpayTest_1652678551157" >
            <input type="hidden"  name="timestamp" value="1652678551157" >
            <input type="hidden"  name="version" value="1.0" >
            <input type="hidden"  name="currency" value="WON" >
            <input type="hidden"  name="acceptmethod" value="CARDPOINT:va_receipt:HPP(1):below1000" ><!-- 에스크로옵션 : useescrow, 빌링(정기과금)옵션 : BILLAUTH(Card) -->
            <input type="hidden"  name="returnUrl" value="http://d-www.2winchance.com/store/INIStdPayReturn.php" >
            <input type="hidden"  name="closeUrl" value="http://localhost/stdpay/close.asp" >

        </form>


        <!--content-->
        <div id="content" class="store">
            <!--sec-01-->
            <section class="sec sec-01 T0 ">
                <div class="inner store_title">
                    <h2>캐시 아이템</h2>
                </div>
                <div class="contents-cont inner">
                    <div class="coin-charge">
                        <div>
                            <ul class="total-coin">
                                <li>총 결제금액</li>
                                <li id="total-money">55,000</li>
                            </ul>
                            <ul class="intend-charge">
                                <li>충전 예정</li>
                                <li class="fc-yellow"><span>500 <span class="fc-yellow">ⓒ</span></span></li>
                            </ul>
                            <ul>
                                <li>결제 알림 매일</li>
                                <li id="email"><?=$id?></li>
                            </ul>
                        </div>
                        <div class="coin-policy">
                            <p>가상 재화 정책 동의 </p>
                            <span>상품, 가격 및 유효기간을 확인하였으며,
                                계약 관련 고지 사항과 To Win Chance
                                가상 재화 정책 및 결제 진행에
                                동의합니다.</span>
                            <p class="checkbox">
                                <input type="checkbox" class="" id="policy07" checked="checked">
                                <label for="policy07" class="">동의합니다.</label>
                            </p>
                            <button type="button" class="btn-blue btn-8" onclick="pay()">결제하기</button>
                        </div>
                    </div>
                    <div class="pay-method">
                        <div class="pay-amount">
                            <h3>결제 금액</h3>
                            <ul class="amount-list">
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <!--                                            <span><img src="../images/10coin.svg" alt=""></span>-->
                                            <span>100ⓒ</span>
                                        </div>
                                        <div class="price-box"><p>11,000</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <!--                                            <span><img src="../images/50coin.svg" alt=""></span>-->
                                            <span>200ⓒ</span>
                                        </div>
                                        <div class="price-box"><p>22,000</p></div>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <!--                                            <span><img src="../images/100coin.svg" alt=""></span>-->
                                            <span>500ⓒ</span>
                                        </div>
                                        <div class="price-box"><p>55,000</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <p class="txt1">웰컴팩</p>
                                            <!--                                            <span><img src="../images/200coin.svg" alt=""></span>-->
                                            <span>100ⓒ</span>
                                            <p class="txt2">1회 / 인</p>
                                        </div>
                                        <div class="price-box"><p>4,900</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <p class="txt1">아머 이건1</p>
                                            <!--                                            <span><img src="../images/500coin.svg" alt=""></span>-->
                                            <span>210ⓒ</span>
                                            <p class="txt2">1회 / 인</p>
                                        </div>
                                        <div class="price-box"><p>5,900</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <p class="txt1">아머 이건2</p>
                                            <!--                                            <span><img src="../images/1000coin.svg" alt=""></span>-->
                                            <span>3,220ⓒ</span>
                                            <p class="txt2">1회 / 인</p>
                                        </div>
                                        <div class="price-box"><p>9,500</p></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="payby">
                            <h3>결제 수단</h3>
                            <div class="pay-container">
                                <ul class="tabs">
                                    <!--li class="tab-link current" data-tab="tab-1" >간편결제</li-->
                                    <li class="tab-link current" data-tab="tab-2" data-value="Card">신용카드</li>
                                    <li class="tab-link" data-tab="tab-3" data-value="HPP">휴대폰</li>
                                    <li class="tab-link" data-tab="tab-4" data-value="DirectBank">온라인이체</li>
                                    <li class="tab-link" data-tab="tab-5" data-value="Culture">상품권류</li>
                                </ul>
                                <!--div id="tab-1" class="tab-content">
                                    <h4>간편결제는 결제하기 버튼을 눌러 선택하신 서비스의 결제 창에서 진행하세요</h4>
                                    <div class="payment-list">
                                        <p class="checkbox">
                                            <input type="checkbox" class="" id="kakaoPay" checked="checked">
                                            <label for="kakaoPay" class=""><img src="/images/kakaopay.png" alt="카카오페이"></label>
                                        </p>
                                        <p class="checkbox">
                                            <input type="checkbox" class="" id="toss" checked="checked">
                                            <label for="toss" class=""><img src="/images/toss.png" alt="토스"></label>
                                        </p>
                                        <p class="checkbox">
                                            <input type="checkbox" class="" id="payco" checked="checked">
                                            <label for="payco" class=""><img src="/images/payco.png" alt="페이코"></label>
                                        </p>
                                    </div>
                                    <ul>
                                        <li>결제를 위해서는 카카오톡 또는 카카오페이 모바일 앱이 필요합니다.</li>
                                        <li>카카오페이 고객센터 : 1644-7405 </li>
                                    </ul>
                                </div>
                                <div id="tab-2" class="tab-content current">
                                    신용카드 내용이 들어갑니다
                                </div>
                                <div id="tab-3" class="tab-content">
                                    휴대폰 내용이 들어갑니다
                                </div>
                                <div id="tab-4" class="tab-content">
                                    온라인이체 내용이 들어갑니다
                                </div>
                                <div id="tab-5" class="tab-content">
                                    상품권류 내용이 들어갑니다
                                </div-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <a href="javascript:void(0)">1</a>
                <a class="active" href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">3</a>
                <a href="javascript:void(0)">4</a>
            </div>
        </div>
        <!--//content-->
    </div>
    <!--//container-->

    <!--footer-->
    <footer id="footer">
        <?php
        //footer
        require_once __DIR__ .'/../common/footer.php';
        ?>
    </footer>
    <!--//footer-->
    <script src="https://stdux.inicis.com/stdpay/stdjs/INIStdPay_third-party.js"></script>
    <script src="https://stdpay.inicis.com/stdjs/INIStdPay.js"></script>
    <script>

        function pay(){
            var check=$('#policy07').is(':checked');

            if(!check){
                alert("가상 재화 정책 동의를 해주세요.");
                $('#policy07').focus();
                return false;
            }

            INIStdPay.pay('SendPayForm_id');
        }


        $(document).ready(function(){

            $('ul.tabs li').click(function(){
                var tab_id = $(this).attr('data-tab');
                var id = $(this).attr('data-value');
                //alert(id);
                $("#gopaymethod").val(id);

                $('ul.tabs li').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#"+tab_id).addClass('current');
            })

            $('ul.amount-list li a').click(function(){
                var money_id = $(this).data('monay');

                $('ul.amount-list li').removeClass('active');

                $(this).parent('li').addClass('active');
                //$("#"+money_id).addClass('active');

                switch (money_id){
                    case 1:
                        $("#goodname").val('10C');
                        $("#price").val(1100);
                        $("#total-coin").text('10');
                        $("#total-money").text('1,100');
                        break;
                    case 2:
                        $("#goodname").val('50C');
                        $("#price").val(5500);
                        $("#total-coin").text('50');
                        $("#total-money").text('5,500');
                        break;
                    case 3:
                        $("#goodname").val('100C');
                        $("#price").val(11000);
                        $("#total-coin").text('100');
                        $("#total-money").text('11,000');
                        break;
                    case 4:
                        $("#goodname").val('200C');
                        $("#price").val(22000);
                        $("#total-coin").text('200');
                        $("#total-money").text('22,000');
                        break;
                    case 5:
                        $("#goodname").val('500C');
                        $("#price").val(55000);
                        $("#total-coin").text('500');
                        $("#total-money").text('55,000');
                        break;
                    case 6:
                        $("#goodname").val('1000C');
                        $("#price").val(110000);
                        $("#total-coin").text('1000');
                        $("#total-money").text('110,000');
                        break;
                }


            })

        })

    </script>
</div>
</body>
</html>