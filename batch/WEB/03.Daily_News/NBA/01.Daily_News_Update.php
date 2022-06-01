<?php
/**
 * Created by Sublime Text.
 * User: AlexKim
 * Date: 2019-05-24
 * Time: 오후 13:56
 */

//config
require __DIR__ .'../../../../inc/config.php';
require __DIR__ .'../../../../inc/simple_html_dom.php';



try {
    $ymd            = date('Ymd');
    $today          = date('Y-m-d H:i:s');

    //로그
    $log_folder     = __DIR__ .'/log';
    if (!is_dir($log_folder)){ mkdir($log_folder); }  #폴더 없을경우 생성
    $log_filename   = "{$ymd}_Daily_News_Update.php.log";
    $log_path       = $log_folder .'/'. $log_filename;
    $log_txt        = " ";
    write_log($log_path, $log_txt, "a");
    $log_txt        = "=======================";
    write_log($log_path, $log_txt, "a");
    $log_txt        = "START";
    write_log($log_path, $log_txt, "a");


    //변수 정리
    $season_year    = NBA_SEASON_YEAR;
    $season_type    = NBA_SEASON_TYPE;
    $season_id      = NBA_SEASON_ID; //년도별 시즌 id
    $league_alias   = NBA_LEAGUE_ALIAS;
    $league_id      = NBA_LEAGUE_ID;
    $content_type   = NBA_CONTENT_TYPE;


    
    $url = 'https://www.rotoballer.com/player-news?sport=nba'; // 메인뉴스 타이틀 링크검색
    $html_main = file_get_html($url, true);

    $playerimg_path  = "/data/www.spo-bit.com/htdocs/public/images/player_images/nba/news/";



    //메인 뉴스 검색 파싱
    foreach($html_main->find("div.grid_10") as $news_main_widget_list){

        foreach($news_main_widget_list->find('h4') as $news_main_title){
            $widget_teamlogo       = str_replace("widget-title teamLogo ","",trim(strchr($news_main_title->class,"widget-title teamLogo ")));  //팀로고

            $html_sub_link  = $news_main_title->find('a',0)->href;     
            $html_sub_title = str_replace("'","\'",$news_main_title->plaintext);  // 1. 뉴스 타이틀


            //서브 뉴스 검색 파싱
            $html_sub = file_get_html($html_sub_link, true); // 뉴스 타이틀 링크 검색
            foreach($html_sub->find("div.grid_10") as $news_sub_widget_list){
                $widget_news_datetime             = substr(trim($news_sub_widget_list->find('span.newsDate',0)->plaintext),0,5);         // 뉴스 시간
                $widget_news_player_name          = str_replace("'","\'",trim($news_sub_widget_list->find('a.rbPlayer',0)->plaintext));  // 선수이름
                $player_name                      = str_replace("  "," ",$widget_news_player_name);  // 선수이름
                $widget_news_player_link          = trim($news_sub_widget_list->find('a.rbPlayer',0)->href);                           // 선수 링크(세부내역 바로가기)

                    $sub_site_url = 'https://www.rotoballer.com';
                    $html_sub_player = file_get_html($sub_site_url.$widget_news_player_link, true);
                       $profile = $html_sub_player->find("div[id=nbaProfile]",0);
                           $widget_player_img      = $profile->find('img',0)->src;       // 선수 이미지
                           $replace_ary = array("(",")"); // (,) 제거
                           $widget_player_position_replace = preg_replace("/\s+/", "",str_replace($replace_ary,"",strchr($profile->find('h1',0)->plaintext,"(")));;
                           list($widget_player_position, $widget_player_team) = explode(",",$widget_player_position_replace); // 포지션, 팀이름

                //$widget_news_newsdeskContentEntry = str_replace(": ","",trim(strchr(trim($news_sub_widget_list->find('div.newsdeskContentEntry',0)->plaintext),":")));
                $widget_news_newsdeskContentEntry = str_replace("ago ","",trim(strchr($news_sub_widget_list->plaintext,"ago ")));
                    list($widget_news_contents_ary, $widget_news_source_ary) = explode("--",$widget_news_newsdeskContentEntry);  // -- 기준으로 배열하기
                        $news_contents = $widget_news_contents_ary; // 뉴스 내용
                        $news_source   = str_replace("Source","",trim(strchr($widget_news_source_ary,"Source"))); // 뉴스 출처
                        $news_contents            = str_replace("'","\'",$news_contents);  // 뉴스 내용
                        $news_player_link_replace = str_replace("'","\'",$widget_news_player_link);


                //변수 정리
                $game_type     = $league_alias;
                $news_datetime = $widget_news_datetime;
                $news_title    = $html_sub_title;
                $news_contents = $news_contents;
                $news_source   = $news_source;

                //트랜잭션
                $_mysqli->begin_transaction();
                $_mysqli2->begin_transaction();

                // 동일한 뉴스 조회
                $news_check_query  = "
                    SELECT
                        game_type,
                        news_title,
                        news_contents
                    FROM
                        daily_news
                    WHERE 1 = 1
                      AND game_type     = '{$game_type}'
                      AND news_title    = '{$news_title}'
                      AND news_contents = '{$news_source}'
                ";
                $news_check_query_result = $_mysqli->query($news_check_query);
                $rows   = $news_check_query_result->num_rows;
                echo "\n";
                echo $rows;
                echo "\n";
                echo $news_check_query;
                echo "\n";

                if ($rows == 0) {

                    //Player id 조회
                    $player_check_query  = "
                        SELECT
                            player_id, 
                            full_name,
                            primary_position,
                            team_alias,
                            player_img
                        FROM
                            {$content_type}_team_profile_player
                        WHERE full_name = '{$player_name}'
                        ";
                    $player_check_query_result = $_mysqli2->query($player_check_query);
                    $player_check = $player_check_query_result->fetch_assoc();
                        $player_id  = $player_check['player_id'];
                        $full_name  = $player_check['full_name'];
                        $position   = $player_check['primary_position'];
                        $team_alias = $player_check['team_alias'];
                        $player_img = $player_check['player_img'];


                    if($player_check_query_result){                

                        //선수 이미지 다운로드 
                        $img_path = $playerimg_path.$player_img;
                        $player_file_name_down = "curl -X GET ".$widget_player_img." > ".$img_path;
                        $is_file_exist = file_exists($img_path); 
                            if($is_file_exist){
                            }else{
                                exec($player_file_name_down); //다운로드
                            }


                        //변수 정리
                        $player_id       = $player_id;
                        $player_name     = $full_name;
                        $player_position = $position;
                        $player_team     = $team_alias;
                        $player_img      = $sub_site_url.$news_player_link_replace;          
                                            
                            
                        $daily_news_Update_query  = "
                        INSERT INTO daily_news set
                            game_type        = '{$game_type}',
                            news_datetime    = '{$news_datetime}',
                            news_title       = '{$news_title}',
                            news_contents    = '{$news_contents}',
                            news_source      = '{$news_source}',
                            player_id        = '{$player_id}',
                            player_name      = '{$player_name}',
                            player_img       = '{$player_img}',
                            player_position  = '{$player_position}',
                            player_team      = '{$player_team}',
                            reg_updated      = now()
                        ";          
                        $daily_news_Update_query_result = $_mysqli->query($daily_news_Update_query);


                        echo "\n################################################################################################";
                        echo "\ngame_type       : ".$game_type;
                        echo "\nnews_title      : ".$news_title;
                        echo "\nnews_contents   : ".$news_contents;
                        echo "\nplayer_id       : ".$player_id;
                        echo "\nplayer_name     : ".$player_name;
                        echo "\nplayer_position : ".$player_position;
                        echo "\nplayer_team     : ".$player_team;
                        echo "\nplayer_img      : ".$player_img;
                        echo "\nreg_updated     : ".$reg_updated;
                        echo "\n################################################################################################";
                    }
            }
        }
    }               
}




    //커밋
    $_mysqli->commit();
    $_mysqli2->commit();


    $html_main->clear();
    unset($html_main);    
    $html_sub->clear();
    unset($html_sub);




} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        = "SQL ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} catch (Exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        .= "ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} finally {
    $log_txt        = "END";
    write_log($log_path, $log_txt, "a");
}