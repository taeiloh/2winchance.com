<?php
require_once __DIR__ .'/../_inc/config.php';

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
                <h2 class="footer-title">CONTACT US</h2>
                <div class="footer-inner">
                    <h3 class="footer-sub-title">문의하기</h3>
                    <div class="footer-cont ask">
                        <div>
                            <h4>문의 내용을 선택해주세요.</h4>
                            <select name="cuTopic" id="cuTopic">
                                <option value="" selected>종류를 선택해주세요.</option>
                                <option value= "1">계정 제한</option>
                                <option value= "2">광고</option>
                                <option value= "3">보너스</option>
                                <option value= "4">상점</option>
                                <option value= "5">불만 사항</option>
                                <option value= "6">콘테스트</option>
                                <option value= "7">기타</option>
                                <option value= "8">로그인</option>
                                <option value= "9">제안</option>
                                <option value= "10">기술적 문제</option>
                            </select>
<!--                            <section id="dropdown">-->
<!--                                <div class="select">-->
<!--                                    <div class="text">종류를 선택해주세요.</div>-->
<!--                                    <ul class="option-list" id="cuTopic" name="cuTopic">-->
<!--                                        <li class="option" value="1">계정 제한</li>-->
<!--                                        <li class="option" value="2">광고</li>-->
<!--                                        <li class="option" value="3">보너스</li>-->
<!--                                        <li class="option" value="4">상점</li>-->
<!--                                        <li class="option" value="5">불만 사항</li>-->
<!--                                        <li class="option" value="6">콘테스트</li>-->
<!--                                        <li class="option" value="7">기타</li>-->
<!--                                        <li class="option" value="8">로그인</li>-->
<!--                                        <li class="option" value="9">제안</li>-->
<!--                                        <li class="option" value="10">기술적 문제</li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </section>-->
                        </div>
                        <div>
                            <h4>유저 이름</h4>
                            <p class="fc-blue">정글못해먹겐네</p>
                        </div>
                        <div>
                            <h4>E-mail</h4>
                            <input type="email" name="cuMail" id="cuMail" placeholder="이메일을 입력해주세요.">
                        </div>
                        <div>
                            <h4>문의 제목</h4>
                            <input type="text" name="cuSubject" id="cuSubject" placeholder="제목을 입력해주세요.">
                            <span class="alert"><img src="/images/ico_alert_blue.svg" alt="입력조건">10자 이상의 내용을 작성해주세요.</span>
                        </div>
                        <div>
                            <h4>문의 내용</h4>
                            <textarea name="askCont" id="askCont" placeholder="문의하실 내용을 입력해주세요."></textarea>
                            <span class="alert"><img src="/images/ico_alert_blue.svg" alt="입력조건">2000자 이내로 내용을 작성해주세요.</span>
                        </div>
                    </div>
                    <div class="btn-center">
                        <button type="button" class="btn-blue" onclick="saveBtn()">저장</button>
                    </div>
                    <div class="add-ask">
                        <h4>추가 문의</h4>
                        <a href="Support@Metagame.com">Support@Metagame.com</a>
                        <div>
                            <p>MON ~ FRI</p>
                            <span>09:00 ~ 18:00</span>
                        </div>
                        <div>
                            <p>SAT ~ SUN</p>
                            <span>09:00 ~ 14:00</span>
                        </div>
                    </div>
                </div>
            </section>
            <!--//sec-01-->
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
<script type="text/javascript">
        function saveBtn() {
            if ($("#cuTopic option:selected").val() == "") {
                alert("문의 내용을 선택해주세요.");
                $("#cuTopic").focus();
                return false;
            }

            if ($("#cuMail").val() == "") {
                alert("이메일을 입력해 주세요.");
                $("#cuMail").focus();
                return false;
            }

            if ($.trim($("#cuSubject").val()) == "") {
                alert("제목을 입력해 주세요.");
                $("#cuSubject").focus();
                return false;
            }

            if ($("#askCont").val() == "") {
                alert("내용을 입력해 주세요.");
                $("#askCont").focus();
                return false;
            }

            var cu_topic = $("#cuTopic").val();
            var cu_mail = $("#cuMail").val();
            var cu_subject = $("#cuSubject").val();
            var cu_message = $("#askCont").val();
            var cu_status = 1;

            var postData = {
                "cu_topic": cu_topic,
                "cu_mail": cu_mail,
                "cu_subject": cu_subject,
                "cu_message": cu_message,
                "cu_status": cu_status
            }

            $.ajax({
                url: "co_writeProc.php",
                type: "POST",
                data: postData,
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    if (data.code == 200) {
                        alert("등록되었습니다.");
                        location.href = "contactus.php";
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
    }
</script>
</body>
</html>




