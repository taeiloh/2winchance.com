<?php
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임
//$deposit=!empty($_SESSION['_se_deposit']) ? $_SESSION['_se_deposit'] : 0;    // 세션 포인트
//$fp=!empty($_SESSION['_se_fp']) ? $_SESSION['_se_fp'] : 0; // fantasy-point 잔액

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

    //진행 중 문의 총 갯수
    $querycon = "
        SELECT count(*)
        FROM contactus
        WHERE 1 AND cu_u_idx = '{$idx}'
    ";
    //print $querycon;
    $conresult= mysqli_query($_mysqli,$querycon);
    $conrow = mysqli_fetch_row($conresult);
    $my_contactus=$conrow[0];


    $query2 = "
    SELECT *
        FROM members
        WHERE 1 and m_idx ='{$idx}'
    ";
    $mresult = $_mysqli->query($query2);
    $_arrMembers = $mresult->fetch_array();
    $m_sns_type = !empty($_arrMembers['m_sns_type']) ? $_arrMembers['m_sns_type'] : '';
    $m_fp = !empty($_arrMembers['m_fp_balance']) ? $_arrMembers['m_fp_balance'] : 0;
    $m_deposit = !empty($_arrMembers['m_deposit']) ? $_arrMembers['m_deposit'] : 0;

    $queryhp ="
        SELECT *
        FROM honor_point_history
        WHERE 1 and m_idx ='{$idx}'
    ";
    $hpresult = $_mysqli->query($queryhp);
    $dbhp = $hpresult->fetch_assoc();
    $hp = !empty($dbhp['hph_balance']) ? $dbhp['hph_balance'] : 0;

    //dh_amount 총합
    $querycoin = "
        SELECT sum(dh_amount) as total_amount FROM deposit_history
        WHERE 1 AND dh_u_idx = '{$idx}'
   ";
    $resultcoin = $_mysqli->query($querycoin);
    $_arrCoin = $resultcoin->fetch_array();
    $total_coin = !empty($_arrCoin['total_amount']) ? $_arrCoin['total_amount'] : 0;
    print $total_coin;


    $page = !empty($_GET['page']) ? $_GET['page'] : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    $sql ="select count(*) from item where 1=1 ";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 30;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    $query3  = "
        SELECT *
        FROM m_item INNER JOIN item ON i_num = m_num and m_idx = '{$idx}' group by m_num
        ORDER BY m_num DESC
        LIMIT {$from_record}, {$rows}
    ";
    $result3 = $_mysqli->query($query3);

    $query3c  = "
    SELECT count(*) FROM m_item INNER JOIN item ON i_num = m_num and m_idx = '{$idx}'";
    $result3c = mysqli_query($_mysqli, $query3c);
    $row3c   = mysqli_fetch_row($result3c);
    $r3c= $row3c[0]; //전체갯수
    //echo $r3c."<br>";

    $query3_1  = "
        SELECT m_num FROM m_item INNER JOIN item ON i_num = m_num and m_idx = '{$idx}'";
    $result3_1 = $_mysqli->query($query3_1);
    $i_num_a="";
    for($i=0;$row=mysqli_fetch_array($result3_1);$i++){
        $z=$i+1;
        if($r3c==$z){
            $i_num_a .="'".$row['m_num']."'";
        }else{
            $i_num_a .="'".$row['m_num']."',";
        }

    }

    if($r3c==0)
    {
        $query3_2  = "
        SELECT *
        FROM  item where 1=1";
    }else{
        $query3_2  = "
            SELECT *
            FROM  item where 1=1 and i_num NOT IN ({$i_num_a})
        ";
    }
    //echo $query3_2;
    $result3_2 = $_mysqli->query($query3_2);


    $query4 = "SELECT i_src FROM m_item WHERE main_emblem =1 and m_idx = '{$idx}'";
    $result4 = $_mysqli->query($query4);
    $main = $result4 ->fetch_array();
    $main_src = !empty($main['i_src']) ? $main['i_src'] : 0;

    $query5 = "SELECT COUNT(i_src) FROM m_item WHERE  m_idx = '{$idx}'";
    $result5 = $_mysqli->query($query5);
    $CNT= $result5->fetch_array();
    $ITEM_CNT = $CNT[0];



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
                         <div class="box-right">
                            <div class="pf-pic">
                                <img id="main_item" src="<?=$main_src?>" alt="profile">
                                <button type="button" class="emblem" id="main_emblem" onclick="emblem_change()">
                                <p>엠블럼 저장하기</p>
                                </button>
                            </div>
                            <a href="setting_time.php" class="play-limit">게임입장 제한시간 설정</a>
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
                                    <?php
                                    if($id){
                                        ?>
                                        <dd><a href="../signup/pwd_change.php">비밀번호 변경하기</a></dd>
                                        <dd><a href="/remove/index.php">회원 탈퇴하기</a></dd>
                                        <?php
                                    }else{?>
                                        <dd>비밀번호 변경불가</dd>
                                        <dd><a href="/remove/RemoveAccept.php">회원 탈퇴하기</dd></a>
                                        <?php
                                    }?>

                                </dl>
                                    <button class="cash-limit" onclick="<?php if($id!=""){?>location.href='setting_pw.php'<?php }else{?>location.href='setting_cash.php'<?php }?>">캐시 구매 잔여 한도 내역 | FP 사용 제한 설정</button>

                            </div>
                        </div>
                        <div class="user-detail-info">
                            <h3>상세정보</h3>
                            <ul>
                                <li><p>캐시</p><span class="fc-yellow coin"><?=number_format($total_coin)?></span></li>
                                <li><p>파이트 포인트</p><span class="fp"><?=number_format($m_fp)?></span></li>
                                <!--                                <li><p>명예 포인트</p><span class="hp">--><?//=$dbhp['pg_amount']?><!--</span></li>-->
                                <li><p>누적 전투력</p><span class="hp"><?=number_format($hp)?></span></li>
                                <li><p>진행 중 문의</p><span class="count"><?=$my_contactus?></span></li>
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
                            <ul class="user-item">
                                <?php
                                if($total_count > 0){
                                    $i=0;
                                    while($_db = $result3 -> fetch_assoc()){
                                        $i_price = $_db['i_price'];
                                        $i_type = $_db['i_type'];
                                        $i_fp = $_db['i_fp'];
                                        $i_src = $_db['i_src'];
                                        $i_name = $_db['i_name'];
                                        $i_num = $_db['i_num'];
                                        $m_num = $_db['m_num'];
                                        $i++;
                                        $no=$total_count-($i+($page-1)*$rows);

                                        $query6 = "SELECT count(m_num) from m_item where m_num = '{$i_num}' and m_idx='{$idx}' group by m_num";
                                        $result6 = $_mysqli->query($query6);
                                        $groupitemcnt = $result6->fetch_array();
                                        $GRUOP_ITEM_CNT = $groupitemcnt[0];
                                        ?>
                                            <li>
                                                <a href="javascript:void(0);" data-item = "<?=$i_num?>" data-src = "<?=$i_src?>" >
                                                    <img src="<?=$i_src?>" alt="">
                                                </a>
                                                <span class="item-count"><?=$GRUOP_ITEM_CNT?></span>
                                            </li>
                                            <?php
                                    }
                                }
                                else{?>
                                    <div class="store-item-list prepare" id="sp" style="display: none;">
                                        <p>제품 준비중</p>
                                    </div>
                                    <?php
                                }
                                $result3->free();
                                ?>
                                <?php
                                if($total_count > 0){
                                $i=0;
                                    while($_db = $result3_2 -> fetch_assoc()){
                                        $i_price = $_db['i_price'];
                                        $i_type = $_db['i_type'];
                                        $i_fp = $_db['i_fp'];
                                        $i_src = $_db['i_src'];
                                        $i_name = $_db['i_name'];
                                        $i_num = $_db['i_num'];
                                        $no=$total_count-($i+($page-1)*$rows);
                                       ?>
                                            <li class="disabled">
                                                <a href="javascript:void(0);" data-item = "<?=$i_num?>" data-src = "<?=$i_src?>" >
                                                    <img src="<?=$i_src?>" alt="">
                                                </a>
                                                <span class="item-count">0</span>
                                            </li>
                                            <?php
                                    }
                                }
                                else{?>
                                    <p>제품준비중</p>
                                <?php
                                }
                                $result3_2->free();
                                ?>
                            </ul>
                        </div>

                        <div class="user-item-list item-ex scroll" id="typeB" style="display: none;">
                                    <p>보유한 아이템이 없습니다.</p>
<!--                            <ul>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                            </ul>-->
                        </div>

                        <div class="user-item-list item-ex scroll" id="typeC" style="display: none;">
                            <p>보유한 아이템이 없습니다.</p>
<!--                            <ul>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="javascript:void (0);"><img src="../images/item_bg.png" alt=""></a>-->
<!--                                    <div class="item-descript">-->
<!--                                        <div class="item-tit">-->
<!--                                            <p>상품명</p>-->
<!--                                            <span class="fc-yellow">가격</span>-->
<!--                                        </div>-->
<!--                                        <p>상세설명</p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                            </ul>-->
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
        var buy_item_id = 0;
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
        $(document).ready(function(){
            <?php
            if ($main_src==""){
                ?>
            $("#main_item").css("display", "none");
                <?php
            }

            ?>

            $('ul.user-item li a').click(function(){
                var item_id = $(this).data('item');
                var main_item_src = $(this).data('src');
                $('ul.user-item li').removeClass('active');
                $(this).parent('li').addClass('active');
                buy_item_id = item_id;

                $("#main_item").attr("src",main_item_src);
                $("#main_item").css("display", "block");


            })
        })
        function emblem_change() {
            if (confirm("해당엠블럼을 메인엠블럼으로 지정하시겠습니까?")) {
                var postData = {
                    "m_num": buy_item_id,
                };

                $.ajax({
                    url: "selected_item.php",
                    type: "POST",
                    async: false,
                    data: postData,
                    success: function (data) {
                        var json = JSON.parse(data);
                        console.log(json);
                        if (json.code == 200) {
                            alert(json.msg);
                            location.reload();
                        } else {
                            alert(json.msg);
                            console.log(json);
                        }
                    },
                    beforeSend: function () {
                        $(".wrap-loading").removeClass("display-none");
                    },
                    complete: function () {
                        $(".wrap-loading").addClass("display-none");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
            else{
                alert("엠블럼 변경을 취소하였습니다");
            }
        }

    </script>
</div>
</body>
</html>
