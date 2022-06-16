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
    $photo          = $info['player_img'];

} catch (Exception $e) {

}
?>
<div class="player-img <?php if($photo!=""){echo "on";}?>">
    <img src="/images/player_images/pubg/<?=$photo;?>" alt="<?=$info['full_name'];?>'s photo"/>
</div>
<div class="player-skill">
    <div class="skill-top">
        <div class="name">
            <h2><?=$info['abbr_name'];?></h2>
            <p><?=$info['team_alias'];?></p>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <button type="button" class="btn-plus add_player"
                data-category="pubg" data-fppg="<?=round($info['player_point']);?>"
                data-game="<?=$g_id;?>" data-img_l="<?=$info['player_img'];?>"
                data-img_s="<?=$info['player_img'];?>" data-index="<?=$info['idx'];?>"
                data-name="<?=$info['abbr_name'];?>" data-pos="<?=$info['primary_position'];?>"
                data-pos2="<?=$info['position'];?>" data-salary="<?=$info['player_salary'];?>"
                data-team="<?=$info['team_alias'];?>" data-dbpg="0"
                data-ppg="0" data-rpg="0" data-apg="0" data-bpg="0"></button>
    </div>
    <div class="skill-bottom">
        <div class="player-salary">
            <p><span class="fc-blue">연봉</span>$&nbsp;<span><?=number_format($info['player_salary']);?></span></p>
            <button type="button" class="btn-yellow player-stats open-btn" data-target="modal-1" onclick="alert('조회 데이터가 없습니다.');">전적 조회</button>
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
                <th>전투력</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><?=round($info['player_point']);?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
