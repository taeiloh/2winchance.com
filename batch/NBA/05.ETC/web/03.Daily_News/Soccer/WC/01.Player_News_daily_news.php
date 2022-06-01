<?php
//선수관련 뉴스 파싱하여 DB에 업데이트 (메인뉴스에 있는 타이틀 링크를 통해 서브 뉴스 파싱)
//require_once '../../class/config.php';
require_once '/data/www.spo-bit.com/batch/NBA/05.ETC/class/config.php';


$game_type_value = 'EPL';  // NBA , MLB, LOL
$sub_site_url = 'https://www.fifa.com';  // 사이트 주소

$url = 'https://www.fifa.com/worldcup/news/'; // 메인뉴스 타이틀 링크검색
$html_main = file_get_html($url, true);

//메인 뉴스 검색 파싱
foreach($html_main->find("div.col-xs-12") as $news_main_widget_list){

    foreach($news_main_widget_list->find('div.d3-o-media-object') as $news_main_title){

        $news_date      = str_replace("'","\'",trim($news_main_title->find('p.d3-o-media-object__date',0)->plaintext)); 
        $news_title     = str_replace("'","\'",trim($news_main_title->find('h3.d3-o-media-object__title',0)->plaintext)); 
        $news_title_img = $news_main_title->find('img', 0)->getAttribute('data-src');
        $news_links     = $news_main_title->find('a',0)->href;        

                $np_qry_chk  = " SELECT * FROM daily_news ";
                $np_qry_chk .= "WHERE game_type     = '{$game_type_value}' ";
                $np_qry_chk .= "AND   player_img    = '{$news_title_img}' ";
                $np_qry_chk .= "AND   news_contents = '{$news_links}' ";
                $qry_chk_result = mysqli_query($web_conn,$np_qry_chk);

                if (mysqli_num_rows($qry_chk_result) > 0){
                    $np_up_qry  = "UPDATE daily_news set ";
                    $np_up_qry .= " news_datetime    = '{$news_date}', ";
                    $np_up_qry .= " news_title       = '{$news_title}', ";
                    $np_up_qry .= " news_contents    = '{$news_links}', ";
                    $np_up_qry .= " reg_updated      = now() ";
                    $np_up_qry .= "WHERE game_type     = '{$game_type_value}' ";
                    $np_up_qry .= "AND   player_img    = '{$news_title_img}' ";
                    $np_up_qry .= "AND   news_contents = '{$news_links}' ";
                    $np_up_qry_result = mysqli_query($web_conn,$np_up_qry);
                }else{
                    $np_up_qry  = "INSERT INTO daily_news set ";
                    $np_up_qry .= " game_type        = '{$game_type_value}', ";
                    $np_up_qry .= " news_datetime    = '{$news_date}', ";
                    $np_up_qry .= " news_title       = '{$news_title}', ";
                    $np_up_qry .= " news_contents    = '{$news_links}', ";
                    $np_up_qry .= " player_img       = '{$news_title_img}', ";
                    $np_up_qry .= " reg_updated      = now(); ";
                    $np_up_qry_result = mysqli_query($web_conn,$np_up_qry);

                    /*
                    if (!$np_up_qry_result){
                        echo "  Error\n";
                        echo $np_up_qry . "\n\n";
                        echo mysqli_error($web_conn);
                        //return false;
                    }
                    */
                }
                //DB Upload 되는 파일 출력하기
                echo "################################################################################################";
                echo "\n";
                echo "today_date        : ".$today_date;
                echo "\n";                              
                echo " game_type        : ".$game_type_value;
                echo "\n";
                echo " news_datetime    : ".$news_date;
                echo "\n";
                echo " news_title       : ".$news_title;
                echo "\n";
                echo " news_contents    : ".$news_links;
                echo "\n";
                echo " player_img       : ".$news_title_img;
                echo "\n";
                echo "batch_file        : ".realpath(__file__);
                echo "\n";
                echo "################################################################################################";
                echo "\n"; 

    }

}    


$html_main->clear();
unset($html_main);
mysqli_close($web_conn);
?>
