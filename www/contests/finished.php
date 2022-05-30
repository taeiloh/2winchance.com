<?php
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 파라미터
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    // 세션 정리
    $_se_idx        = !empty($_SESSION['_se_idx'])      ? $_SESSION['_se_idx']      : 0;

    // 변수 정리
    $where      = '';

    $where      .= "
        AND g_status IN (3, 4)
    ";

    /*
    $where      .= "
        AND join_contest.result_report='finished'
    ";
*/

} catch (Exception $e) {
    p($e);
}
$query  = "
                            SELECT
                                count(*)
                            FROM
                            (
                                SELECT
                                    jc_idx
                                FROM join_contest
                                WHERE 1=1
                                    AND jc_u_idx = {$_se_idx}
                            ) b INNER JOIN join_contest
                                ON join_contest.jc_idx = b.jc_idx
                            LEFT JOIN lineups
                                ON lu_idx = jc_lineups
                            LEFT JOIN game
                                ON g_idx = jc_game
                            LEFT JOIN game_category
                                ON gc_idx = g_sport
                            LEFT JOIN members
                                ON m_idx = lu_u_idx
                            WHERE 1=1
                                AND lu_u_idx = {$_se_idx}
                                {$where}



                        ";
//echo $query;
$result = $_mysqli->query($query);
if (!$result) {

}
$row1 = mysqli_fetch_row($result);
$total_count = $row1[0]; //전체갯수

$rows = 10;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

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
                <div class="contents-nav inner">
                    <?php
                    // nav
                    require_once __DIR__ .'/../common/nav_contests.php';
                    ?>
                </div>

                <div class="contents-cont inner">
                    <table class="contents-table fold-table">
                        <colgroup>
                            <col style="width:25.142%">
                            <col style="width:16.572%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:8.286%">
                            <col style="width:25.142%">
                        </colgroup>
                        <thead>
                        <tr class="filter">
                            <th>콘테스트</th>
                            <th><a href="javascript:void(0);">경기 종료 시간</a></th>
                            <th><a href="javascript:void(0);">중복</a></th>
                            <th><a href="javascript:void(0);">내 점수</a></th>
                            <th><a href="javascript:void(0);">사용 FP</a></th>
                            <th><a href="javascript:void(0);">상금</a></th>
                            <th>
                                <input type="search" placeholder="플레이어를 검색해주세요.">
                                <button class="search-btn"></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($_se_idx == 16){
                        ?>



                        <tr class="view">
                            <td>COUNTER SHOT [싱글 & 우승 252FP]	</td>
                            <td>2022-05-29 23:00​</td>
                            <td>1</td>
                            <td>65</td>
                            <td>50</td>
                            <td>252</td>
                            <td>
                                <p>결과보기 <img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
                            </td>
                        </tr>
                        <tr class="fold open">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>입상 순위</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>순위</th>
                                                    <th>ID</th>
                                                    <th>상금</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>victorglentz</td>
                                                        <td>252</td>
                                                        <td>65</td>
                                                    </tr>
                                                     <tr>
                                                        <td>2</td>
                                                        <td>ddol303</td>
                                                        <td>216</td>
                                                        <td>60</td>
                                                     </tr>
                                                     <tr>
                                                         <td>3</td>
                                                         <td>elmagolucero</td>
                                                         <td>180</td>
                                                         <td>59</td>
                                                     </tr>
                                                     <tr>
                                                         <td>4</td>
                                                         <td>first_incel</td>
                                                         <td>144</td>
                                                         <td>54</td>
                                                     </tr>
                                                     <tr>
                                                         <td>5</td>
                                                         <td>adamgrutz</td>
                                                         <td>108</td>
                                                         <td>51</td>
                                                     </tr>
                                                     <tr>
                                                         <td>6</td>
                                                         <td>antoniohafelipe</td>
                                                         <td>0</td>
                                                         <td>50</td>
                                                     </tr>
                                                     <tr>
                                                          <td>7</td>
                                                          <td>ljurczak1208</td>
                                                          <td>0</td>
                                                          <td>48</td>
                                                     </tr>
                                                     <tr>
                                                          <td>8</td>
                                                          <td>cvanderbilt5</td>
                                                          <td>0</td>
                                                          <td>47</td>
                                                     </tr>
                                                     <tr>
                                                         <td>9</td>
                                                         <td>box99</td>
                                                         <td>0</td>
                                                         <td>45</td>
                                                     </tr>
                                                     <tr>
                                                         <td>10</td>
                                                         <td>cparker04005</td>
                                                         <td>0</td>
                                                         <td>42</td>
                                                     </tr>
                                                     <tr>
                                                          <td>11</td>
                                                          <td>ejrtkd5899</td>
                                                          <td>0</td>
                                                          <td>40</td>
                                                     </tr>
                                                     <tr>
                                                        <td>12</td>
                                                        <td>bigroyers01</td>
                                                        <td>0</td>
                                                        <td>39</td>
                                                     </tr>
                                                     <tr>
                                                        <td>13</td>
                                                        <td>zhflrkq123</td>
                                                        <td>0</td>
                                                        <td>38</td>
                                                     </tr>
                                                     <tr>
                                                        <td>14</td>
                                                        <td>el_joelvalerio2</td>
                                                        <td>0</td>
                                                        <td>37</td>
                                                     </tr>
                                                     <tr>
                                                         <td>15</td>
                                                         <td>dennis.mille</td>
                                                         <td>0</td>
                                                         <td>33</td>
                                                      </tr>
                                                     <tr>
                                                         <td>16</td>
                                                         <td>cristi.platica</td>
                                                         <td>0</td>
                                                         <td>32</td>
                                                     </tr>
                                                      <tr>
                                                         <td>17</td>
                                                         <td>crazymanqu</td>
                                                         <td>0</td>
                                                         <td>31</td>
                                                      </tr>
                                                      <tr>
                                                         <td>18</td>
                                                         <td>mitchell.duttry</td>
                                                         <td>0</td>
                                                         <td>30</td>
                                                      </tr>
                                                      <tr>
                                                          <td>19</td>
                                                          <td>damien-emma</td>
                                                          <td>0</td>
                                                          <td>28</td>
                                                       </tr>
                                                      <tr>
                                                          <td>20</td>
                                                          <td>abhisek.ekka17</td>
                                                          <td>0</td>
                                                          <td>22</td>
                                                      </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>선수 상세 결과</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>포지션</th>
                                                    <th>이름</th>
                                                    <th>콘테스트</th>
                                                    <th>상세 내용</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>오더</td>
                                                    <td>HingHing</td>
                                                    <td>COUNTER SHOT​</td>
                                                    <td class="hover">
                                                        <p>팀순위(10) 킬수(2) 팀킬(0) 자살(0) 부활(3)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>15</td>
                                                </tr>
                                                <tr>
                                                    <td>정찰</td>
                                                    <td>Loki</td>
                                                    <td>COUNTER SHOT</td>
                                                    <td class="hover">
                                                        <p>팀순위(5) 킬수(4) 팀킬(0) 자살(0) 부활(3)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>9</td>
                                                </tr>
                                                <tr>
                                                    <td>포탑</td>
                                                    <td>Ted</td>
                                                    <td>COUNTER SHOT</td>
                                                    <td class="hover">
                                                        <p>팀순위(2) 킬수(0) 팀킬(1) 자살(0) 부활(0)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>돌격</td>
                                                    <td>Hanya</td>
                                                    <td>COUNTER SHOT</td>
                                                    <td class="hover">
                                                        <p>팀순위(0) 킬수(6) 팀킬(0) 자살(0) 부활(3)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>9</td>
                                                </tr>
                                                <tr>
                                                    <td>유틸</td>
                                                    <td>C4tch</td>
                                                    <td>COUNTER SHOT</td>
                                                    <td class="hover">
                                                        <p>팀순위(6) 킬수(10) 팀킬(0) 자살(0) 부활(0)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>16</td>
                                                </tr>
                                                 <tr>
                                                      <td>유틸</td>
                                                      <td>Juwon</td>
                                                      <td>COUNTER SHOT</td>
                                                      <td class="hover">
                                                          <p>팀순위(3) 킬수(1) 팀킬(0) 자살(0) 부활(0)</p>
                                                          <div class="tooltip">
                                                              <p class="title">상세 점수</p>
                                                              <div class="score-detail">
                                                                  <dl>
                                                                      <dt>순위</dt>
                                                                      <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>킬수</dt>
                                                                      <dd>$$ X 1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>팀킬</dt>
                                                                      <dd>$$ X -1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>팀킬</dt>
                                                                      <dd>$$ X 1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                              </div>
                                                              <dl class="score-total">
                                                                  <dt>합계</dt>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                          </div>
                                                      </td>
                                                      <td>4</td>
                                                  </tr>
                                                 <tr>
                                                      <td>유틸</td>
                                                      <td>HingHing</td>
                                                      <td>COUNTER SHOT</td>
                                                      <td class="hover">
                                                          <p>팀순위(4) 킬수(1) 팀킬(0) 자살(0) 부활(4)</p>
                                                          <div class="tooltip">
                                                              <p class="title">상세 점수</p>
                                                              <div class="score-detail">
                                                                  <dl>
                                                                      <dt>순위</dt>
                                                                      <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>킬수</dt>
                                                                      <dd>$$ X 1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>팀킬</dt>
                                                                      <dd>$$ X -1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>팀킬</dt>
                                                                      <dd>$$ X 1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                              </div>
                                                              <dl class="score-total">
                                                                  <dt>합계</dt>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                          </div>
                                                      </td>
                                                      <td>9</td>
                                                </tr>
                                                 <tr>
                                                      <td>유틸</td>
                                                      <td>Hi</td>
                                                      <td>COUNTER SHOT</td>
                                                      <td class="hover">
                                                          <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                          <div class="tooltip">
                                                              <p class="title">상세 점수</p>
                                                              <div class="score-detail">
                                                                  <dl>
                                                                      <dt>순위</dt>
                                                                      <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>킬수</dt>
                                                                      <dd>$$ X 1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>팀킬</dt>
                                                                      <dd>$$ X -1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                                  <dl>
                                                                      <dt>팀킬</dt>
                                                                      <dd>$$ X 1</dd>
                                                                      <dd>= $$</dd>
                                                                  </dl>
                                                              </div>
                                                              <dl class="score-total">
                                                                  <dt>합계</dt>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                          </div>
                                                      </td>
                                                      <td>0</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>최종 참여자 수에 따라 최종 상금이 변경될 수 있습니다.</p>
                                        <p>* 다른 참여자 닉네임을 클릭하면 선수 상세 내역을 확인 하실 수 있습니다.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                         <tr class="view">
                            <td>4 MAN [싱글 & 상위 50% WIN]</td>
                            <td>2022-05-29 23:00</td>
                            <td>1</td>
                            <td>61</td>
                            <td>90</td>
                            <td>162</td>
                            <td>
                                <p>결과보기 <img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
                            </td>
                        </tr>
                        <tr class="fold">
                            <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>입상 순위</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>순위</th>
                                                    <th>ID</th>
                                                    <th>상금</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                   <td>1</td>
                                                   <td>ddol303</td>
                                                   <td>162</td>
                                                   <td>92</td>
                                               </tr>
                                                <tr>
                                                   <td>2</td>
                                                   <td>gaetan.c35550</td>
                                                   <td>162</td>
                                                   <td>88</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>cvanderbilt5</td>
                                                    <td>162</td>
                                                    <td>87</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>box99</td>
                                                    <td>162</td>
                                                    <td>86</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>cparker04005</td>
                                                    <td>162</td>
                                                    <td>85</td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>cramtous</td>
                                                    <td>162</td>
                                                    <td>80</td>
                                                </tr>
                                                <tr>
                                                     <td>7</td>
                                                     <td>ana5858</td>
                                                     <td>162</td>
                                                     <td>78</td>
                                                </tr>
                                                <tr>
                                                     <td>8</td>
                                                     <td>donmartin483</td>
                                                     <td>162</td>
                                                     <td>76</td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>han07han</td>
                                                    <td>162</td>
                                                    <td>74</td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>sosayo</td>
                                                    <td>162</td>
                                                    <td>73</td>
                                                </tr>
                                                <tr>
                                                     <td>11</td>
                                                     <td>moo9356</td>
                                                     <td>162</td>
                                                     <td>69</td>
                                                </tr>
                                                <tr>
                                                   <td>12</td>
                                                   <td>sg41688</td>
                                                   <td>162</td>
                                                   <td>63</td>
                                                </tr>
                                                <tr>
                                                   <td>13</td>
                                                   <td>hwseog</td>
                                                   <td>162</td>
                                                   <td>62</td>
                                                </tr>
                                                <tr>
                                                   <td>14</td>
                                                   <td>victorglentz</td>
                                                   <td>162</td>
                                                   <td>61</td>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td>antoniohafelipe</td>
                                                    <td>0</td>
                                                    <td>55</td>
                                                 </tr>
                                                <tr>
                                                    <td>16</td>
                                                    <td>zhflrkq123</td>
                                                    <td>0</td>
                                                    <td>53</td>
                                                </tr>
                                                 <tr>
                                                    <td>17</td>
                                                    <td>dennis.mille</td>
                                                    <td>0</td>
                                                    <td>52</td>
                                                 </tr>
                                                 <tr>
                                                    <td>18</td>
                                                    <td>el_joelvalerio2</td>
                                                    <td>0</td>
                                                    <td>51</td>
                                                 </tr>
                                                 <tr>
                                                     <td>19</td>
                                                     <td>cristi.platica</td>
                                                     <td>0</td>
                                                     <td>45</td>
                                                  </tr>
                                                 <tr>
                                                     <td>20</td>
                                                     <td>mitchell.duttry</td>
                                                     <td>0</td>
                                                     <td>41</td>
                                                 </tr>
                                                 <tr>
                                                   <td>21</td>
                                                   <td>crazymanqu</td>
                                                   <td>0</td>
                                                   <td>40</td>
                                                </tr>
                                                <tr>
                                                   <td>22</td>
                                                   <td>abhisek.ekka17</td>
                                                   <td>0</td>
                                                   <td>29</td>
                                                </tr>
                                                <tr>
                                                   <td>23</td>
                                                   <td>damien-emma</td>
                                                   <td>0</td>
                                                   <td>25</td>
                                                </tr>
                                                <tr>
                                                    <td>24</td>
                                                    <td>ejrtkd5899</td>
                                                    <td>0</td>
                                                    <td>22</td>
                                                 </tr>
                                                <tr>
                                                    <td>25</td>
                                                    <td>elmagolucero</td>
                                                    <td>0</td>
                                                    <td>21</td>
                                                </tr>
                                                 <tr>
                                                    <td>26</td>
                                                    <td>first_incel</td>
                                                    <td>0</td>
                                                    <td>19</td>
                                                 </tr>
                                                 <tr>
                                                    <td>27</td>
                                                    <td>adamgrutz</td>
                                                    <td>0</td>
                                                    <td>15</td>
                                                 </tr>
                                                 <tr>
                                                     <td>28</td>
                                                     <td>ljurczak1208</td>
                                                     <td>0</td>
                                                     <td>7</td>
                                                  </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>선수 상세 결과</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>포지션</th>
                                                    <th>이름</th>
                                                    <th>콘테스트</th>
                                                    <th>상세 내용</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>오더</td>
                                                    <td>2heart</td>
                                                    <td>4 MAN</td>
                                                    <td class="hover">
                                                        <p>팀순위(6) 킬수(4) 팀킬(0) 자살(0) 부활(0)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>10</td>
                                                </tr>
                                                <tr>
                                                    <td>정찰</td>
                                                    <td>CRANK</td>
                                                    <td>4 MAN</td>
                                                    <td class="hover">
                                                        <p>팀순위(2) 킬수(5) 팀킬(0) 자살(0) 부활(1)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>8</td>
                                                </tr>
                                                <tr>
                                                    <td>포탑</td>
                                                    <td>mickey</td>
                                                    <td>4 MAN</td>
                                                    <td class="hover">
                                                        <p>팀순위(5) 킬수(5) 팀킬(0) 자살(0) 부활(0)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>10</td>
                                                </tr>
                                                <tr>
                                                    <td>돌격</td>
                                                    <td>asura</td>
                                                    <td>4 MAN</td>
                                                    <td class="hover">
                                                        <p>팀순위(10) 킬수(6) 팀킬(0) 자살(0) 부활(3)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>19</td>
                                                </tr>
                                                <tr>
                                                  <td>유틸</td>
                                                  <td>Ionix</td>
                                                  <td>4 MAN</td>
                                                  <td class="hover">
                                                      <p>팀순위(0) 킬수(1) 팀킬(0) 자살(0) 부활(0)</p>
                                                      <div class="tooltip">
                                                          <p class="title">상세 점수</p>
                                                          <div class="score-detail">
                                                              <dl>
                                                                  <dt>순위</dt>
                                                                  <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>킬수</dt>
                                                                  <dd>$$ X 1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>팀킬</dt>
                                                                  <dd>$$ X -1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>팀킬</dt>
                                                                  <dd>$$ X 1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                          </div>
                                                          <dl class="score-total">
                                                              <dt>합계</dt>
                                                              <dd>= $$</dd>
                                                          </dl>
                                                      </div>
                                                  </td>
                                                  <td>1</td>
                                              </tr>
                                              <tr>
                                                  <td>유틸</td>
                                                  <td>Lambu</td>
                                                  <td>4 MAN</td>
                                                  <td class="hover">
                                                      <p>팀순위(3) 킬수(2) 팀킬(0) 자살(0) 부활(0)</p>
                                                      <div class="tooltip">
                                                          <p class="title">상세 점수</p>
                                                          <div class="score-detail">
                                                              <dl>
                                                                  <dt>순위</dt>
                                                                  <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>킬수</dt>
                                                                  <dd>$$ X 1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>팀킬</dt>
                                                                  <dd>$$ X -1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>팀킬</dt>
                                                                  <dd>$$ X 1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                          </div>
                                                          <dl class="score-total">
                                                              <dt>합계</dt>
                                                              <dd>= $$</dd>
                                                          </dl>
                                                      </div>
                                                  </td>
                                                  <td>5</td>
                                              </tr>
                                               <tr>
                                                    <td>유틸</td>
                                                    <td>R0wha</td>
                                                    <td>4 MAN</td>
                                                    <td class="hover">
                                                        <p>팀순위(4) 킬수(2) 팀킬(0) 자살(0) 부활(1)</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>7</td>
                                                </tr>
                                               <tr>
                                                  <td>유틸</td>
                                                  <td>Adder</td>
                                                  <td>4 MAN</td>
                                                  <td class="hover">
                                                      <p>팀순위(1) 킬수(2) 팀킬(0) 자살(0) 부활(0)</p>
                                                      <div class="tooltip">
                                                          <p class="title">상세 점수</p>
                                                          <div class="score-detail">
                                                              <dl>
                                                                  <dt>순위</dt>
                                                                  <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>킬수</dt>
                                                                  <dd>$$ X 1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>팀킬</dt>
                                                                  <dd>$$ X -1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                              <dl>
                                                                  <dt>팀킬</dt>
                                                                  <dd>$$ X 1</dd>
                                                                  <dd>= $$</dd>
                                                              </dl>
                                                          </div>
                                                          <dl class="score-total">
                                                              <dt>합계</dt>
                                                              <dd>= $$</dd>
                                                          </dl>
                                                      </div>
                                                  </td>
                                                  <td>1</td>
                                              </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>최종 참여자 수에 따라 최종 상금이 변경될 수 있습니다.</p>
                                        <p>* 다른 참여자 닉네임을 클릭하면 선수 상세 내역을 확인 하실 수 있습니다.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="view">
                                <td>FREE [싱글 & 상위 50% WIN]</td>
                                <td>2022-05-29 23:00​</td>
                                <td>1</td>
                                <td>61</td>
                                <td>0</td>
                                <td>5</td>
                                <td>
                                    <p>결과보기 <img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
                                </td>
                            </tr>
                            <tr class="fold">
                                <td colspan="7">
                                    <div class="fold-content">
                                        <div class="fold-table-wrap">
                                            <div class="lanking-table">
                                                <h3>입상 순위</h3>
                                                <table>
                                                    <thead>
                                                    <tr>
                                                        <th>순위</th>
                                                        <th>ID</th>
                                                        <th>상금</th>
                                                        <th>점수</th>
                                                    </tr>
                                                    </thead>
                                                     <tbody>
                                                         <tr>
                                                            <td>1</td>
                                                            <td>reviewtest02</td>
                                                            <td>5</td>
                                                            <td>91</td>
                                                        </tr>
                                                         <tr>
                                                            <td>2</td>
                                                            <td>cvanderbilt5</td>
                                                            <td>5</td>
                                                            <td>82</td>
                                                         </tr>
                                                         <tr>
                                                             <td>3</td>
                                                             <td>ljurczak1208</td>
                                                             <td>5</td>
                                                             <td>79</td>
                                                         </tr>
                                                         <tr>
                                                             <td>4</td>
                                                             <td>box99</td>
                                                             <td>5</td>
                                                             <td>74</td>
                                                         </tr>
                                                         <tr>
                                                             <td>5</td>
                                                             <td>cparker04005</td>
                                                             <td>5</td>
                                                             <td>71</td>
                                                         </tr>
                                                         <tr>
                                                             <td>6</td>
                                                             <td>cramtous</td>
                                                             <td>5</td>
                                                             <td>66</td>
                                                         </tr>
                                                         <tr>
                                                              <td>7</td>
                                                              <td>ana5858</td>
                                                              <td>5</td>
                                                              <td>66</td>
                                                         </tr>
                                                         <tr>
                                                              <td>8</td>
                                                              <td>donmartin483</td>
                                                              <td>5</td>
                                                              <td>64</td>
                                                         </tr>
                                                         <tr>
                                                             <td>9</td>
                                                             <td>Victorglentz</td>
                                                             <td>5</td>
                                                             <td>61</td>
                                                         </tr>
                                                         <tr>
                                                             <td>10</td>
                                                             <td>sosayo</td>
                                                             <td>5</td>
                                                             <td>55</td>
                                                         </tr>
                                                         <tr>
                                                              <td>11</td>
                                                              <td>moo9356</td>
                                                              <td>5</td>
                                                              <td>54</td>
                                                         </tr>
                                                         <tr>
                                                            <td>12</td>
                                                            <td>sg41688</td>
                                                            <td>5</td>
                                                            <td>53</td>
                                                         </tr>
                                                         <tr>
                                                            <td>13</td>
                                                            <td>hwseog</td>
                                                            <td>5</td>
                                                            <td>50</td>
                                                         </tr>
                                                         <tr>
                                                            <td>14</td>
                                                            <td>gaetan.c35550</td>
                                                            <td>5</td>
                                                            <td>48</td>
                                                         </tr>
                                                         <tr>
                                                             <td>15</td>
                                                             <td>first_incel</td>
                                                             <td>5</td>
                                                             <td>48</td>
                                                          </tr>
                                                         <tr>
                                                             <td>16</td>
                                                             <td>antoniohafelipe</td>
                                                             <td>0</td>
                                                             <td>43</td>
                                                         </tr>
                                                          <tr>
                                                             <td>17</td>
                                                             <td>ddol303.mille</td>
                                                             <td>0</td>
                                                             <td>41</td>
                                                          </tr>
                                                          <tr>
                                                             <td>18</td>
                                                             <td>el_joelvalerio2</td>
                                                             <td>0</td>
                                                             <td>37</td>
                                                          </tr>
                                                          <tr>
                                                              <td>19</td>
                                                              <td>zhflrkq123</td>
                                                              <td>0</td>
                                                              <td>32</td>
                                                           </tr>
                                                          <tr>
                                                              <td>20</td>
                                                              <td>cristi.platica</td>
                                                              <td>0</td>
                                                              <td>31</td>
                                                          </tr>
                                                          <tr>
                                                            <td>21</td>
                                                            <td>dennis.mille</td>
                                                            <td>0</td>
                                                            <td>30</td>
                                                         </tr>
                                                         <tr>
                                                            <td>22</td>
                                                            <td>crazymanqu</td>
                                                            <td>0</td>
                                                            <td>27</td>
                                                         </tr>
                                                         <tr>
                                                            <td>23</td>
                                                            <td>mitchell.duttry</td>
                                                            <td>0</td>
                                                            <td>26</td>
                                                         </tr>
                                                         <tr>
                                                             <td>24</td>
                                                             <td>damien-emma</td>
                                                             <td>0</td>
                                                             <td>25</td>
                                                          </tr>
                                                         <tr>
                                                             <td>25</td>
                                                             <td>abhisek.ekka17</td>
                                                             <td>0</td>
                                                             <td>25</td>
                                                         </tr>
                                                          <tr>
                                                             <td>26</td>
                                                             <td>bigroyers01</td>
                                                             <td>0</td>
                                                             <td>25</td>
                                                          </tr>
                                                          <tr>
                                                             <td>27</td>
                                                             <td>elmagolucero</td>
                                                             <td>0</td>
                                                             <td>23</td>
                                                          </tr>
                                                          <tr>
                                                              <td>28</td>
                                                              <td>ejrtkd5899</td>
                                                              <td>0</td>
                                                              <td>21</td>
                                                           </tr>
                                                             <tr>
                                                                <td>29</td>
                                                                <td>adamgrutz</td>
                                                                <td>0</td>
                                                                <td>20</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>30</td>
                                                                 <td>han07han</td>
                                                                 <td>0</td>
                                                                 <td>18</td>
                                                              </tr>
                                                         </tbody>
                                                </table>
                                            </div>
                                            <div class="player-table">
                                                <h3>선수 상세 결과</h3>
                                                <table>
                                                    <thead>
                                                    <tr>
                                                        <th>포지션</th>
                                                        <th>이름</th>
                                                        <th>콘테스트</th>
                                                        <th>상세 내용</th>
                                                        <th>점수</th>
                                                    </tr>
                                                    </thead>
                                                   <tbody>
                                                       <tr>
                                                           <td>오더</td>
                                                           <td>NN</td>
                                                           <td>FREE</td>
                                                           <td class="hover">
                                                               <p>팀순위(0) 킬수(2) 팀킬(0) 자살(0) 부활(3)</p>
                                                               <div class="tooltip">
                                                                   <p class="title">상세 점수</p>
                                                                   <div class="score-detail">
                                                                       <dl>
                                                                           <dt>순위</dt>
                                                                           <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>킬수</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X -1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                   </div>
                                                                   <dl class="score-total">
                                                                       <dt>합계</dt>
                                                                       <dd>= $$</dd>
                                                                   </dl>
                                                               </div>
                                                           </td>
                                                           <td>5</td>
                                                       </tr>
                                                       <tr>
                                                           <td>정찰</td>
                                                           <td>Meerkat</td>
                                                           <td>FREE</td>
                                                           <td class="hover">
                                                               <p>팀순위(10) 킬수(4) 팀킬(0) 자살(0) 부활(0)</p>
                                                               <div class="tooltip">
                                                                   <p class="title">상세 점수</p>
                                                                   <div class="score-detail">
                                                                       <dl>
                                                                           <dt>순위</dt>
                                                                           <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>킬수</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X -1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                   </div>
                                                                   <dl class="score-total">
                                                                       <dt>합계</dt>
                                                                       <dd>= $$</dd>
                                                                   </dl>
                                                               </div>
                                                           </td>
                                                           <td>14</td>
                                                       </tr>
                                                       <tr>
                                                           <td>포탑</td>
                                                           <td>Marke</td>
                                                           <td>FREE</td>
                                                           <td class="hover">
                                                               <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(3)</p>
                                                               <div class="tooltip">
                                                                   <p class="title">상세 점수</p>
                                                                   <div class="score-detail">
                                                                       <dl>
                                                                           <dt>순위</dt>
                                                                           <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>킬수</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X -1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                   </div>
                                                                   <dl class="score-total">
                                                                       <dt>합계</dt>
                                                                       <dd>= $$</dd>
                                                                   </dl>
                                                               </div>
                                                           </td>
                                                           <td>3</td>
                                                       </tr>
                                                       <tr>
                                                           <td>돌격</td>
                                                           <td>Sparrow</td>
                                                           <td>FREE</td>
                                                           <td class="hover">
                                                               <p>팀순위(10) 킬수(6) 팀킬(0) 자살(0) 부활(3)</p>
                                                               <div class="tooltip">
                                                                   <p class="title">상세 점수</p>
                                                                   <div class="score-detail">
                                                                       <dl>
                                                                           <dt>순위</dt>
                                                                           <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>킬수</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X -1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                   </div>
                                                                   <dl class="score-total">
                                                                       <dt>합계</dt>
                                                                       <dd>= $$</dd>
                                                                   </dl>
                                                               </div>
                                                           </td>
                                                           <td>19</td>
                                                       </tr>
                                                       <tr>
                                                         <td>유틸</td>
                                                         <td>Black9</td>
                                                         <td>FREE</td>
                                                         <td class="hover">
                                                             <p>팀순위(0) 킬수(10) 팀킬(0) 자살(0) 부활(0)</p>
                                                             <div class="tooltip">
                                                                 <p class="title">상세 점수</p>
                                                                 <div class="score-detail">
                                                                     <dl>
                                                                         <dt>순위</dt>
                                                                         <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>킬수</dt>
                                                                         <dd>$$ X 1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>팀킬</dt>
                                                                         <dd>$$ X -1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>팀킬</dt>
                                                                         <dd>$$ X 1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                 </div>
                                                                 <dl class="score-total">
                                                                     <dt>합계</dt>
                                                                     <dd>= $$</dd>
                                                                 </dl>
                                                             </div>
                                                         </td>
                                                         <td>10</td>
                                                     </tr>
                                                     <tr>
                                                         <td>유틸</td>
                                                         <td>Akad</td>
                                                         <td>FREE</td>
                                                         <td class="hover">
                                                             <p>팀순위(1) 킬수(1) 팀킬(0) 자살(0) 부활(0)</p>
                                                             <div class="tooltip">
                                                                 <p class="title">상세 점수</p>
                                                                 <div class="score-detail">
                                                                     <dl>
                                                                         <dt>순위</dt>
                                                                         <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>킬수</dt>
                                                                         <dd>$$ X 1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>팀킬</dt>
                                                                         <dd>$$ X -1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>팀킬</dt>
                                                                         <dd>$$ X 1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                 </div>
                                                                 <dl class="score-total">
                                                                     <dt>합계</dt>
                                                                     <dd>= $$</dd>
                                                                 </dl>
                                                             </div>
                                                         </td>
                                                         <td>2</td>
                                                     </tr>
                                                      <tr>
                                                           <td>유틸</td>
                                                           <td>Adder</td>
                                                           <td>FREE</td>
                                                           <td class="hover">
                                                               <p>팀순위(1) 킬수(1) 팀킬(0) 자살(0) 부활(4)</p>
                                                               <div class="tooltip">
                                                                   <p class="title">상세 점수</p>
                                                                   <div class="score-detail">
                                                                       <dl>
                                                                           <dt>순위</dt>
                                                                           <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>킬수</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X -1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                   </div>
                                                                   <dl class="score-total">
                                                                       <dt>합계</dt>
                                                                       <dd>= $$</dd>
                                                                   </dl>
                                                               </div>
                                                           </td>
                                                           <td>7</td>
                                                       </tr>
                                                      <tr>
                                                          <td>유틸</td>
                                                         <td>Hwan2da</td>
                                                         <td>FREE</td>
                                                         <td class="hover">
                                                             <p>팀순위(1) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                             <div class="tooltip">
                                                                 <p class="title">상세 점수</p>
                                                                 <div class="score-detail">
                                                                     <dl>
                                                                         <dt>순위</dt>
                                                                         <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>킬수</dt>
                                                                         <dd>$$ X 1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>팀킬</dt>
                                                                         <dd>$$ X -1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                     <dl>
                                                                         <dt>팀킬</dt>
                                                                         <dd>$$ X 1</dd>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                 </div>
                                                                 <dl class="score-total">
                                                                     <dt>합계</dt>
                                                                     <dd>= $$</dd>
                                                                 </dl>
                                                             </div>
                                                         </td>
                                                         <td>1</td>
                                                     </tr>
                                                       </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="status-txt">
                                            <p>최종 참여자 수에 따라 최종 상금이 변경될 수 있습니다.</p>
                                            <p>* 다른 참여자 닉네임을 클릭하면 선수 상세 내역을 확인 하실 수 있습니다.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="view">
                                    <td>에어 드롭 [싱글 & 우승 500FP]</td>
                                    <td>2022-05-29 23:00​</td>
                                    <td>1</td>
                                    <td>0</td>
                                    <td>50</td>
                                    <td>0</td>
                                    <td>
                                        <p>결과보기 <img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
                                    </td>
                                </tr>
                                <tr class="fold">
                                    <td colspan="7">
                                        <div class="fold-content">
                                            <div class="fold-table-wrap">
                                                <div class="lanking-table">
                                                    <h3>입상 순위</h3>
                                                    <table>
                                                        <thead>
                                                        <tr>
                                                            <th>순위</th>
                                                            <th>ID</th>
                                                            <th>상금</th>
                                                            <th>점수</th>
                                                        </tr>
                                                        </thead>
                                                             <tbody>
                                                                 <tr>
                                                                    <td>1</td>
                                                                    <td>ddol303</td>
                                                                    <td>500</td>
                                                                    <td>103</td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>2</td>
                                                                    <td>cvanderbilt5</td>
                                                                    <td>500</td>
                                                                    <td>95</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>3</td>
                                                                     <td>gaetan.c35550</td>
                                                                     <td>0</td>
                                                                     <td>85</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>4</td>
                                                                     <td>cparker04005</td>
                                                                     <td>0</td>
                                                                     <td>66</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>5</td>
                                                                     <td>cramtous</td>
                                                                     <td>0</td>
                                                                     <td>62</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>6</td>
                                                                     <td>ana5858</td>
                                                                     <td>0</td>
                                                                     <td>61</td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td>7</td>
                                                                      <td>donmartin483</td>
                                                                      <td>0</td>
                                                                      <td>57</td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td>8</td>
                                                                      <td>han07han</td>
                                                                      <td>0</td>
                                                                      <td>55</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>9</td>
                                                                     <td>sosayo</td>
                                                                     <td>0</td>
                                                                     <td>52</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>10</td>
                                                                     <td>moo9356</td>
                                                                     <td>0</td>
                                                                     <td>51</td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td>11</td>
                                                                      <td>sg41688</td>
                                                                      <td>0</td>
                                                                      <td>49</td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td>12</td>
                                                                    <td>hwseog</td>
                                                                    <td>0</td>
                                                                    <td>24</td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td>13</td>
                                                                    <td>victorglentz</td>
                                                                    <td>0</td>
                                                                    <td>11</td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td>14</td>
                                                                    <td>ljurczak1208</td>
                                                                    <td>0</td>
                                                                    <td>10</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>15</td>
                                                                     <td>antoniohafelipe</td>
                                                                     <td>0</td>
                                                                     <td>10</td>
                                                                  </tr>
                                                                 <tr>
                                                                     <td>16</td>
                                                                     <td>zhflrkq123</td>
                                                                     <td>0</td>
                                                                     <td>10</td>
                                                                 </tr>
                                                                  <tr>
                                                                     <td>17</td>
                                                                     <td>el_joelvalerio2</td>
                                                                     <td>0</td>
                                                                     <td>10</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td>18</td>
                                                                     <td>cristi.platica</td>
                                                                     <td>0</td>
                                                                     <td>10</td>
                                                                  </tr>
                                                                  <tr>
                                                                      <td>19</td>
                                                                      <td>crazymanqu</td>
                                                                      <td>0</td>
                                                                      <td>7</td>
                                                                   </tr>
                                                                  <tr>
                                                                      <td>20</td>
                                                                      <td>mitchell.duttry</td>
                                                                      <td>0</td>
                                                                      <td>6</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>21</td>
                                                                    <td>abhisek.ekka17</td>
                                                                    <td>0</td>
                                                                    <td>6</td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td>22</td>
                                                                    <td>damien-emma</td>
                                                                    <td>0</td>
                                                                    <td>3</td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td>23</td>
                                                                    <td>bigroyers01</td>
                                                                    <td>0</td>
                                                                    <td>0</td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td>24</td>
                                                                     <td>ejrtkd5899</td>
                                                                     <td>0</td>
                                                                     <td>0</td>
                                                                  </tr>
                                                                 <tr>
                                                                     <td>25</td>
                                                                     <td>elmagolucero</td>
                                                                     <td>0</td>
                                                                     <td>0</td>
                                                                 </tr>
                                                                  <tr>
                                                                     <td>26</td>
                                                                     <td>first_incel</td>
                                                                     <td>0</td>
                                                                     <td>0</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td>27</td>
                                                                     <td>adamgrutz</td>
                                                                     <td>0</td>
                                                                     <td>0</td>
                                                                  </tr>
                                                                  <tr>
                                                                      <td>28</td>
                                                                      <td>gsjin23</td>
                                                                      <td>0</td>
                                                                      <td>0</td>
                                                                   </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="player-table">
                                                    <h3>선수 상세 결과</h3>
                                                    <table>
                                                        <thead>
                                                        <tr>
                                                            <th>포지션</th>
                                                            <th>이름</th>
                                                            <th>콘테스트</th>
                                                            <th>상세 내용</th>
                                                            <th>점수</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>오더</td>
                                                            <td>Akad</td>
                                                            <td>에어드랍</td>
                                                            <td class="hover">
                                                                <p>팀순위(0) 킬수(2) 팀킬(0) 자살(0) 부활(0)</p>
                                                                <div class="tooltip">
                                                                    <p class="title">상세 점수</p>
                                                                    <div class="score-detail">
                                                                        <dl>
                                                                            <dt>순위</dt>
                                                                            <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                        <dl>
                                                                            <dt>킬수</dt>
                                                                            <dd>$$ X 1</dd>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                        <dl>
                                                                            <dt>팀킬</dt>
                                                                            <dd>$$ X -1</dd>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                        <dl>
                                                                            <dt>팀킬</dt>
                                                                            <dd>$$ X 1</dd>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                    </div>
                                                                    <dl class="score-total">
                                                                        <dt>합계</dt>
                                                                        <dd>= $$</dd>
                                                                    </dl>
                                                                </div>
                                                            </td>
                                                            <td>2</td>
                                                        </tr>
                                                         <tr>
                                                              <td>정찰</td>
                                                              <td>Seongjang</td>
                                                              <td>에어드랍</td>
                                                              <td class="hover">
                                                                  <p>팀순위(1) 킬수(1) 팀킬(0) 자살(0) 부활(0)</p>
                                                                  <div class="tooltip">
                                                                      <p class="title">상세 점수</p>
                                                                      <div class="score-detail">
                                                                          <dl>
                                                                              <dt>순위</dt>
                                                                              <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                          <dl>
                                                                              <dt>킬수</dt>
                                                                              <dd>$$ X 1</dd>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                          <dl>
                                                                              <dt>팀킬</dt>
                                                                              <dd>$$ X -1</dd>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                          <dl>
                                                                              <dt>팀킬</dt>
                                                                              <dd>$$ X 1</dd>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                      </div>
                                                                      <dl class="score-total">
                                                                          <dt>합계</dt>
                                                                          <dd>= $$</dd>
                                                                      </dl>
                                                                  </div>
                                                              </td>
                                                              <td>2</td>
                                                          </tr>
                                                           <tr>
                                                              <td>포탑</td>
                                                              <td>KIMGONI</td>
                                                              <td>에어드랍</td>
                                                              <td class="hover">
                                                                  <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                  <div class="tooltip">
                                                                      <p class="title">상세 점수</p>
                                                                      <div class="score-detail">
                                                                          <dl>
                                                                              <dt>순위</dt>
                                                                              <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                          <dl>
                                                                              <dt>킬수</dt>
                                                                              <dd>$$ X 1</dd>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                          <dl>
                                                                              <dt>팀킬</dt>
                                                                              <dd>$$ X -1</dd>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                          <dl>
                                                                              <dt>팀킬</dt>
                                                                              <dd>$$ X 1</dd>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                      </div>
                                                                      <dl class="score-total">
                                                                          <dt>합계</dt>
                                                                          <dd>= $$</dd>
                                                                      </dl>
                                                                  </div>
                                                              </td>
                                                              <td>0</td>
                                                          </tr>
                                                           <tr>
                                                                <td>돌격</td>
                                                                <td>Adder</td>
                                                                <td>에어드랍</td>
                                                                <td class="hover">
                                                                    <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                    <div class="tooltip">
                                                                        <p class="title">상세 점수</p>
                                                                        <div class="score-detail">
                                                                            <dl>
                                                                                <dt>순위</dt>
                                                                                <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>킬수</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X -1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                        </div>
                                                                        <dl class="score-total">
                                                                            <dt>합계</dt>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                    </div>
                                                                </td>
                                                                <td>0</td>
                                                            </tr>
                                                             <tr>
                                                                <td>유틸</td>
                                                                <td>yyoni</td>
                                                                <td>에어드랍</td>
                                                                <td class="hover">
                                                                    <p>팀순위(1) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                    <div class="tooltip">
                                                                        <p class="title">상세 점수</p>
                                                                        <div class="score-detail">
                                                                            <dl>
                                                                                <dt>순위</dt>
                                                                                <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>킬수</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X -1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                        </div>
                                                                        <dl class="score-total">
                                                                            <dt>합계</dt>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                    </div>
                                                                </td>
                                                                <td>1</td>
                                                            </tr>
                                                             <tr>
                                                                <td>유틸</td>
                                                                <td>Temeri</td>
                                                                <td>에어드랍</td>
                                                                <td class="hover">
                                                                    <p>팀순위(0) 킬수(1) 팀킬(0) 자살(0) 부활(0)</p>
                                                                    <div class="tooltip">
                                                                        <p class="title">상세 점수</p>
                                                                        <div class="score-detail">
                                                                            <dl>
                                                                                <dt>순위</dt>
                                                                                <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>킬수</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X -1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                        </div>
                                                                        <dl class="score-total">
                                                                            <dt>합계</dt>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                    </div>
                                                                </td>
                                                                <td>1</td>
                                                            </tr>
                                                             <tr>
                                                                <td>유틸</td>
                                                                <td>AimH</td>
                                                                <td>에어드랍</td>
                                                                <td class="hover">
                                                                    <p>팀순위(1) 킬수(1) 팀킬(0) 자살(0) 부활(3)</p>
                                                                    <div class="tooltip">
                                                                        <p class="title">상세 점수</p>
                                                                        <div class="score-detail">
                                                                            <dl>
                                                                                <dt>순위</dt>
                                                                                <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>킬수</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X -1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                        </div>
                                                                        <dl class="score-total">
                                                                            <dt>합계</dt>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                    </div>
                                                                </td>
                                                                <td>5</td>
                                                            </tr>
                                                             <tr>
                                                                <td>유틸</td>
                                                                <td>Hanya</td>
                                                                <td>에어드랍</td>
                                                                <td class="hover">
                                                                    <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                    <div class="tooltip">
                                                                        <p class="title">상세 점수</p>
                                                                        <div class="score-detail">
                                                                            <dl>
                                                                                <dt>순위</dt>
                                                                                <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>킬수</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X -1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                            <dl>
                                                                                <dt>팀킬</dt>
                                                                                <dd>$$ X 1</dd>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                        </div>
                                                                        <dl class="score-total">
                                                                            <dt>합계</dt>
                                                                            <dd>= $$</dd>
                                                                        </dl>
                                                                    </div>
                                                                </td>
                                                                <td>0</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="status-txt">
                                                <p>최종 참여자 수에 따라 최종 상금이 변경될 수 있습니다.</p>
                                                <p>* 다른 참여자 닉네임을 클릭하면 선수 상세 내역을 확인 하실 수 있습니다.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="view">
                                        <td>SNOW STORM [싱글 & 우승 300FP]</td>
                                        <td>2022-05-29 23:00​</td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td>100</td>
                                        <td>0</td>
                                        <td>
                                            <p>결과보기 <img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
                                        </td>
                                    </tr>
                                    <tr class="fold">
                                        <td colspan="7">
                                            <div class="fold-content">
                                                <div class="fold-table-wrap">
                                                    <div class="lanking-table">
                                                        <h3>입상 순위</h3>
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th>순위</th>
                                                                <th>ID</th>
                                                                <th>상금</th>
                                                                <th>점수</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                             <tr>
                                                                <td>1</td>
                                                                <td>thib.td</td>
                                                                <td>300</td>
                                                                <td>127</td>
                                                            </tr>
                                                             <tr>
                                                                <td>2</td>
                                                                <td>damien-emma</td>
                                                                <td>300</td>
                                                                <td>107</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>3</td>
                                                                 <td>mitchell.duttry</td>
                                                                 <td>300</td>
                                                                 <td>85</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>4</td>
                                                                 <td>crazymanqu</td>
                                                                 <td>0</td>
                                                                 <td>80</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>5</td>
                                                                 <td>cristi.platica</td>
                                                                 <td>0</td>
                                                                 <td>79</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>6</td>
                                                                 <td>dennis.mille</td>
                                                                 <td>0</td>
                                                                 <td>77</td>
                                                             </tr>
                                                             <tr>
                                                                  <td>7</td>
                                                                  <td>el_joelvalerio2</td>
                                                                  <td>0</td>
                                                                  <td>67</td>
                                                             </tr>
                                                             <tr>
                                                                  <td>8</td>
                                                                  <td>zhflrkq123</td>
                                                                  <td>0</td>
                                                                  <td>48</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>9</td>
                                                                 <td>ddol303</td>
                                                                 <td>0</td>
                                                                 <td>9</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>10</td>
                                                                 <td>victorglentz</td>
                                                                 <td>0</td>
                                                                 <td>0 </td>
                                                             </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="player-table">
                                                        <h3>선수 상세 결과</h3>
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th>포지션</th>
                                                                <th>이름</th>
                                                                <th>콘테스트</th>
                                                                <th>상세 내용</th>
                                                                <th>점수</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                          <tr>
                                                             <td>오더</td>
                                                             <td>coldbuff</td>
                                                             <td>SNOW STORM</td>
                                                             <td class="hover">
                                                                 <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                 <div class="tooltip">
                                                                     <p class="title">상세 점수</p>
                                                                     <div class="score-detail">
                                                                         <dl>
                                                                             <dt>순위</dt>
                                                                             <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                         <dl>
                                                                             <dt>킬수</dt>
                                                                             <dd>$$ X 1</dd>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                         <dl>
                                                                             <dt>팀킬</dt>
                                                                             <dd>$$ X -1</dd>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                         <dl>
                                                                             <dt>팀킬</dt>
                                                                             <dd>$$ X 1</dd>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                     </div>
                                                                     <dl class="score-total">
                                                                         <dt>합계</dt>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                 </div>
                                                             </td>
                                                             <td>0</td>
                                                         </tr>
                                                        <tr>
                                                             <td>정찰</td>
                                                             <td>Loki</td>
                                                             <td>SNOW STORM</td>
                                                             <td class="hover">
                                                                <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                 <div class="tooltip">
                                                                     <p class="title">상세 점수</p>
                                                                     <div class="score-detail">
                                                                         <dl>
                                                                             <dt>순위</dt>
                                                                             <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                         <dl>
                                                                             <dt>킬수</dt>
                                                                             <dd>$$ X 1</dd>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                         <dl>
                                                                             <dt>팀킬</dt>
                                                                             <dd>$$ X -1</dd>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                         <dl>
                                                                             <dt>팀킬</dt>
                                                                             <dd>$$ X 1</dd>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                     </div>
                                                                     <dl class="score-total">
                                                                         <dt>합계</dt>
                                                                         <dd>= $$</dd>
                                                                     </dl>
                                                                 </div>
                                                             </td>
                                                             <td>0</td>
                                                         </tr>
                                                        <tr>
                                                           <td>포탑</td>
                                                           <td>Pio</td>
                                                           <td>SNOW STORM</td>
                                                           <td class="hover">
                                                               <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                               <div class="tooltip">
                                                                   <p class="title">상세 점수</p>
                                                                   <div class="score-detail">
                                                                       <dl>
                                                                           <dt>순위</dt>
                                                                           <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>킬수</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X -1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                       <dl>
                                                                           <dt>팀킬</dt>
                                                                           <dd>$$ X 1</dd>
                                                                           <dd>= $$</dd>
                                                                       </dl>
                                                                   </div>
                                                                   <dl class="score-total">
                                                                       <dt>합계</dt>
                                                                       <dd>= $$</dd>
                                                                   </dl>
                                                               </div>
                                                           </td>
                                                           <td>0</td>
                                                       </tr>
                                                            <tr>
                                                                 <td>돌격</td>
                                                                 <td>taemin	</td>
                                                                <td>SNOW STORM</td>
                                                                 <td class="hover">
                                                                     <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                     <div class="tooltip">
                                                                         <p class="title">상세 점수</p>
                                                                         <div class="score-detail">
                                                                             <dl>
                                                                                 <dt>순위</dt>
                                                                                 <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>킬수</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X -1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                         </div>
                                                                         <dl class="score-total">
                                                                             <dt>합계</dt>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                     </div>
                                                                 </td>
                                                                 <td>0</td>
                                                             </tr>
                                                              <tr>
                                                                 <td>유틸</td>
                                                                 <td>WICK2D	</td>
                                                                 <td>SNOW STORM</td>
                                                                 <td class="hover">
                                                                    <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                     <div class="tooltip">
                                                                         <p class="title">상세 점수</p>
                                                                         <div class="score-detail">
                                                                             <dl>
                                                                                 <dt>순위</dt>
                                                                                 <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>킬수</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X -1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                         </div>
                                                                         <dl class="score-total">
                                                                             <dt>합계</dt>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                     </div>
                                                                 </td>
                                                                 <td>0</td>
                                                             </tr>
                                                              <tr>
                                                                 <td>유틸</td>
                                                                 <td>yacha	</td>
                                                                 <td>SNOW STORM</td>
                                                                 <td class="hover">
                                                                    <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                     <div class="tooltip">
                                                                         <p class="title">상세 점수</p>
                                                                         <div class="score-detail">
                                                                             <dl>
                                                                                 <dt>순위</dt>
                                                                                 <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>킬수</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X -1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                         </div>
                                                                         <dl class="score-total">
                                                                             <dt>합계</dt>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                     </div>
                                                                 </td>
                                                                 <td>0</td>
                                                             </tr>
                                                              <tr>
                                                                 <td>유틸</td>
                                                                 <td>Under	</td>
                                                                 <td>SNOW STORM</td>
                                                                 <td class="hover">
                                                                     <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                     <div class="tooltip">
                                                                         <p class="title">상세 점수</p>
                                                                         <div class="score-detail">
                                                                             <dl>
                                                                                 <dt>순위</dt>
                                                                                 <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>킬수</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X -1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                         </div>
                                                                         <dl class="score-total">
                                                                             <dt>합계</dt>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                     </div>
                                                                 </td>
                                                                 <td>0</td>
                                                             </tr>
                                                              <tr>
                                                                 <td>유틸</td>
                                                                 <td>RaY	</td>
                                                                <td>SNOW STORM</td>
                                                                 <td class="hover">
                                                                     <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                     <div class="tooltip">
                                                                         <p class="title">상세 점수</p>
                                                                         <div class="score-detail">
                                                                             <dl>
                                                                                 <dt>순위</dt>
                                                                                 <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>킬수</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X -1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                             <dl>
                                                                                 <dt>팀킬</dt>
                                                                                 <dd>$$ X 1</dd>
                                                                                 <dd>= $$</dd>
                                                                             </dl>
                                                                         </div>
                                                                         <dl class="score-total">
                                                                             <dt>합계</dt>
                                                                             <dd>= $$</dd>
                                                                         </dl>
                                                                     </div>
                                                                 </td>
                                                                 <td>0</td>
                                                             </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="status-txt">
                                                    <p>최종 참여자 수에 따라 최종 상금이 변경될 수 있습니다.</p>
                                                    <p>* 다른 참여자 닉네임을 클릭하면 선수 상세 내역을 확인 하실 수 있습니다.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="view">
                                            <td>돌격 [싱글 & 우승 200FP]</td>
                                            <td>2022-05-29 23:00​</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>100</td>
                                            <td>0</td>
                                            <td>
                                                <p>결과보기 <img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
                                            </td>
                                        </tr>
                                        <tr class="fold">
                                            <td colspan="7">
                                                <div class="fold-content">
                                                    <div class="fold-table-wrap">
                                                        <div class="lanking-table">
                                                            <h3>입상 순위</h3>
                                                            <table>
                                                                <thead>
                                                                <tr>
                                                                    <th>순위</th>
                                                                    <th>ID</th>
                                                                    <th>상금</th>
                                                                    <th>점수</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>ddol303</td>
                                                                <td>200</td>
                                                                <td>75</td>
                                                            </tr>
                                                             <tr>
                                                                <td>2</td>
                                                                <td>zhflrkq123</td>
                                                                <td>200</td>
                                                                <td>43</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>3</td>
                                                                 <td>el_joelvalerio2</td>
                                                                 <td>0</td>
                                                                 <td>24</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>4</td>
                                                                 <td>dennis.mille</td>
                                                                 <td>0</td>
                                                                 <td>0</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>5</td>
                                                                 <td>victorglentz</td>
                                                                 <td>0</td>
                                                                 <td>0</td>
                                                             </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="player-table">
                                                            <h3>선수 상세 결과</h3>
                                                            <table>
                                                                <thead>
                                                                <tr>
                                                                    <th>포지션</th>
                                                                    <th>이름</th>
                                                                    <th>콘테스트</th>
                                                                    <th>상세 내용</th>
                                                                    <th>점수</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                              <tr>
                                                                  <td>오더</td>
                                                                  <td>Gak</td>
                                                                  <td>돌격</td>
                                                                  <td class="hover">
                                                                      <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                      <div class="tooltip">
                                                                          <p class="title">상세 점수</p>
                                                                          <div class="score-detail">
                                                                              <dl>
                                                                                  <dt>순위</dt>
                                                                                  <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                              <dl>
                                                                                  <dt>킬수</dt>
                                                                                  <dd>$$ X 1</dd>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                              <dl>
                                                                                  <dt>팀킬</dt>
                                                                                  <dd>$$ X -1</dd>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                              <dl>
                                                                                  <dt>팀킬</dt>
                                                                                  <dd>$$ X 1</dd>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                          </div>
                                                                          <dl class="score-total">
                                                                              <dt>합계</dt>
                                                                              <dd>= $$</dd>
                                                                          </dl>
                                                                      </div>
                                                                  </td>
                                                                  <td>0</td>
                                                              </tr>
                                                               <tr>
                                                                    <td>정찰</td>
                                                                    <td>Giken</td>
                                                                    <td>돌격</td>
                                                                    <td class="hover">
                                                                        <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                        <div class="tooltip">
                                                                            <p class="title">상세 점수</p>
                                                                            <div class="score-detail">
                                                                                <dl>
                                                                                    <dt>순위</dt>
                                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                    <dd>= $$</dd>
                                                                                </dl>
                                                                                <dl>
                                                                                    <dt>킬수</dt>
                                                                                    <dd>$$ X 1</dd>
                                                                                    <dd>= $$</dd>
                                                                                </dl>
                                                                                <dl>
                                                                                    <dt>팀킬</dt>
                                                                                    <dd>$$ X -1</dd>
                                                                                    <dd>= $$</dd>
                                                                                </dl>
                                                                                <dl>
                                                                                    <dt>팀킬</dt>
                                                                                    <dd>$$ X 1</dd>
                                                                                    <dd>= $$</dd>
                                                                                </dl>
                                                                            </div>
                                                                            <dl class="score-total">
                                                                                <dt>합계</dt>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                        </div>
                                                                    </td>
                                                                    <td>0</td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>포탑</td>
                                                                    <td>RaY</td>
                                                                    <td>돌격</td>
                                                                    <td class="hover">
                                                                        <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                        <div class="tooltip">
                                                                            <p class="title">상세 점수</p>
                                                                            <div class="score-detail">
                                                                                <dl>
                                                                                    <dt>순위</dt>
                                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                    <dd>= $$</dd>
                                                                                </dl>
                                                                                <dl>
                                                                                    <dt>킬수</dt>
                                                                                    <dd>$$ X 1</dd>
                                                                                    <dd>= $$</dd>
                                                                                </dl>
                                                                                <dl>
                                                                                    <dt>팀킬</dt>
                                                                                    <dd>$$ X -1</dd>
                                                                                    <dd>= $$</dd>
                                                                                </dl>
                                                                                <dl>
                                                                                    <dt>팀킬</dt>
                                                                                    <dd>$$ X 1</dd>
                                                                                    <dd>= $$</dd>
                                                                                </dl>
                                                                            </div>
                                                                            <dl class="score-total">
                                                                                <dt>합계</dt>
                                                                                <dd>= $$</dd>
                                                                            </dl>
                                                                        </div>
                                                                    </td>
                                                                    <td>0</td>
                                                                </tr>
                                                                 <tr>
                                                                      <td>돌격</td>
                                                                      <td>Treasure</td>
                                                                      <td>돌격</td>
                                                                      <td class="hover">
                                                                          <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                          <div class="tooltip">
                                                                              <p class="title">상세 점수</p>
                                                                              <div class="score-detail">
                                                                                  <dl>
                                                                                      <dt>순위</dt>
                                                                                      <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>킬수</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X -1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                              </div>
                                                                              <dl class="score-total">
                                                                                  <dt>합계</dt>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                          </div>
                                                                      </td>
                                                                      <td>0</td>
                                                                  </tr>
                                                                   <tr>
                                                                      <td>유틸</td>
                                                                      <td>AimHi</td>
                                                                      <td>돌격</td>
                                                                      <td class="hover">
                                                                          <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                          <div class="tooltip">
                                                                              <p class="title">상세 점수</p>
                                                                              <div class="score-detail">
                                                                                  <dl>
                                                                                      <dt>순위</dt>
                                                                                      <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>킬수</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X -1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                              </div>
                                                                              <dl class="score-total">
                                                                                  <dt>합계</dt>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                          </div>
                                                                      </td>
                                                                      <td>0</td>
                                                                  </tr>
                                                                   <tr>
                                                                      <td>유틸</td>
                                                                      <td>Ted</td>
                                                                      <td>돌격</td>
                                                                      <td class="hover">
                                                                          <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                          <div class="tooltip">
                                                                              <p class="title">상세 점수</p>
                                                                              <div class="score-detail">
                                                                                  <dl>
                                                                                      <dt>순위</dt>
                                                                                      <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>킬수</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X -1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                              </div>
                                                                              <dl class="score-total">
                                                                                  <dt>합계</dt>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                          </div>
                                                                      </td>
                                                                      <td>0</td>
                                                                  </tr>
                                                                   <tr>
                                                                      <td>유틸</td>
                                                                      <td>Adder</td>
                                                                      <td>돌격</td>
                                                                      <td class="hover">
                                                                         <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                          <div class="tooltip">
                                                                              <p class="title">상세 점수</p>
                                                                              <div class="score-detail">
                                                                                  <dl>
                                                                                      <dt>순위</dt>
                                                                                      <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>킬수</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X -1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                              </div>
                                                                              <dl class="score-total">
                                                                                  <dt>합계</dt>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                          </div>
                                                                      </td>
                                                                      <td>0</td>
                                                                  </tr>
                                                                   <tr>
                                                                      <td>유틸</td>
                                                                      <td>Hulk</td>
                                                                      <td>돌격</td>
                                                                      <td class="hover">
                                                                          <p>팀순위(0) 킬수(0) 팀킬(0) 자살(0) 부활(0)</p>
                                                                          <div class="tooltip">
                                                                              <p class="title">상세 점수</p>
                                                                              <div class="score-detail">
                                                                                  <dl>
                                                                                      <dt>순위</dt>
                                                                                      <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>킬수</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X -1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                                  <dl>
                                                                                      <dt>팀킬</dt>
                                                                                      <dd>$$ X 1</dd>
                                                                                      <dd>= $$</dd>
                                                                                  </dl>
                                                                              </div>
                                                                              <dl class="score-total">
                                                                                  <dt>합계</dt>
                                                                                  <dd>= $$</dd>
                                                                              </dl>
                                                                          </div>
                                                                      </td>
                                                                      <td>0</td>
                                                                  </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="status-txt">
                                                        <p>최종 참여자 수에 따라 최종 상금이 변경될 수 있습니다.</p>
                                                        <p>* 다른 참여자 닉네임을 클릭하면 선수 상세 내역을 확인 하실 수 있습니다.</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                        <?php
                            }
                        ?>
                        <!--
                        <?php
                        // 콘테스트
                        $query  = "
                            SELECT
                                join_contest.*,
                                game.*,
                                game_category.gc_name
                            FROM
                            (
                                SELECT
                                    jc_idx
                                FROM join_contest
                                WHERE 1=1
                                    AND jc_u_idx = {$_se_idx}
                            ) b INNER JOIN join_contest
                                ON join_contest.jc_idx = b.jc_idx
                            LEFT JOIN lineups
                                ON lu_idx = jc_lineups
                            LEFT JOIN game
                                ON g_idx = jc_game
                            LEFT JOIN game_category
                                ON gc_idx = g_sport
                            LEFT JOIN members
                                ON m_idx = lu_u_idx
                            WHERE 1=1
                                AND lu_u_idx = {$_se_idx}
                                {$where}
                            GROUP BY jc_game
                            ORDER BY g_date DESC,  jc_result_update DESC
                            LIMIT {$from_record}, {$rows}

                        ";
                        //echo $query;
                        $result = $_mysqli->query($query);
                        if (!$result) {

                        }
                        if($total_count>0){
                        while ($db = $result->fetch_assoc()) {
                            //p($db);


                            echo <<<TR
                        <tr class="view open">
                            <td>{$db['g_name']}</td>
                            <td>{$db['jc_result_update']}</td>
                            <td>{$db['g_multi_max']}</td>
                            <td>{$db['jc_point']}</td>
                            <td>{$db['g_fee']}</td>
                            <td>{$db['g_prize']}</td>
                            <td>
                                <p>결과보기<img src="../images/ico_arrow_blue.svg" alt="결과 보기"></p>
                            </td>
                        </tr>
                        <tr class="fold">
	                        <td colspan="7">
                                <div class="fold-content">
                                    <div class="fold-table-wrap">
                                        <div class="lanking-table">
                                            <h3>입상 순위</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>순위</th>
                                                    <th>ID</th>
                                                    <th>상금</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>
TR;
                            $sub_query  = "
                                SELECT
                                    jc_u_idx, jc_rank, jc_prize, jc_point,
                                    (SELECT m_name FROM members WHERE 1=1 AND m_idx=a.jc_u_idx ) AS m_name
                                FROM join_contest a
                                WHERE 1=1
                                    AND jc_game = {$db['jc_game']}
                                ORDER BY jc_rank
                            ";
                            $sub_result = $_mysqli->query($sub_query);
                            if (!$sub_result) {
                            }
                            $c=0;
                            while ($sub_db = $sub_result->fetch_assoc()) {
                                //p($sub_db);
                                $c++;
                                echo <<<TR
                                                <tr>
                                                    <td>{$c}</td>
                                                    <td>{$sub_db['m_name']}</td>
                                                    <td>{$sub_db['jc_prize']}</td>
                                                    <td>{$sub_db['jc_point']}</td>
                                                </tr>
TR;

                            }

                            echo <<<TR
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="player-table">
                                            <h3>선수 상세 결과</h3>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>포지션</th>
                                                    <th>이름</th>
                                                    <th>콘테스트</th>
                                                    <th>상세 내용</th>
                                                    <th>점수</th>
                                                </tr>
                                                </thead>
                                                <tbody>
TR;
                            $sub_query1  = "
                                SELECT *
                                FROM lineups a
                                LEFT JOIN game b
                                    ON b.g_idx = a.lu_g_idx
                                LEFT JOIN lineups_history c
                                    ON c.lu_idx = a.lu_idx
                                WHERE 1=1
                                    AND c.lu_idx = '{$db['jc_lineups']}'
                            ";
                            $sub_result1 = $_mysqli->query($sub_query1);
                            if (!$sub_result1) {
                            }
                            while ($sub_db1 = $sub_result1->fetch_assoc()) {
                                //p($sub_db);

                                // 경기 정보
                                $_query = "
                                    SELECT *
                                    FROM lineups_history a
                                    LEFT JOIN lineups_history_score b
                                        ON b.game_id = a.game_id
                                    WHERE 1=1
                                        AND a.m_idx = {$_se_idx}
                                        AND a.g_idx = {$sub_db1['g_idx']}
                                        AND a.game_id = '{$sub_db1['game_id']}'
                                        AND a.player_id = '{$sub_db1['player_id']}'
                                ";
                                $_result    = $_mysqli->query($_query);
                                if (!$_result) {

                                }
                                $_db    = $_result->fetch_assoc();
                                //p($_db);
                                $game_info  = "{$_db['home_name']} {$_db['home_score']}:{$_db['away_score']} {$_db['away_name']}";

                                $player_result_json = json_decode($sub_db1['player_result_json'], true);
                                echo <<<TR
                                                <tr>
                                                    <td>{$sub_db1['player_pos']}</td>
                                                    <td>{$sub_db1['player_name']}</td>
                                                    <td>{$game_info}</td>
                                                    <td class="hover">
                                                        {$sub_db1['player_result_json']}
                                                        <p>36p 9 made 3pt 6rebounds</p>
                                                        <div class="tooltip">
                                                            <p class="title">상세 점수</p>
                                                            <div class="score-detail">
                                                                <dl>
                                                                    <dt>순위</dt>
                                                                    <dd>$$ + $$ + $$ + $$ + $$</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>킬수</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X -1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                                <dl>
                                                                    <dt>팀킬</dt>
                                                                    <dd>$$ X 1</dd>
                                                                    <dd>= $$</dd>
                                                                </dl>
                                                            </div>
                                                            <dl class="score-total">
                                                                <dt>합계</dt>
                                                                <dd>= $$</dd>
                                                            </dl>
                                                        </div>
                                                    </td>
                                                    <td>{$sub_db1['game_players_points']}</td>
                                                </tr>
TR;
                            }
                            ?>
                            <?php
                            echo <<<TR

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="status-txt">
                                        <p>최종 참여자 수에 따라 최종 상금이 변경될 수 있습니다.</p>
                                        <p>* 다른 참여자 닉네임을 클릭하면 선수 상세 내역을 확인 하실 수 있습니다.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
TR;
                        }
                        }else{
                            echo <<<TR
                         <tr>
                                <td colspan="7">등록된 정보가 없습니다.</td>
                         </tr>
TR;
                        }
                        ?>-->
                        </tbody>
                    </table>
                </div>
            </section>
            <!--//sec-01-->
            <div class="pagination">
                <?php
                echo paging($page,$total_page,5,"{$_SERVER['SCRIPT_NAME']}?page=");
                ?>
                <!--a href="javascript:void(0)" class="active" >1</a>
                <a href="javascript:void(0)">2</a>
                <a href="javascript:void(0)">3</a>
                <a href="javascript:void(0)">4</a-->
            </div>
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
