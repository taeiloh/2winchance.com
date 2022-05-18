<?php
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임
$deposit=!empty($_SESSION['_se_deposit']) ? $_SESSION['_se_deposit'] : 0;    // 세션 포인트
$fp=!empty($_SESSION['_se_fp']) ? $_SESSION['_se_fp'] : 0; // fantasy-point 잔액

if (!$idx) {
    $url    = $_SERVER['REQUEST_URI'];
    $msg    = '로그인 페이지로 이동합니다.';
    $url    = '/login/index.php?rtnUrl='. $url;
    alertReplace($msg, $url);
    exit;
}
try {
    $sql = "select count(*) from contactus where 1=1 and cu_u_idx = '{$idx}'";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수

    $query = "
        SELECT *
        FROM contactus
        WHERE 1 and cu_u_idx ='{$idx}'
    ";

    $result = $_mysqli->query($query);

    $query2 = "
    SELECT *
        FROM members
        WHERE 1 and m_idx ='{$idx}'
    ";
    $mresult = $_mysqli->query($query2);
    $_arrMembers = $mresult->fetch_array();
    $m_sns_type = !empty($_arrMembers['m_sns_type']) ? $_arrMembers['m_sns_type'] : '';

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
        <div id="content" class="myqna">
            <!--sec-01-->
            <section class="sec sec-01 T0 myAcct">
                <?php
                //header
                require_once __DIR__ . '/../common/category.php';
                ?>
<!--                <div class="category inner">-->
<!--                    <ul>-->
<!--                        <li><a href="javascript:void(0)">MY ACCOUNT</a></li>-->
<!--                        <li class="active"><a href="javascript:void(0)">1 : 1 HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">CASH HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">FP HISTORY</a></li>-->
<!--                        <li><a href="javascript:void(0)">HOW TO PLAY</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="contents-cont inner item-page">
                    <div class="user-acct">
                        <div class="user-profile">
                            <div class="pf-pic">
                                <img src="../images/item1.png" alt="profile">
                            </div>
                            <div class="pf-info">
                                <ul>
                                    <li>닉네임</li>
                                    <li><?=$name?></li>
                                </ul>
                                <ul>
                                    <?php
                                    if($id){
                                        ?>
                                        <li>E-MAIL </li>
                                        <li><?=$id?></li>
                                        <?php
                                    }else{?>
                                        <li>계정타입 </li>
                                        <li><?=$m_sns_type?> 계정</li>
                                        <?php
                                    }?>
                                </ul>
                                <dl>
                                    <dt>비밀번호 변경하기</dt>
                                    <?php
                                    if($id){
                                    ?>
                                        <a href="/remove/index.php"><dd>회원 탈퇴하기</dd></a>
                                    <?php
                                    }else{?>
                                        <a href="/remove/RemoveAccept.php"><dd>회원 탈퇴하기</dd></a>
                                    <?php
                                    }?>
                                </dl>
                            </div>
                        </div>
                        <div class="user-detail-info">
                            <h3>상세정보</h3>
                            <ul>
                                <li><p>COIN</p><span class="fc-yellow coin"><?=$deposit?></span></li>
                                <li><p>Fantasy Point</p><span class="fp"><?=$fp?></span></li>
                                <li><p>문의내역</p><span class="count"><?=$total_count?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-item">
                        <div class="item-list">
                            <label><input type="radio" name="type" value="type1" id="type1" checked>치장형</label>
                            <label><input type="radio" name="type" value="type2" id="type2">편의형</label>
                            <label><input type="radio" name="type" value="type3" id="type3">스페셜</label>
                        </div>
                        <div class="user-item-list scroll" id="typeA">
                            <ul>
                                <li class="active"><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li class="disabled"><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item2.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item4.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item5.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="../images/item6.png" alt=""></a></li>
                            </ul>
                        </div>

                        <div class="user-item-list item-ex scroll" id="typeB" style="display: none;">
                            <ul>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="user-item-list item-ex scroll" id="typeC" style="display: none;">
                            <ul>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>
                                    <div class="item-descript">
                                        <div class="item-tit">
                                            <p>상품명</p>
                                            <span class="fc-yellow">가격</span>
                                        </div>
                                        <p>상세설명</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!--//sec-01-->
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

        $(function(){
            $("#type1").click(function (){
                $("#typeA").show();
                $("#typeB").hide();
                $("#typeC").hide();
            });
            $("#type2").click(function (){
                $("#typeA").hide();
                $("#typeB").show();
                $("#typeC").hide();
            });
            $("#type3").click(function (){
                $("#typeA").hide();
                $("#typeB").hide();
                $("#typeC").show();
            });
        })


    </script>
</div>
</body>
</html>