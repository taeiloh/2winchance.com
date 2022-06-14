<?php
// config
require_once __DIR__ .'/../_inc/config.php';

$idx=!empty($_SESSION['_se_idx']) ? $_SESSION['_se_idx'] : "";      // 세션 시퀀스
$id=!empty($_SESSION['_se_id']) ? $_SESSION['_se_id'] : "";        // 세션 아이디
$name=!empty($_SESSION['_se_name']) ? $_SESSION['_se_name'] : "";    // 세션 닉네임

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);

if (!$idx) {

    $url    = $_SERVER['REQUEST_URI'];

    $msg    = '로그인 페이지로 이동합니다.';

    $url    = '/login/index.php?rtnUrl='. $url;

    alertReplace($msg, $url);

    exit;

}
try{

    //파라미터 정리
    $page       = !empty($_GET['page'])     ? $_GET['page']     : 1;

    //파라미터 체크
    if(!is_numeric($page)){
        $page       =   1;
    }

    //페이징
    $sql = "select count(*) from honor_point_history where 1 and m_idx='{$idx}'";
    $tresult = mysqli_query($_mysqli, $sql);
    $row1   = mysqli_fetch_row($tresult);
    $total_count = $row1[0]; //전체갯수
    $rows = 10;
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함

    //db
    $query ="
        SELECT
            idx, created_at AS regdate, content, point, balance
        FROM honor_point_history
        WHERE 1 and m_idx='{$idx}'
        ORDER BY created_at DESC
        LIMIT {$from_record}, {$rows}
    ";

    $resulthp = $_mysqli->query($query);

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
        <div id="content">
            <!--sec-01-->
            <section class="sec sec-01 T0 myAcct">
                <?php
                //header
                require_once __DIR__ . '/../common/category.php';
                ?>
                <div class="contents-cont inner">
                    <table class="contents-table cash-table fp-page">
                        <colgroup>
                            <col style="width:25%">
                            <col style="width:25%">
                            <col style="width:25%">
                            <col style="width:25%">
                        </colgroup>
                        <thead>
                        <tr class="filter">
                            <th><a href="javascript:void(0);">일자</a></th>
                            <th><a href="javascript:void(0);">내용</a></th>
                            <th><a href="javascript:void(0);">전투력</a></th>
                            <th><a href="javascript:void(0);">보유 전투력</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($total_count > 0){
                            $i = 0;
                            while ($dbhp = $resulthp->fetch_assoc()) {
                                $title = empty(!$dbhp['content']) ? $dbhp['content'] : '';
                                $regdate = empty(!$dbhp['regdate']) ? $dbhp['regdate'] : '';
                                $hp = empty(!$dbhp['point']) ? $dbhp['point'] : '';
                                $balance = empty(!$dbhp['balance']) ? $dbhp['balance'] : '';
                                $i++;
                                $no=$total_count-($i+($page-1)*$rows);
                                echo <<<TR
                        <tr>
                            <td class="Fgray">{$regdate}</td>
                            <td>{$title}</td>
                            <td>+{$hp}</td>
                            <td>{$balance}</td>
                        </tr>
TR;
                            }
                        }else {
                            echo <<<TR
                         <tr>
                                <td colspan="6">전투력 내역이 없습니다.</td>
                         </tr>
TR;
                        }
                        ?>
<!--<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
<tr>
    <td>2022-1-03-04 13:25:49</td>
    <td>콘테스트 결과(G55362)</td>
    <td>+ 25</td>
    <td>4,946</td>
</tr>
-->
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
<?php
                echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                ?>
<!--                <a class="active" href="javascript:void(0)">1</a>
                <a href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">3</a>
                <a href="javascript:void(0)">4</a>-->
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