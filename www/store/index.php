<?php
// config
require_once __DIR__ .'/../_inc/config.php';



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
                                <li>55,000</li>
                            </ul>
                            <ul class="intend-charge">
                                <li>충전 예정</li>
                                <li class="fc-yellow"><span class="coin">500</span></li>
                            </ul>
                            <ul>
                                <li>결제 알림 매일</li>
                                <li>abC1234@naver.com</li>
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
                            <button class="btn-blue btn-8">결제하기</button>
                        </div>
                    </div>
                    <div class="pay-method">
                        <div class="pay-amount">
                            <h3>결제 금액</h3>
                            <ul class="amount-list">
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <span><img src="/images/10coin.svg" alt=""></span>
                                        </div>
                                        <div class="price-box"><p>1,100</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <span><img src="/images/50coin.svg" alt=""></span>
                                        </div>
                                        <div class="price-box"><p>5,500</p></div>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <span><img src="/images/100coin.svg" alt=""></span>
                                        </div>
                                        <div class="price-box"><p>1,1000</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <span><img src="/images/200coin.svg" alt=""></span>
                                        </div>
                                        <div class="price-box"><p>2,2000</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <span><img src="/images/500coin.svg" alt=""></span>
                                        </div>
                                        <div class="price-box"><p>5,5000</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="coin-price">
                                            <span><img src="/images/1000coin.svg" alt=""></span>
                                        </div>
                                        <div class="price-box"><p>110,000</p></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="payby">
                            <h3>결제 수단</h3>
                            <div class="pay-container">
                                <ul class="tabs">
                                    <li class="tab-link current" data-tab="tab-1">간편결제</li>
                                    <li class="tab-link" data-tab="tab-2">신용카드</li>
                                    <li class="tab-link" data-tab="tab-3">휴대폰</li>
                                    <li class="tab-link" data-tab="tab-4">온라인이체</li>
                                    <li class="tab-link" data-tab="tab-5">상품권류</li>
                                </ul>
                                <div id="tab-1" class="tab-content current">
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
                                <div id="tab-2" class="tab-content">
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
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('html_element', {
                'sitekey' : 'your_site_key'
            });
        };

        $(document).ready(function(){

            $('ul.tabs li').click(function(){
                var tab_id = $(this).attr('data-tab');

                $('ul.tabs li').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#"+tab_id).addClass('current');
            })

        })

    </script>
</div>
</body>
</html>