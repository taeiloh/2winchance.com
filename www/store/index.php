<?php
// config
require_once __DIR__ .'/../_inc/config.php';
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : 0;      // 세션 시퀀스


require_once __DIR__ .'/../libs/INIStdPayUtil.php';
$SignatureUtil = new INIStdPayUtil();

$price     = 55000;


$mid = "INIpayTest";  // 가맹점 ID(가맹점 수정후 고정)
//인증
$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성

$orderNumber = $mid . "_" . $SignatureUtil->getTimestamp(); // 가맹점 주문번호(가맹점에서 직접 설정)


$cardNoInterestQuota = "11-2:3:,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
$cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
//###################################
// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
//###################################
$mKey = $SignatureUtil->makeHash($signKey, "sha256");

$params = array(
    "oid" => $orderNumber,
    "price" => $price,
    "timestamp" => $timestamp
);
$sign = $SignatureUtil->makeSignature($params, "sha256");


try {

    //결제한도
    $query = "
        SELECT * FROM members
        WHERE 1
            AND m_idx = '{$idx}'
    ";
    $result = $_mysqli->query($query);
    $m_deposit = $result->fetch_array();
    $db_cash = !empty($m_deposit['m_limit_deposit']) ? $m_deposit['m_limit_deposit'] : 500000;

    $query2 = "
        SELECT sum(dh_deposit) as total_deposit FROM deposit_history
        WHERE 1 AND dh_u_idx = '{$idx}'
    ";
    $result2 = $_mysqli->query($query2);
    $_arrDeposit = $result2->fetch_array();
    $total_deposit = !empty($_arrDeposit['total_deposit']) ? $_arrDeposit['total_deposit'] : 0;
    print $total_deposit;


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

        <!--form id="SendPayForm_id" name="" method="POST" action="https://stdpay.inicis.com/payMain/pay">

            <input type="text"    name="goodname" id="goodname" value="" >
            <input type="text"    name="buyername" id="buyername" value="홍길동" >
            <input type="text"    name="buyertel" id="buyertel" value="010-1234-5678" >
            <input type="text"    name="buyeremail" id="buyeremail" value="<?=$id?>" >
            <input type="text"    name="price" id="price" value="11000" >
            <input type="hidden"  name="mid" value="INIpayTest" >
            <input type="text"  name="gopaymethod" id="gopaymethod" value="Card" >
            <input type="hidden"  name="mKey" value="3a9503069192f207491d4b19bd743fc249a761ed94246c8c42fed06c3cd15a33" >
            <input type="hidden"  name="signature" value="9e21ff2e1629e8f8dbf08a9c7aca2439c31c926b9102c03c16f025010a677480" >
            <input type="hidden"  name="oid" value="INIpayTest_1652678551157" >
            <input type="hidden"  name="timestamp" value="1652678551157" >
            <input type="hidden"  name="version" value="1.0" >
            <input type="hidden"  name="currency" value="상금" >
            <input type="hidden"  name="acceptmethod" value="CARDPOINT:va_receipt:HPP(1):below1000" >
            <input type="hidden"  name="returnUrl" value="http://d-www.2winchance.com/store/INIStdPayReturn.php" >
            <input type="hidden"  name="closeUrl" value="http://d-www.2winchance.com/store/close.php" >
            <input id="requestByJs" name="requestByJs" type="hidden" value="true">

        </form-->
        <form id="SendPayForm_id" name="" method="POST" action="https://stdpay.inicis.com/payMain/pay" accept-charset="UTF-8" target="iframe_13eae6eca05ff4">
            <input type="hidden" name="mid" value="INIpayTest">
            <input type="hidden" name="goodname" id="goodname" value="500c" spellcheck="false">
            <input type="hidden" name="price" id="price" value="55000" spellcheck="false" readonly="">
            <input type="hidden" name="buyername" id="buyername" value="길동이" spellcheck="false">
            <input type="hidden" name="buyertel" id="buyertel" value="010-1111-2222" spellcheck="false">
            <input type="hidden" name="buyeremail" value="<?=$id?>" placeholder="이메일을 입력하세요." spellcheck="false">
            <input type="hidden" name="acceptmethod" value="useescrow" spellcheck="false">

            <input type="hidden" name="version" value="1.0">
            <input type="hidden" name="currency" value="WON">
            <input type="hidden" name="gopaymethod" value="">
            <input type="hidden" name="oid" id="oid" value="<?=$orderNumber?>">
            <input type="hidden" name="timestamp" id="timestamp" value="<?=$timestamp?>">
            <input type="hidden" name="signature" id="sign" value="<?=$sign?>">
            <input type="hidden" name="mKey" id="mKey" value="<?=$mKey?>">
            <input type="hidden" name="returnUrl" value="https://<?=$_SERVER['SERVER_NAME']?>/store/INIStdPayReturn.php?id=<?=$idx?>">
            <input type="hidden" name="closeUrl" value="https://<?=$_SERVER['SERVER_NAME']?>/store/close.php">
            <input type="hidden"  name="acceptmethod" value="CARDPOINT:va_receipt:HPP(1):below1000" >

            <input id="requestByJs" name="requestByJs" type="hidden" value="true">
        </form>


        <!--content-->
        <div id="content" class="store">
            <!--sec-01-->
            <section class="sec sec-01 T0 ">
                <div class="inner store_title">
                    <h2>캐시 충전</h2>
                </div>
                <div-- class="contents-cont inner">
                    <div class="coin-charge">
                        <div>
                            <ul class="total-coin">
                                <li>총 결제금액</li>
                                <li id="total-money">55,000</li>
                            </ul>
                            <ul class="intend-charge">
                                <li>충전 예정</li>
                                <li class="fc-yellow"><span id="total-coin">500 <span class="fc-yellow">ⓒ</span></span></li>
                            </ul>
                            <ul>
                                <li>결제 알림 메일</li>
                                <li id="email"><?=$id?></li>
                            </ul>
                        </div>
                        <div class="coin-policy">
                            <p>가상 재화 정책 동의 </p>
                            <span>상품, 가격 및 유효기간을 확인하였으며,
                                계약 관련 고지 사항과 2Winchance
                                가상 재화 정책 및 결제 진행에
                                동의합니다.</span>
                            <p class="checkbox">
                                <input type="checkbox" class="" id="policy07">
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
                                    <a href="javascript:void(0);" data-money="1">
                                        <div class="coin-price">
                                            <!--                                            <span><img src="../images/10coin.svg" alt=""></span>-->
                                            <span>100ⓒ</span>
                                        </div>
                                        <div class="price-box"><p>11,000</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-money="2">
                                        <div class="coin-price">
                                            <!--                                            <span><img src="../images/50coin.svg" alt=""></span>-->
                                            <span>200ⓒ</span>
                                        </div>
                                        <div class="price-box"><p>22,000</p></div>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" data-money="3">
                                        <div class="coin-price">
                                            <!--                                            <span><img src="../images/100coin.svg" alt=""></span>-->
                                            <span>500ⓒ</span>
                                        </div>
                                        <div class="price-box"><p>55,000</p></div>
                                    </a>
                                </li>
                            </ul>
                            <ul class="amount-list">
                                <li>
                                    <a href="javascript:void(0);" data-money="4">
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
                                    <a href="javascript:void(0);" data-money="5">
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
                                    <a href="javascript:void(0);" data-money="6">
                                        <div class="coin-price">
                                            <p class="txt1">아머 이건2</p>
                                            <!--                                            <span><img src="../images/1000coin.svg" alt=""></span>-->
                                            <span>230ⓒ</span>
                                            <p class="txt2">1회 / 인</p>
                                        </div>
                                        <div class="price-box"><p>6,900</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-money="7">
                                        <div class="coin-price">
                                            <p class="txt1">아머 이건3</p>
                                            <!--                                            <span><img src="../images/1000coin.svg" alt=""></span>-->
                                            <span>3,220ⓒ</span>
                                            <p class="txt2">1회 / 인</p>
                                        </div>
                                        <div class="price-box"><p>9,500</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-money="8">
                                        <div class="coin-price">
                                            <p class="txt1">아머 이건4</p>
                                            <!--                                            <span><img src="../images/1000coin.svg" alt=""></span>-->
                                            <span>8,050ⓒ</span>
                                            <p class="txt2">1회 / 인</p>
                                        </div>
                                        <div class="price-box"><p>14,000</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-money="9">
                                        <div class="coin-price">
                                            <p class="txt1">보너스 팩</p>
                                            <!--                                            <span><img src="../images/1000coin.svg" alt=""></span>-->
                                            <span>8,050ⓒ</span>
                                            <p class="txt2">1회 / 인</p>
                                        </div>
                                        <div class="price-box"><p>16,000</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-money="10">
                                        <div class="coin-price ">
                                            <p class="txt1">월 구독</p>
                                            <!--                                            <span><img src="../images/1000coin.svg" alt=""></span>-->
                                            <div class="last">
                                                <span>10ⓒ /일</span>
                                                <span>1치장/ 일</span>
                                            </div>
                                            <p class="txt2">1회 / 인</p>
                                        </div>
                                        <div class="price-box"><p>20,000</p></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--div class="payby">
                            <h3>결제 수단</h3>
                            <div class="pay-container">
                                <ul class="tabs">
                                    <li class="tab-link current" data-tab="tab-1" >간편결제</li>
                                    <li class="tab-link current" data-tab="tab-2" data-value="Card">신용카드</li>
                                    <li class="tab-link" data-tab="tab-3" data-value="HPP">휴대폰</li>
                                    <li class="tab-link" data-tab="tab-4" data-value="DirectBank">온라인이체</li>
                                    <li class="tab-link" data-tab="tab-5" data-value="Culture">상품권류</li>
                                </ul>
                                <div id="tab-1" class="tab-content">
                                    <h4>간편결제는 결제하기 버튼을 눌러 선택하신 서비스의 결제 창에서 진행하세요</h4>
                                    <div class="payment-list">
                                        <p class="checkbox">
                                            <input type="checkbox" class="" id="kakaoPay">
                                            <label for="kakaoPay" class=""><img src="/images/kakaopay.png" alt="카카오페이"></label>
                                        </p>
                                        <p class="checkbox">
                                            <input type="checkbox" class="" id="toss">
                                            <label for="toss" class=""><img src="/images/toss.png" alt="토스"></label>
                                        </p>
                                        <p class="checkbox">
                                            <input type="checkbox" class="" id="payco">
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
                                </div>
                            </div>
                        </div-->
                    </div>
        </div>
        </section>
        <!--//sec-01-->
        <!--div class="pagination">
            <a href="javascript:void(0)">1</a>
            <a class="active" href="javascript:void(0)">2</a>
            <a href="javascript:void(0)">3</a>
            <a href="javascript:void(0)">4</a>
        </div-->
    </div>
    <!--//content-->
    <!--footer-->
    <footer id="footer">
        <?php
        //footer
        require_once __DIR__ .'/../common/footer.php';
        ?>
    </footer>
    <!--//footer-->
</div>
<!--//container-->


<script src="https://stdpay.inicis.com/stdjs/INIStdPay.js"></script>
<script src="https://stdux.inicis.com/stdpay/stdjs/INIStdPay_third-party.js"></script>

<script>

    function pay(){
        var check=$('#policy07').is(':checked');

        if(!check){
            alert("가상 재화 정책 동의를 해주세요.");
            $('#policy07').focus();
            return false;
        }

        var idx_check = '<?=$idx?>';

        //결제 한도
        var total_deposit = '<?=$total_deposit?>';

        if(total_deposit >= 500000){
            alert("결제가능한 월 잔여 한도를 초과하였습니다.");
            return false;
        }

        if(idx_check) {
            INIStdPay.pay('SendPayForm_id');
        }else{
            alert("로그인 이후 사용가능합니다.");
        }



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
            var money_id = $(this).data('money');

            $('ul.amount-list li').removeClass('active');

            $(this).parent('li').addClass('active');
            //$("#"+money_id).addClass('active');

            //alert(money_id);
            switch (money_id){
                case 1:
                    $("#goodname").val('100C');
                    $("#price").val(11000);
                    $("#total-coin").html( '100 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('11,000');
                    break;
                case 2:
                    $("#goodname").val('200C');
                    $("#price").val(22000);
                    $("#total-coin").html( '200 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('22,000');
                    break;
                case 3:
                    $("#goodname").val('500C');
                    $("#price").val(55000);
                    $("#total-coin").html( '500 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('55,000');
                    break;
                case 4:
                    $("#goodname").val('웰컴팩');
                    $("#price").val(4900);
                    $("#total-coin").html( '100 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('4,900');
                    break;
                case 5:
                    $("#goodname").val('아머 이건1');
                    $("#price").val(5900);
                    $("#total-coin").html( '210 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('5,900');
                    break;
                case 6:
                    $("#goodname").val('아머 이건2');
                    $("#price").val(6900);
                    $("#total-coin").html( '230 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('6,900');
                    break;
                case 7:
                    $("#goodname").val('아머 이건3');
                    $("#price").val(9500);
                    $("#total-coin").html( '3,220 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('9,500');
                    break;
                case 8:
                    $("#goodname").val('아머 이건4');
                    $("#price").val(14000);
                    $("#total-coin").html( '8,050 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('14,000');
                    break;
                case 9:
                    $("#goodname").val('보너스 팩');
                    $("#price").val(16000);
                    $("#total-coin").html( '8,050 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('16,000');
                    break;

                case 10:
                    $("#goodname").val('월 구독');
                    $("#price").val(20000);
                    $("#total-coin").html( '10 <span class="fc-yellow">ⓒ</span>');
                    $("#total-money").text('20,000');
                    break;
            }
            var price=$("#price").val();


            var postData = {
                "price": price
            };

            $.ajax({
                url: "signature_proc.php",
                type: "POST",
                async: false,
                data: postData,
                success: function (data) {
                    var json = JSON.parse(data);
                    console.log(json);
                    if (json.code == 200) {
                        $("#oid").val(json.oid);
                        $("#price").val(json.price);
                        $("#timestamp").val(json.timestamp);
                        $("#sign").val(json.sign);
                        $("#mKey").val(json.mKey);
                        //alert("결제가 완료되었습니다.");
                    }else{
                        console.log(json);
                        alert(json.msg);
                    }
                },
                beforeSend:function(){
                    $(".wrap-loading").removeClass("display-none");
                },
                complete:function(){
                    $(".wrap-loading").addClass("display-none");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });


        })
    })

</script>
</div>
</body>
</html>
