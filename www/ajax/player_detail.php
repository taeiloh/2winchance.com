<?php
// config
require_once __DIR__ . '/../_inc/config.php';

// class
require_once __DIR__ .'/../class/PlayerInfo.php';

try {
    // 파라미터 정리
    $cate = 20;
    $cate           = filter_input(INPUT_POST, 'cate');
    $g_id           = filter_input(INPUT_POST, 'g_id');
    $p_id           = filter_input(INPUT_POST, 'p_id');


    $playerInfo     = new PlayerInfo($cate, $g_id, $p_id, $_mysqli, $_mysqli_game);

    $info           = $playerInfo->getDetail();
    $photo          = "{$info['full_name']}.jpg";

} catch (Exception $e) {

}
?>
<div class="player-img">
    <img src="/images/player_images/pubg/<?=$photo;?>" alt="<?=$info['full_name'];?>'s photo"/>
</div>
<div class="player-skill">
    <div class="skill-top">
        <div class="name">
            <h2><?=$info['abbr_name'];?></h2>
            <p><?=$info['full_name'];?></p>
        </div>
        <table class="border-table">
            <colgroup>
                <col>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <tr>
                <th>평균 순위</th>
                <th>평균 킬</th>
                <th>평균 생존</th>
                <th>승률</th>
                <th>KDA</th>
            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>mm:ss</td>
                <td>67%</td>
                <td>66.1%</td>
            </tr>
        </table>
        <button type="button" class="btn-plus"></button>
    </div>
    <div class="skill-bottom">
        <div class="player-salary">
            <p><span class="fc-blue">연봉</span>$963,000</p>
            <button type="button" class="btn-yellow player-stats open-btn" data-target="modal-1">전적 조회</button>
        </div>
        <table class="bg-table">
            <colgroup>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>최근 경기</th>
                <th>순위</th>
                <th>킬 수</th>
                <th>HP</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>05/13</td>
                <td>1</td>
                <td>1</td>
                <td>000</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
