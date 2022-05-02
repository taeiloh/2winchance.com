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
       $(this).parent($('.notice-cont')).toggleClass('open').siblings().removeClass('open');
       $(this).parent($('.notice-wrap')).siblings().find($('.notice-cont')).slideUp(300);
       $(this).next($('.notice-cont')).slideToggle(300);
    });

    // 햄버거메뉴
    $(function() {
        /* 햄버거메뉴 클릭 */
        $('.tab_menu_btn').click(function () {

            $('.tab_warp').addClass('active');
        })
        /* 닫기 버튼 클릭 */
        $('.close_btn').click(function () {

            $('.tab_warp').removeClass('active');


        })
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

    document.querySelector("#drop1 .select").addEventListener("click", onClickSelect);

    function onClickOption(e) {
        const selectedValue = e.currentTarget.innerHTML;
        document.querySelector("#drop1 .text").innerHTML = selectedValue;
    }

    var optionList = document.querySelectorAll("#drop1 .option");
    for (var i = 0; i < optionList.length; i++) {
        var option = optionList[i];
        option.addEventListener("click", onClickOption);
    }

    document.querySelector("#drop2 .select").addEventListener("click", onClickSelect);

    function onClickOption(e) {
        const selectedValue = e.currentTarget.innerHTML;
        document.querySelector("#drop2 .text").innerHTML = selectedValue;
    }

    var optionList = document.querySelectorAll("#drop2 .option");
    for (var i = 0; i < optionList.length; i++) {
        var option = optionList[i];
        option.addEventListener("click", onClickOption);
    }


})
