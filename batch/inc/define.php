<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-12-17
 * Time: 오후 2:17
 */


    #spobit_web
    define('DBHOST',        '127.0.0.1');
    define('DBUSERNAME',    'web_db');
    define('DBPASSWD',      'Wdfig^df75!&^!Q3e36W');
    define('DBNAME',        'spobit_web');

    #spobit_games
    define('DBHOST2',       '127.0.0.1');
    define('DBUSERNAME2',   'games_db');
    define('DBPASSWD2',     'GDFe35^412#aFDhe5s_d%@!');
    define('DBNAME2',       'spobit_games');

    #spobit_web_tmp
    define('DBHOST3',       '127.0.0.1');
    define('DBUSERNAME3',   'web_db');
    define('DBPASSWD3',     'Wdfig^df75!&^!Q3e36W');
    define('DBNAME3',       'spobit_web_tmp');

//DB include
require __DIR__ .'/dbconnect.php';
require __DIR__ .'/dbconnect2.php';
require __DIR__ .'/dbconnect3.php';

//HTML 파싱
//require __DIR__ .'/simple_html_dom.php';

//NBA [ api key , 포인트]
    #api key 
    define('NBA_KEY',           '65bz7jpuxsz9n3ux5z87wjxf');
    define('NBA_SEASON_YEAR',   2018);
    define('NBA_SEASON_ID',     '47c9979e-5c3f-453d-ac75-734d17412e3f');
    define('NBA_SEASON_TYPE',   'REG');
    define('NBA_LEAGUE_ID',     '4353138d-4c22-4396-95d8-5f587d2df25c');
    define('NBA_LEAGUE_ALIAS',  'NBA');
    define('NBA_CONTENT_TYPE',  'nba');
    define('NBA_TIMEZONE_SET',  'GMT-5');

    #포인트
    define('NBA_POINTS',                1.00);
    define('NBA_THREE_POINTS_MADE',     0.50);
    define('NBA_REBOUNDS',              1.25);
    define('NBA_ASSISTS',               1.50);
    define('NBA_STEALS',                2.00);
    define('NBA_BLOCKS',                2.00);
    define('NBA_TURNOVERS',             0.50);
    define('NBA_DOUBLE_DOUBLE',         1.50);
    define('NBA_TRIPLE_DOUBLE',         3.00);


//EPL [ api key , 포인트]
    #api key 
    define('EPL_KEY',           'dsjtv4hrcdjyruandwq62txy');
    define('EPL_SEASON_YEAR',   2018);
    define('EPL_SEASON_ID',     '47c9979e-5c3f-453d-ac75-734d17412e3f');
    define('EPL_SEASON_TYPE',   'EPL');
    define('EPL_LEAGUE_ID',     '4353138d-4c22-4396-95d8-5f587d2df25c');
    define('EPL_LEAGUE_ALIAS',  'EPL');
    define('EPL_CONTENT_TYPE',  'epl');
    define('EPL_TIMEZONE_SET',  'GMT-2');

    #포인트
    define('EPL_GOAL',                 10.00); // 득점한 골 수
    define('EPL_ASSIST',                6.00); // 어시스트 수
    define('EPL_SHOT',                  1.00); // 공을을 한번 치거나 던지는일
    define('EPL_SHOT_ON_GOAL',          1.00); // 골대를 향한 샷
    define('EPL_CROSSES',               0.75); // 크로스 패스 수
    define('EPL_FOULS_DRAWN',           1.00); // 파울 유도수
    define('EPL_FOULS_CONCEDED',       -0.50); // 파울 실책
    define('EPL_TACKLE_WON',            1.00); // 태클 유도 수
    define('EPL_PASS_INTERCEPTED_DMF',  0.50); // 패스 가로채기
    define('EPL_YELLOW_CARD',          -1.50); // 엘로우 카드
    define('EPL_RED_CARD',             -3.00); // 레드 카드
    define('EPL_SAVES_GK',              2.00); // 골 방어수
    define('EPL_GOAL_CONCEDED_GK',     -2.00); // 골 실책
    define('EPL_CLEAN_SHEET_GK',        5.00); // 무실점 횟수
    define('EPL_CLEAN_SHEET_D',         3.00); // 무실점 횟수
    define('EPL_WIN_GK',                5.00); // 승리 팀



//SOC [ api key , 포인트]
    #SOC
    define('SOC_KEY',           'dsjtv4hrcdjyruandwq62txy');
    define('SOC_SEASON_YEAR',   2018);
    define('SOC_SEASON_ID',     '47c9979e-5c3f-453d-ac75-734d17412e3f');
    define('SOC_TIMEZONE_SET',  'GMT-5');

    #TSL
    define('TSL_KEY',           '');
    define('TSL_SEASON_YEAR',   2018);
    define('TSL_SEASON_ID',     '2018');
    define('TSL_SEASON_TYPE',   '115');
    define('TSL_LEAGUE_ID',     '115');
    define('TSL_LEAGUE_ALIAS',  'TSL');
    define('TSL_CONTENT_TYPE',  'tsl');
    define('TSL_TIMEZONE_SET',  'GMT-5');



//PUBG [ api key , 포인트]
    #api key 
    define('PUBG_KEY',           'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIwMGY3MTQ0MC0xZTA4LTAxMzYtYTA5OS0wYjE5MWE5ZjM2ZmIiLCJpc3MiOiJnYW1lbG9ja2VyIiwiaWF0IjoxNTIzMjY2ODQ2LCJwdWIiOiJibHVlaG9sZSIsInRpdGxlIjoicHViZyIsImFwcCI6ImVkcmFuZXR3b3JrcyJ9.xrYVDWJDSe-5zcLKlF_dcO-1X--QCXruYC0dOrusaSA');
    define('PUBG_SEASON_YEAR',   2019);
    define('PUBG_SEASON_ID',     'kr-pkl19');
    define('PUBG_SEASON_TYPE',   'match');
    define('PUBG_LEAGUE_ID',     'kr-pkl19');
    define('PUBG_LEAGUE_ALIAS',  'PUBG');
    define('PUBG_CONTENT_TYPE',  'pubg');
    define('PUBG_TIMEZONE_SET',  'GMT-5');
    //포인트
    define('PUBG_DBNOs',         1.00);
    define('PUBG_Kills',         1.00);
    define('PUBG_Headshotkills', 1.00);
    define('PUBG_RoadKills',     1.00);
    define('PUBG_damageDealt',   1.00);
    define('PUBG_Heals',         1.00);
    define('PUBG_rankPoints',    1.00);
    define('PUBG_revives',       1.00);
    define('PUBG_TeamKills',    -2.00);


//LOL [ api key , 포인트]
    #api key
    define('LOL_KEY',           'gbfje3c2qsk8v3mub8a2shd7');
    define('LOL_LEAGUE_ALIAS',  'LOL');
    define('LOL_CONTENT_TYPE',  'lol');

    #LCK
    define('LOL_TIMEZONE_SET',  'GMT+9');
    define('LOL_SEASON_TYPE',   'LCK');
    define('LOL_LEAGUE_ID',     'sr:tournament:2454');
    //2018
      //define('LOL_SEASON_YEAR',   2018);
      //define('LOL_SEASON_ID',     'sr:season:58198');
    //2019
      define('LOL_SEASON_YEAR',   2019);    
      define('LOL_SEASON_ID',     'sr:season:65545');



    #LCS EU
    //define('LOL_SEASON_TYPE',   'LCS EU');
    //define('LOL_LEAGUE_ID',     'sr:tournament:2452');
    //define('LOL_SEASON_YEAR',   2018);
    //define('LOL_SEASON_ID',     'sr:season:58198');
    //define('LOL_TIMEZONE_SET',  'GMT-5');

    #LCS NA
    //define('LOL_SEASON_TYPE',   'LCS NA');
    //define('LOL_LEAGUE_ID',     'sr:tournament:2450');
    //define('LOL_SEASON_YEAR',   2018);
    //define('LOL_SEASON_ID',     'sr:season:58198');
    //define('LOL_TIMEZONE_SET',  'GMT-5');

    //포인트
    define('SINGLE_KILLS',         3.00);
    define('SINGLE_ASSISTS',       2.00);
    define('SINGLE_DEATHS',       -1.00);
    define('SINGLE_CREEP_SCORE',   0.02);
    define('SINGLE_10KA_BONUS',    2.00);
    define('TEAM_TURRENTS',        1.00);
    define('TEAM_DRAGONS',         2.00);
    define('TEAM_BARONS',          3.00);
    define('TEAM_FIRST_BLOOD',     2.00);
    define('TEAM_WIN',             2.00);
    define('TEAM_U30W_BONUS',      2.00);

