<?php
// config
require_once __DIR__ .'/../_inc/config.php';

$gidx       = !empty($_POST['gidx'])        ? $_POST['gidx']        : 0;

$query  = "
    SELECT
        m.m_name
    FROM join_contest jc 
    INNER JOIN members m
    ON jc.jc_u_idx = m.m_idx
    WHERE 1=1
        AND jc_game = {$gidx}
    ORDER BY m.m_name ASC
";
$result = $_mysqli->query($query);
if (!$result) {
}
?>
<div class="join_header"><h3>참가자</h3> <button class="closeBtn"><img src="/images/close_btn.svg" alt="닫기"/></button></div>
<div class="join_scroll">
    <div class="join_player">
        <?php
        while ($db = $result->fetch_assoc()) {
            echo "<p>{$db['m_name']}</p>";
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    $(".closeBtn").on("click", function () {
        $(this).parents(".join_list").removeClass("active");
    });
</script>
<?php
$result->free();