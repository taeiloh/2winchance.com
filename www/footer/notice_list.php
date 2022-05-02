<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // db
    $query  = "
        SELECT
            nt_subject, DATE_FORMAT(nt_date, '%Y.%m.%d') AS regdate, nt_content
        FROM notice
        WHERE 1
        ORDER BY nt_date DESC
    ";
    $result = $_mysqli->query($query);
    if (!$result) {

    }

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
                    while ($_db = $result->fetch_assoc()) {
                        $title      = $_db['nt_subject'];
                        $regdate    = $_db['regdate'];
                        $content    = $_db['nt_content'];

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
                    // free
                    $result->free();;
                    ?>
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
</div>
</body>
</html>