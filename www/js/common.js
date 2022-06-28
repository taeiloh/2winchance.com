$(function(){
    $(".btn-down").click(function(){
        var slideCont = $(this).parents('.league-detail');
        var showCont = $(this).parents('.league-box').children().children('.status-detail');
        var g_idx = $(this).attr("g_idx");

        slideCont.toggleClass('active');
        showCont.toggleClass('active');

        if(slideCont.hasClass('active')){
            $(this).children().children('span').text('닫기');
        }else{
            $(this).children().children('span').text('경기정보');
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
    // $(".btn-delete").click(function(){
    //     $(this).parents('li').remove();
    // })

    // 콘텐츠 테이블 - 아코디언
    $(".fold-table tr.view").on("click", function(){
        $(this).toggleClass("open").next(".fold").toggleClass("open");
    });

    // 마이페이지 메뉴 펼치기
    $('.login-wrap.after .user-info .mypage .mypage-btn').click(function(){
        $(this).toggleClass('open').next().slideToggle(400);
    });

    $('#gnb > ul > li').click(function (){
        $('#gnb > ul > li').removeClass('active');
        $(this).addClass('active');
    });

    $('.sub-menu li').click(function (){
        $('.sub-menu li').removeClass('active');
        $(this).addClass('active');
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

   // layer popup
    $('.openList_btn').click(function(){

      $(this).parents('.join_list').addClass('active');
    })
    $('.closeBtn').click(function(){
      $(this).parents('.join_list').removeClass('active');
    })
    $('.openList_btn').click(function (){
      $('.join_list').addClass('active');
      $(this).removeClass('active');
    });
  //
  // $('.openList_btn').click(function(){
  //   var popup_id = $(this).attr('data-target');
  //
  //   $('body').addClass('modal-open');
  //   $('#'+popup_id).addClass('active');
  // })
  // $('.close-btn').click(function(){
  //   $('body').removeClass('modal-open');
  //   $(this).parents('.modal').removeClass('active');
  // })




    // 공지사항
    $('.notice-title').click(function(){
       $(this).parent($('.notice-wrap')).toggleClass('open').siblings().removeClass('open');
       $(this).parent($('.notice-wrap')).siblings().find($('.notice-cont')).slideUp(300);
       $(this).next($('.notice-cont')).slideToggle(300);
    });

    // select dropdown

    $(".dropdown .select").click(function (e){
        const isActive = e.currentTarget.className.indexOf("active") !== -1;
        if (isActive) {
            e.currentTarget.className = "select";
        } else {
            e.currentTarget.className = "select active";
        }
    })

    function onClickOption0(e) {
        const selectedValue0 = e.currentTarget.innerHTML;
        document.querySelector("#dropdown .text").innerHTML = selectedValue0;
    }

    var optionList0 = document.querySelectorAll("#dropdown .option");
    for (var i = 0; i < optionList0.length; i++) {
        var option0 = optionList0[i];
        option0.addEventListener("click", onClickOption0);
    }


    function onClickOption1(e) {
        const selectedValue1 = e.currentTarget.innerHTML;
        document.querySelector("#drop1 .text").innerHTML = selectedValue1;
    }

    var optionList1 = document.querySelectorAll("#drop1 .option");
    for (var i = 0; i < optionList1.length; i++) {
        var option1 = optionList1[i];
        option1.addEventListener("click", onClickOption1);
    }

    function onClickOption2(e) {
        const selectedValue2 = e.currentTarget.innerHTML;
        document.querySelector("#drop2 .text").innerHTML = selectedValue2;
    }

    var optionList2 = document.querySelectorAll("#drop2 .option");
    for (var i = 0; i < optionList2.length; i++) {
        var option2 = optionList2[i];
        option2.addEventListener("click", onClickOption2);
    }

    function onClickOption3(e) {
        const selectedValue3 = e.currentTarget.innerHTML;
        document.querySelector("#drop3 .text").innerHTML = selectedValue3;
    }

    var optionList3 = document.querySelectorAll("#drop3 .option");
    for (var i = 0; i < optionList3.length; i++) {
        var option3 = optionList3[i];
        option3.addEventListener("click", onClickOption3);
    }

    function onClickOption4(e) {
        const selectedValue4 = e.currentTarget.innerHTML;
        document.querySelector("#drop4 .text").innerHTML = selectedValue4;
    }

    var optionList4 = document.querySelectorAll("#drop4 .option");
    for (var i = 0; i < optionList4.length; i++) {
        var option4 = optionList4[i];
        option4.addEventListener("click", onClickOption4);
    }

    $('.game-schedule li').click(function(){
        $('.game-schedule li').removeClass('active');
        $(this).addClass('active');
    })


    // const modal = document.querySelector('.join_list');
    // const btnOpenPopup = document.querySelector('.openList_btn');
    //
    // btnOpenPopup.addEventListener('click', () => {
    //   modal.style.display = 'block';
    // });

    // const modal = document.querySelector('.join_list');
    // const btnOpenPopup = document.querySelector('.openList_btn');
    // const btnClosePopup = document.querySelector('.closeBtn');
    //
    // btnOpenPopup.addEventListener('click', () => {
    //   modal.classList.toggle('active');
    //
    // });
    //
    // btnClosePopup.addEventListener('click', (event) => {
    //   if (event.target === modal) {
    //     modal.classList.toggle('active');
    //
    //   }
    // });

    // var modal = document.querySelector(".join_list");
    // var trigger = document.querySelector(".openList_btn");
    // var closeButton = document.querySelector(".closeBtn");
    //
    // function toggleModal() {
    //   modal.classList.toggle("active");
    // }
    //
    // function windowOnClick(event) {
    //   if (event.target === modal) {
    //     toggleModal();
    //   }
    // }
    //
    // trigger.addEventListener("click", toggleModal);
    // closeButton.addEventListener("click", toggleModal);
    // window.addEventListener("click", windowOnClick);

})
