
<?php
// config
require_once __DIR__ .'/../_inc/config.php';

$url      = !empty($_POST['url'])           ? strtoupper($_POST['url'])         : '';


?>
<!doctype html>
<html lang="ko">
<head>
    <?php
    //head
    require_once __DIR__ .'/../common/head.php';
    ?>
</head>
<body>
<script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
<script type="text/javascript">


    Kakao.init('77dd1dcd5ebf629806e3557a187d1591');
    console.log(Kakao.isInitialized());
    $(function () {
        Kakao.Auth.login({
            success: function(authObj) {
                //console.log(JSON.stringify(authObj));
                Kakao.API.request({
                    url: '/v2/user/me',
                    success: function(res) {
                        //console.log(JSON.stringify(res));
                        var sns_id = JSON.stringify(res.id);
                        $("#m_sns_type").val("kakao");
                        $("#m_sns_id").val(sns_id);
                        var url=$("#url").val();
                        $("#loginFrm").attr("action", url);
                        $("#loginFrm").submit();
                    },
                    fail: function(error) {
                        alert("본인인증 중 오류가 발생했습니다.\r\n다시 시도해 주세요.");
                    },
                })
            },
            fail: function(err) {
                alert("카카오 로그인 실패하였습니다.\r\n관리자에게 문의해 주세요.");
                return false;
            },
        })

    });
</script>

<form id="loginFrm" name="loginFrm" method="post" action="">
    <input type="hidden" name="m_sns_type" id="m_sns_type" />
    <input type="hidden" name="m_sns_id" id="m_sns_id" />
    <input type="hidden" name="url" id="url" value="<?=$url?>"/>
</form>
</body>
</html>