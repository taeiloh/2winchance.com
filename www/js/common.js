$(function(){
    $(".btn-down").click(function(){
        var slideCont = $(this).parents('.league-detail');
        var showCont = $(this).parents('.league-box').children().children('.status-detail');

        slideCont.toggleClass('active');
        showCont.toggleClass('active');

        if(slideCont.hasClass('active')){
            $(this).children('span').text('닫기');
        }else{
            $(this).children('span').text('경기정보');
        }

    })

    // 카테고리
    $(".category li a").click(function(){
        $('.category li').removeClass('active');
        $(this).parent('li').addClass('active');
    })

    // time-menu swiper
    $(".time-menu .swiper-slide").click(function(){
        $('.time-menu .swiper-slide').removeClass('active');
        $(this).addClass('active');
    })

    // 플레이어 선택
    $(".select-player li ").click(function(){
        $(this).toggleClass('active');
    })

    // 선택 플레이어 삭제
    $(".btn-delete").click(function(){
        $(this).parents('li').remove();
    })

    // 콘텐츠 테이블 - 아코디언
    $(".fold-table tr.view").on("click", function(){
        $(this).toggleClass("open").next(".fold").toggleClass("open");
    });

    // 마이페이지 메뉴 펼치기
    $('.login-wrap.after .user-info .mypage .mypage-btn').click(function(){
        $(this).toggleClass('open').next().slideToggle(400);
    });

    // 탭메뉴
    $('ul.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('on');
        $('.tab-content').removeClass('on');

        $("#"+tab_id).addClass('on');

        $(this).addClass('on');
    })

    // modal
    $('.open-btn').click(function(){
        var modal_id = $(this).attr('data-target');

        $('body').addClass('modal-open');
        $('#'+modal_id).addClass('active');
    })
    $('.close-btn').click(function(){
        $('body').removeClass('modal-open');
        $(this).parents('.modal').removeClass('active');
    })

    // 공지사항
    $('.notice-title').click(function(){
       $(this).parent($('.notice-wrap')).toggleClass('open').siblings().removeClass('open');
       $(this).parent($('.notice-wrap')).siblings().find($('.notice-cont')).slideUp(300);
       $(this).next($('.notice-cont')).slideToggle(300);
    });


    // select dropdown
    function onClickSelect(e) {
        const isActive = e.currentTarget.className.indexOf("active") !== -1;
        if (isActive) {
            e.currentTarget.className = "select";
        } else {
            e.currentTarget.className = "select active";
        }
    }

    document.querySelector("#dropdown .select").addEventListener("click", onClickSelect);

    function onClickOption(e) {
        const selectedValue = e.currentTarget.innerHTML;
        document.querySelector("#dropdown .text").innerHTML = selectedValue;
    }

    var optionList = document.querySelectorAll("#dropdown .option");
    for (var i = 0; i < optionList.length; i++) {
        var option = optionList[i];
        option.addEventListener("click", onClickOption);
    }

});

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function getCookie( Name ) {
    var nameOfCookie = Name + "=";
    var x = 0;
    while ( x <= document.cookie.length ) {
        var y = (x+nameOfCookie.length);
        if ( document.cookie.substring( x, y ) == nameOfCookie ) {
            if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) {
                endOfCookie = document.cookie.length;
            }

            return unescape( document.cookie.substring( y, endOfCookie ) );
        }

        x = document.cookie.indexOf( " ", x ) + 1;
        if ( x == 0 ) break;
    }

    return "";
}

// 00:00 시 기준 쿠키 설정하기
function setCookieAt00(name, value, expiredays) {
    var todayDate = new Date();
    todayDate = new Date(parseInt(todayDate.getTime() / 86400000) * 86400000 + 54000000);

    if ( todayDate > new Date() )
    {
        expiredays = expiredays - 1;
    }

    todayDate.setDate( todayDate.getDate() + expiredays );
    document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}
