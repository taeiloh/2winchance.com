<?php

$mid ='INIiasTest';                            // 테스트 MID 입니다. 계약한 상점 MID 로 변경 필요
$apiKey ='TGdxb2l3enJDWFRTbTgvREU3MGYwUT09';   // 테스트 MID 에 대한 apiKey
$mTxId ='test_20210625';   
$reqSvcCd ='01';

  // 등록가맹점 확인
  $plainText1 = hash("sha256",(string)$mid.(string)$mTxId.(string)$apiKey);
  $authHash = $plainText1;

$userName = '홍길동';            // 사용자 이름
$userPhone = '01011112222';    // 사용자 전화번호
$userBirth ='19800101';        // 사용자 생년월일

$flgFixedUser = 'N';           // 특정사용자 고정시 Y

	if($flgFixedUser=="Y")
	{
		$plainText2 = hash("sha256",(string)$userName.(string)$mid.(string)$userPhone.(string)$mTxId.(string)$userBirth.(string)$reqSvcCd);
        $userHash = $plainText2;
	}


?>
          
<html> 
<head> 
<title>통합본인인증 요청</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 

<script language="javascript"> 
	function callSa()
	{
		let window = popupCenter();
		if(window != undefined && window != null)
		{
			document.saForm.setAttribute("target", "sa_popup");
			document.saForm.setAttribute("post", "post");
			document.saForm.setAttribute("action", "https://sa.inicis.com/auth");
			document.saForm.submit();
		}
	}

	function popupCenter() {
		let _width = 400;
		let _height = 620;
		var xPos = (document.body.offsetWidth/2) - (_width/2); // 가운데 정렬
		xPos += window.screenLeft; // 듀얼 모니터일 때

		return window.open("", "sa_popup", "width="+_width+", height="+_height+", left="+xPos+", menubar=yes, status=yes, titlebar=yes, resizable=yes");
	}
</script> 
</head>
<body>

<form name="saForm">

<input type="text" name="mid" value="<?php echo $mid ?>">                                 mid         <br/>
<input type="text" name="reqSvcCd" value="<?php echo $reqSvcCd ?>">                       reqSvcCd    <br/>
<input type="text" name="mTxId" value="<?php echo $mTxId ?>">                             mTxId       <br/>
<input type="text" name="authHash" value="<?php echo $authHash ?>">                       authHash       <br/>
<input type="text" name="flgFixedUser" value="<?php echo $flgFixedUser ?>">               flgFixedUser<br/>
<input type="text" name="userName" value="<?php echo $userName ?>">                       userName    <br/>
<input type="text" name="userPhone" value="<?php echo $userPhone ?>">                     userPhone   <br/>
<input type="text" name="userBirth" value="<?php echo $userBirth ?>">                     userBirth   <br/>
<input type="text" name="userHash" value="<?php echo $userHash ?>">                       userHash   <br/>
<input type="text" name="directAgency" value="">                                          directAgency   <br/>

<input type="text" name="successUrl" value="http://2winchance.com/zzz/success.php">          successUrl  <br/>
<input type="text" name="failUrl" value="http://2winchance.com/zzz/success.php">             failUrl     <br/>
<!-- successUrl/failUrl 은 분리하여도 됩니다. !-->
				
</form>	

<button onclick="callSa()">확인</button>

</body>
</html>