<?php
// config
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$fp=!empty($_SESSION['_se_fp']) ? $_SESSION['_se_fp'] : 0; // fantasy-point 잔액

try {
    $query2 = "
    SELECT *
        FROM members
        WHERE 1 and m_idx ='{$idx}'
    ";
    $mresult = $_mysqli->query($query2);

    //dh_amount 총합
    $querycoin = "
        SELECT sum(dh_amount) as total_amount FROM deposit_history
        WHERE 1 AND dh_u_idx = '{$idx}'
   ";
    $resultcoin = $_mysqli->query($querycoin);
    $_arrCoin = $resultcoin->fetch_array();
    $total_coin = !empty($_arrCoin['total_amount']) ? $_arrCoin['total_amount'] : 0;

    $page = !empty($_GET['page']) ? $_GET['page'] : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    $sql ="select count(*) from item where 1=1";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 8;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    $query  = "
        SELECT *
        FROM item
        WHERE 1
        ORDER BY i_num DESC
        LIMIT {$from_record}, {$rows}
    ";

    $result2 = $_mysqli->query($query);
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
                            <li>보유 캐시</li>
                            <li class="fc-yellow"><span></span><?=number_format($total_coin)?><span class="fc-yellow">ⓒ</span></li>
                        </ul>
                        <ul class="coin-input">
                            <li>아이템</li>
                            <li><label><input type="radio" name="type" value="type1" checked>치장형 (환불불가)</label></li>
                            <li><label><input type="radio" name="type" value="type2">편의형 (환불불가)</label></li>
                            <li><label><input type="radio" name="type" value="type3">스페셜 (환불불가)</label></li>
                        </ul>
                        <p> ---주의 사항----<br>
                            치장형(앰블럼 스킨) 아이템 입니다.<br>
                            본 아이템은 마이페이지의 프로필 변경을 통해 적용 및 교체가 가능합니다.<br>
                            사용자간 거래가 불가하며 중복 보유가 가능합니다.<br>
                        <p class="fc-red">스토어에서 구매한 모든 아이템은 환불 및 교환이 불가능합니다.<br>
                            구매 시 주의를 부탁드립니다.<br></p>
                        <p class="fc-yellow event-list fs-28 bold mT30" id="buy_cash">사용 캐시 <span>ⓒ</span></p>
                        <button class="btn-blue btn-8" onclick="buy()">구매하기</button>
                    </div>

                    <div class="store-item-list prepare" id="sp" style="display: none;">
                        <p>제품 준비중</p>
                    </div>
                    <div class="store-item-list" id="chi" style="">
                        <ul class="buy-item-list">
                            <?php
                            if($total_count > 0){
                                $i=0;
                                while($_db = $result2 -> fetch_assoc()){
                                    $i_price = $_db['i_price'];
                                    $i_type = $_db['i_type'];
                                    $i_fp = $_db['i_fp'];
                                    $i_src = $_db['i_src'];
                                    $i_name = $_db['i_name'];
                                    $i_num = $_db['i_num'];
                                    $i++;
                                    $no=$total_count-($i+($page-1)*$rows);
                                    if($i==1){?>
                                        <li>
                                            <a href="javascript:void(0);" data-item = "<?=$i_num?>" data-price ="<?=$i_price?>" data-fp="<?=$i_fp?>" data-src ="<?=$i_src?>">
                                                <div class="item-pic">
                                                    <img src="<?=$i_src?>" alt="">
                                                    <p class="get-point fp" id="SOLD_OUT<?=$i_num?>">+<?=$i_fp?></p>
                                                </div>
                                                <div class="cash-item-desc">
                                                    <p><?=$i_name?></p>
                                                    <span><?=$i_price?><span class="fc-yellow">ⓒ</span></span>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                    }else{
                                        ?>
                                        <li>
                                            <a href="javascript:void(0);" data-item = "<?=$i_num?>" data-price ="<?=$i_price?>" data-fp="<?=$i_fp?>" data-src ="<?=$i_src?>">
                                                <div class="item-pic">
                                                    <img src="<?=$i_src?>" alt="">
                                                    <p class="get-point fp" id="SOLD_OUT<?=$i_num?>">+<?=$i_fp?></p>
                                                    <!-- <?php
                                                    /*                                                    if($i_status == 1){*/?>
                                                        <p class="get-point" id="SOLD_OUT<?/*=$i_num*/?>">SOLD OUT</p>
                                                        <?php
                                                    /*                                                    } else{*/?>
                                                        <p class="get-point fp" id="SOLD_OUT<?/*=$i_num*/?>">+<?/*=$i_fp*/?></p>
                                                        --><?php
                                                    /*                                                    }*/?>
                                                </div>
                                                <div class="cash-item-desc">
                                                    <p><?=$i_name?></p>
                                                    <span><?=$i_price?><span class="fc-yellow">ⓒ</span></span>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                            }
                            else{?>
                                <div class="store-item-list prepare" id="sp" style="display: none;">
                                    <p>제품 준비중</p>
                                </div>
                                <?php
                            }
                            $result2->free();
                            ?>
                        </ul>
                    </div>

            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?php
                echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                ?>
                <!--<a class="active" href="javascript:void(0)">1</a>-->
                <!--<a href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">2</a>
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
    <script>
        var buy_item_id = 0;
        var buy_item_price =0;
        var buy_item_fp=0;
        var buy_item_src='';
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
        $(document).ready(function(){
            $('ul.buy-item-list li a').click(function(){
                var item_id = $(this).data('item');
                var item_price = $(this).data('price');
                var item_fp = $(this).data('fp');
                var item_src = $(this).data('src');
                $('ul.buy-item-list li').removeClass('active');
                $(this).parent('li').addClass('active');
                $("#buy_cash").html("사용 캐시 &nbsp&nbsp&nbsp&nbsp&nbsp"+item_price+" <span>ⓒ</span>");


                buy_item_id = item_id;
                buy_item_price = item_price;
                buy_item_fp = item_fp;
                buy_item_src = item_src;
            })
        })

        function buy(){
            if(confirm("해당아이템을 구매하시겠습니까?\n아이템을 구매하시면 환불 및 교환이 불가능합니다."))
            {
                if(<?=$total_coin?> >= buy_item_price) {
                    if (buy_item_id > 0) {
                        var postData = {
                            "m_num": buy_item_id,
                            "price": buy_item_price,
                            "fp": buy_item_fp,
                            "i_src": buy_item_src
                        };
                        $.ajax({
                            url: "insert_item.php",
                            type: "POST",
                            async: false,
                            data: postData,
                            success: function (data) {
                                //console.log(data);
                                var json = JSON.parse(data);
                                //console.log(json);
                                if (json.code == 200) {
                                    /*$("#SOLD_OUT" + buy_item_id).text('SOLD OUT');
                                    $("#SOLD_OUT" + buy_item_id).removeClass('fp');*/
                                    alert(json.msg);
                                    location.reload();
                                } else {
                                    alert(json.msg);
                                    //console.log(json);
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
                    } else {
                        alert("구매하실 아이템을 선택하여주세요");
                    }
                }
                else{
                    alert("보유코인이 부족합니다");
                }
            }
            else
            {
                alert("구매가 취소되었습니다.");
            }
        }
    </script>
</div>
</body>
</html>
