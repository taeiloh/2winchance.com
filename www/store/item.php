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
                    <h2>아이템 구매</h2>
                </div>
                <div class="contents-cont inner">
                    <div class="current-coin">
                        <ul class="coin-list">
                            <li>보유코인</li>
                            <li class="fc-yellow"><span></span>695,165,300 <span class="fc-yellow">ⓒ</span></li>
                        </ul>
                        <ul class="coin-input">
                            <li>아이템</li>
                            <li><label><input type="radio" name="type" value="type1" checked>치장형</label></li>
                            <li><label><input type="radio" name="type" value="type2">편의형</label></li>
                            <li><label><input type="radio" name="type" value="type3">스페셜</label></li>
                        </ul>
                        <button class="btn-blue btn-8">구매하기</button>
                    </div>

                    <div class="store-item-list prepare" id="sp" style="display: none;">
                        <p>제품 준비중</p>
                    </div>
                    <div class="store-item-list" id="chi" style="">
                        <ul>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_00.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>전투사관학교 교수님</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>

                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_02.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>이중용 불리베어</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_03.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>동물특공대 메가 </p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_04.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>K/D ALL OUT 카이샤</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_00.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>전투사관학교 교수님</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_02.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>이중용 불리베어</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_03.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>동물특공대 메가 </p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_04.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>K/D ALL OUT 카이샤</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_00.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>전투사관학교 교수님</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_02.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>이중용 불리베어</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_03.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>동물특공대 메가 </p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="item-pic">
                                        <img src="../images/item_04.png" alt="">
                                        <p class="get-point fp">+100</p>
                                    </div>
                                    <div class="cash-item-desc">
                                        <p>K/D ALL OUT 카이샤</p>
                                        <span>10 <span class="fc-yellow">ⓒ</span></span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

            </section>
            <!--//sec-01-->
            <div class="pagination">
                <a class="active" href="javascript:void(0)">1</a>
                <a href="javascript:void(0)">2</a>
                <!--a href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">3</a>
                <a href="javascript:void(0)">4</a>
                <a href="javascript:void(0)">4</a-->
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
        $(function(){
            $('input[type=radio][name=type]').change(function() {
                if (this.value == 'type1') {
                    $("#sp").css("display","none");
                    $("#chi").css("display","flex");
                }else {
                    $("#chi").css("display","none");
                    $("#sp").css("display","flex");
                }
            });
        });

    </script>
</div>
</body>
</html>
