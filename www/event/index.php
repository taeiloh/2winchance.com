<?php
// config
require_once __DIR__ .'/../_inc/config.php';



try {

} catch (Exception $e) {
    p($e);
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
            <section class="sec sec-01 bg-black">
                <div class="inner rank-warp">
                    <h2>인기 콘테스트</h2>
                    <ul class="contest-list">
                        <li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/pubg_logo.png')">
                                    <div class="subject"></div>
                                    <div class="rank_label">
                                        <span>1</span>
                                    </div>
                                </div>
                               <div class="contest-desc">
                                  <dl>
                                      <dt class="contest-schedule">2022-05-20 | 02:56:12</dt>
                                      <!-- dt class="contest-schedule">{$db['games_timezone_scheduled']}</dt -->
                                      <dt class="contest-title">30회 중복 & 상위 50% WIN</dt>
                                      <!-- dt class="contest-title">{$db['count']} GAMES</dt -->
                                      <dd class="contest-detail">
                                          <ul>
                                              <li class="coin-b">2,056</li>
                                              <li>1,000</li>
                                              <li>1,658 / 1.5K</li>
                                          </ul>
                                      </dd>
                                  </dl>
                              </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/images/pubg_logo.png')">
                                    <div class="subject"></div>
                                    <div class="rank_label">
                                        <span>2</span>
                                    </div>
                                </div>
                                <div class="contest-desc">
                                    <dl>
                                        <dt class="contest-schedule">2022-05-20 | 02:56:12</dt>
                                        <!-- dt class="contest-schedule">{$db['games_timezone_scheduled']}</dt -->
                                        <dt class="contest-title">30회 중복 & 상위 50% WIN</dt>
                                        <!-- dt class="contest-title">{$db['count']} GAMES</dt -->
                                        <dd class="contest-detail">
                                            <ul>
                                                <li class="coin-b">2,056</li>
                                                <li>1,000</li>
                                                <li>1,658 / 1.5K</li>
                                            </ul>
                                        </dd>
                                    </dl>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/images/pubg_logo.png')">
                                    <div class="subject"></div>
                                    <div class="rank_label">
                                        <span>3</span>
                                    </div>
                                </div>
                               <div class="contest-desc">
                                   <dl>
                                       <dt class="contest-schedule">2022-05-20 | 02:56:12</dt>
                                       <!-- dt class="contest-schedule">{$db['games_timezone_scheduled']}</dt -->
                                       <dt class="contest-title">30회 중복 & 상위 50% WIN</dt>
                                       <!-- dt class="contest-title">{$db['count']} GAMES</dt -->
                                       <dd class="contest-detail">
                                           <ul>
                                               <li class="coin-b">2,056</li>
                                               <li>1,000</li>
                                               <li>1,658 / 1.5K</li>
                                           </ul>
                                       </dd>
                                   </dl>
                               </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </section>
            <!--//sec-01-->
            <!--sec-02-->
            <section class="sec sec-02">
                <div class="inner mT10">
                    <h2>이벤트 리스트</h2>
                    <ul class="contest-list">
                        <!--<li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb01.png')">
                                    <div class="subject"></div>
                                    <div class="event-banner"></div>
                                </div>
                                <div class="contest-desc">
                                    <div class="contest-ico">
                                        <img src="../images/free_icon.svg" alt="임시">
                                    </div>
                                    <dl>
                                        <dt class="contest-schedule">내일 경기 예정</dt>
                                        <dt class="contest-title">COD:M 커뮤니티</dt>
                                        <dd class="contest-detail">
                                            <ul>
                                                <li><img src="../images/ico_pin.svg" class="mR5" alt="위치">LAS</li>
                                                <li>5v5</li>
                                                <li>€150.00</li>
                                                <li>1,254 Slots</li>
                                            </ul>
                                        </dd>
                                    </dl>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb02.png')">
                                    <div class="subject"></div>
                                    <div class="event-banner"></div>
                                </div>
                                <div class="contest-desc">
                                    <div class="contest-ico">
                                        <img src="../images/top_icon.svg" alt="임시">
                                    </div>
                                    <dl>
                                        <dt class="contest-schedule fc-yellow">오늘 경기 종료</dt>
                                        <dt class="contest-title">COD:M 커뮤니티</dt>
                                        <dd class="contest-detail">
                                            <ul>
                                                <li><img src="../images/ico_pin.svg" class="mR5" alt="위치">LAS</li>
                                                <li>5v5</li>
                                                <li>€150.00</li>
                                                <li>1,254 Slots</li>
                                            </ul>
                                        </dd>
                                    </dl>
                                </div>
                            </a>
                        </li>-->
                        <li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb03.png')">
                                </div>
                                <!-- 진행중인 이벤트가 없을 경우 no-event 클래스 추가 -->
                                <div class="contest-desc no-event">
                                    <p>진행중인 이벤트 없음</p>
                                </div>
                                <!-- //진행중인 이벤트가 없을 경우  -->
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb01.png')">
                                </div>
                                <!-- 진행중인 이벤트가 없을 경우 no-event 클래스 추가 -->
                                <div class="contest-desc no-event">
                                    <p>진행중인 이벤트 없음</p>
                                </div>
                                <!-- //진행중인 이벤트가 없을 경우  -->
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb02.png')">
                                </div>
                                <!-- 진행중인 이벤트가 없을 경우 no-event 클래스 추가 -->
                                <div class="contest-desc no-event">
                                    <p>진행중인 이벤트 없음</p>
                                </div>
                                <!-- //진행중인 이벤트가 없을 경우  -->
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <div class="game-thumb" style="background-image: url('../images/@img_thumb03.png')">
                                </div>
                                <!-- 진행중인 이벤트가 없을 경우 no-event 클래스 추가 -->
                                <div class="contest-desc no-event">
                                    <p>진행중인 이벤트 없음</p>
                                </div>
                                <!-- //진행중인 이벤트가 없을 경우  -->
                            </a>
                        </li>
                    </ul>
                    <p class="more-line">
                        <button type="button">더보기 <img src="../images/btn-more.svg" alt="더보기" class="mL8"></button>
                    </p>
                </div>
            </section>
            <!--//sec-02-->
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
