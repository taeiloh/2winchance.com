<?php
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);

try{
    //파라미터 정리
    $page       = !empty($_GET['page'])     ? $_GET['page']     : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page = 1;
    }

    //페이징
    $sql = "select count(*) from contactus where 1=1";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 10;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    // db
    $query  = "
        SELECT
            cu_idx, DATE_FORMAT(cu_req_date, '%Y-%m-%d %h:%i:%s') AS regdate, cu_subject, cu_status
        FROM contactus
        WHERE 1=1 
        ORDER BY cu_req_date DESC
        LIMIT {$from_record}, {$rows}
    ";

    $result = $_mysqli->query($query);

}catch (mysqli_sql_exception $e){
    $arrRtn['code']     = $e->getCode();
    $arrRtn['msg']      = $e->getMessage();
    echo json_encode($arrRtn);
} catch (Exception $e){
    $arrRtn['code']     = $e->getCode();
    $arrRtn['msg']      = $e->getMessage();
    echo json_encode($arrRtn);
} finally {

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
                <div class="contents-cont inner">
                    <table class="contents-table personalQna">
                        <colgroup>
                            <col style="width:10%">
                            <col style="width:25%">
                            <col style="width:45%">
                            <col style="width:20%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th><a href="javascript:void(0);">번호</a></th>
                            <th><a href="javascript:void(0);">날짜</a></th>
                            <th><a href="javascript:void(0);">제목</a></th>
                            <th><a href="javascript:void(0);">처리상태</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($total_count > 0){
                                $i = 0;
                                while ($dbCu = $result->fetch_assoc()) {
                                    $cu_seq  = empty(!$dbCu['cu_idx']) ? $dbCu['cu_idx'] : '';
                                    $cu_date = empty(!$dbCu['regdate']) ? $dbCu['regdate'] : '';
                                    $cu_title = empty(!$dbCu['cu_subject']) ? $dbCu['cu_subject'] : '';
                                    $cu_status = empty(!$dbCu['cu_status']) ? $dbCu['cu_status'] : '';

                                    $i++;
                                    $no=$total_count-($i+($page-1)*$rows);


                                    echo <<<TR
                        <tr>
                            <td>{$no}</td>
                            <td class="Fgray">{$cu_date}</td>
                            <td>{$cu_title}</td>
                            <td>{$cu_status}</td>
                        </tr>
TR;
                                }
                            }else{
                                    echo <<<TR
                         <tr>
                                <td colspan="4">등록된 게시글이 없습니다.</td>
                         </tr>
TR;
                            }
                        ?>
<!--                        <tr>-->
<!--                            <td>1</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>플레이 버튼을 눌러도 게임에 참여가 안됩니다.</td>-->
<!--                            <td class="done">상담완료</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>2</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>사이트가 자꾸 튕깁니다.</td>-->
<!--                            <td class="wait">대기중</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>3</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>상점에서 엠블렘을 샀는데 메뉴에는 안떠요ㅠㅠ</td>-->
<!--                            <td class="done">상담완료</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>4</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td>상점에서 엠블렘을 샀는데 메뉴에는 안떠요ㅠㅠ</td>-->
<!--                            <td class="wait">대기중</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>5</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td></td>-->
<!--                            <td class="wait">대기중</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>6</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td></td>-->
<!--                            <td class="done">상담완료</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>7</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td></td>-->
<!--                            <td class="wait">대기중</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>8</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td></td>-->
<!--                            <td></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>9</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td></td>-->
<!--                            <td></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>10</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td></td>-->
<!--                            <td></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>11</td>-->
<!--                            <td>2022-1-03-04 13:25:49</td>-->
<!--                            <td></td>-->
<!--                            <td></td>-->
<!--                        </tr>-->
                        </tbody>
                    </table>
                </div>

            </section>
            <!--//sec-01-->
            <div class="qna-btn-box inner">
                <div style="width: 15rem;"></div>
                <div class="pagination">
                    <?php
                    echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                    ?>
<!--                    <a href="javascript:void(0)">1</a>-->
<!--                    <a class="active" href="javascript:void(0)">2</a>-->
<!--                    <a href="javascript:void(0)">3</a>-->
<!--                    <a href="javascript:void(0)">4</a>-->
                </div>
                <button class="btn-blue btn-6" onclick="location.href='contactus.php'">문의하기</button>
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
</div>
</body>
</html>