$(function () {
    // 회원가입 클릭
    $("#btnTopSignUp").on("click", function () {
        location.href = "/signup/";
    });

    // 로그인 클릭
    $("#btnTopLogin").on("click", function () {
        location.href = "/login/";
    });
});