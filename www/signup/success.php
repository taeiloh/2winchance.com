<!doctype html>
<html lang="ko">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';

    ?>
</head>
<body>
<script>
    $(document).ready(function(){
        var f= document.forms.popupForm;
        opener.name = "join_02.php";
        f.target = opener.name;
        f.submit();
        self.close();
    })
</script>
<form name="popupForm" action="join_03.php" method="post">
    <input type="text" name="resultCode" value="<?=$_REQUEST["resultCode"]?>">
</form>
</body>
</html>