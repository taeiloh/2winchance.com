<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {

    //파라미터 정리
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }
    //페이징
    $sql = "select count(*) from notice where 1=1";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 5;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    // db
    $query  = "
        SELECT
            nt_subject, DATE_FORMAT(nt_date, '%Y.%m.%d') AS regdate, nt_content
        FROM notice
        WHERE 1=1
        ORDER BY nt_date DESC
        LIMIT {$from_record}, {$rows}
    ";

    $result1 = $_mysqli->query($query);
//    if (!$result) {
//
//    }

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
        <div id="content">
            <!--sec-01-->
            <section class="sec sec-01 T0">
                <h2 class="footer-title">공지사항</h2>
                <div class="footer-notice">
                    <?php
                    // db
                    if($total_count > 0){
                        $i = 0;
                        while ($_db = $result1->fetch_assoc()) {
                            $title = $_db['nt_subject'];
                            $regdate = $_db['regdate'];
                            $content = $_db['nt_content'];
                            $i++;
                            $no=$total_count-($i+($page-1)*$rows);
                            echo <<<DIV
                        <div class="notice-wrap">
                            <div class="notice-title">
                                <p>{$title}</p>
                                <span>{$regdate}</span>
                            </div>
                            <div class="notice-cont">
                                <p>
                                    {$content}
                                </p>
                            </div>
                        </div>
DIV;
                        }
                    }
                    // free
                    $result->free();;
                    ?>
                </div>

            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?php
                echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                ?>

<!--                <a href="javascript:void(0)">1</a>-->
<!--                <a class="active" href="javascript:void(0)">2</a>-->
<!--                <a href="javascript:void(0)">3</a>-->
<!--                <a href="javascript:void(0)">4</a>-->
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