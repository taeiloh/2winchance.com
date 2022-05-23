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
    $_arrMembers = $mresult->fetch_array();

    $m_deposit = !empty($_arrMembers['m_deposit']) ? $_arrMembers['m_deposit'] : '';

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

    $result = $_mysqli->query($query);
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
                            <li class="fc-yellow"><span></span><?=number_format($m_deposit)?><span class="fc-yellow">ⓒ</span></li>
                        </ul>
                        <ul class="coin-input">
                            <li>아이템</li>
                            <li><label><input type="radio" name="type" value="type1" checked>치장형</label></li>
                            <li><label><input type="radio" name="type" value="type2">편의형</label></li>
                            <li><label><input type="radio" name="type" value="type3">스페셜</label></li>
                        </ul>
                        <p>본 아이템은 마이페이지의 프로필 변경을 통해 적용 가능합니다. <br/> <br/>
                            사용자간 거래가 불가하며 중복 보유 가능합니다.</p>
                        <p class="fc-yellow fs-28 bold mT30">사용 캐시 <span>-10 ⓒ</span></p>
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
                                while($_db = $result -> fetch_assoc()){
                                    $i_price = $_db['i_price'];
                                    $i_type = $_db['i_type'];
                                    $i_fp = $_db['i_fp'];
                                    $i_src = $_db['i_src'];
                                    $i_name = $_db['i_name'];
                                    $i_num = $_db['i_num'];
                                    $i_status = $_db['i_status'];
                                    $i++;
                                    $no=$total_count-($i+($page-1)*$rows);
                                    if($i==1){?>
                                        <li class = "active">
                                            <a href="javascript:void(0);" data-item = "<?=$i_num?>" data-price ="<?=$i_price?>" data-fp="<?=$i_fp?>">
                                                <div class="item-pic">
                                                    <img src="<?=$i_src?>" alt="">
                                                    <?php
                                                    if($i_status == 1){?>
                                                        <p class="get-point">SOLD OUT</p>
                                                    <?php
                                                    } else{?>
                                                        <p class="get-point fp">+<?=$i_fp?></p>
                                                    <?php
                                                    }?>
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
                                    <a href="javascript:void(0);" data-item = "<?=$i_num?>" data-price ="<?=$i_price?>" data-fp="<?=$i_fp?>">
                                    <div class="item-pic">
                                        <img src="<?=$i_src?>" alt="">
                                        <?php
                                        if($i_status == 1){?>
                                            <p class="get-point">SOLD OUT</p>
                                            <?php
                                        } else{?>
                                            <p class="get-point fp">+<?=$i_fp?></p>
                                            <?php
                                        }?>
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
                            $result->free();
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
                $('ul.buy-item-list li').removeClass('active');
                $(this).parent('li').addClass('active');
                buy_item_id = item_id;
                buy_item_price = item_price;
                buy_item_fp = item_fp;
            })
        })

        function buy(){
            if(confirm("해당아이템을 구매하시겠습니까?"))
            {
                if(buy_item_id > 0 ){
                    var postData = {
                        "m_num": buy_item_id,
                        "price": buy_item_price,
                        "fp":buy_item_fp
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
                                alert(json.msg);
                            }else{
                                alert(json.msg);
                                //console.log(json);
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
                }
                else{
                    alert("구매하실 아이템을 선택하여주세요");
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
