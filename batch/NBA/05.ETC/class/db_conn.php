<?php

// Account Start
    # LIVE
        #Web
        $web_host     = '127.0.0.1';
        $web_user     = 'web_db';
        $web_password = 'Wdfig^df75!&^!Q3e36W';
        $web_database = 'spobit_web';
        $web_port     = 3306;

        #Web_tmp
        $web_tmp_host     = '127.0.0.1';
        $web_tmp_user     = 'web_db';
        $web_tmp_password = 'Wdfig^df75!&^!Q3e36W';
        $web_tmp_database = 'spobit_web_tmp';
        $web_tmp_port     = 3306;

        #Games
        $games_host     = '127.0.0.1';
        $games_user     = 'games_db';
        $games_password = 'GDFe35^412#aFDhe5s_d%@!';
        $games_database = 'spobit_games';
        $games_port     = 3306;    

        #Games_tmp
        $games_tmp_host     = '127.0.0.1';
        $games_tmp_user     = 'games_db';
        $games_tmp_password = 'GDFe35^412#aFDhe5s_d%@!';
        $games_tmp_database = 'spobit_games_tmp';
        $games_tmp_port     = 3306;    

  
// Account END


// Connect START

    #Web
    $web_conn = mysqli_connect($web_host, $web_user, $web_password, $web_database, $web_port);
        mysqli_set_charset($web_conn, "utf8");
        if (!$web_conn) {
            echo 'spobit_web connect error'; 
        }

    #Web_tmp
    $web_tmp_conn = mysqli_connect($web_tmp_host, $web_tmp_user, $web_tmp_password, $web_tmp_database, $web_tmp_port);
        mysqli_set_charset($web_tmp_conn, "utf8");
        if (!$web_tmp_conn) {
            echo 'spobit_web_tmp connect error'; 
        }

    #Games
    $games_conn = mysqli_connect($games_host, $games_user, $games_password, $games_database, $games_port);
        mysqli_set_charset($games_conn, "utf8");
        if (!$games_conn) {
            echo 'spobit_games connect error'; 
        }

    #Games_tmp
    $games_tmp_conn = mysqli_connect($games_tmp_host, $games_tmp_user, $games_tmp_password, $games_tmp_database, $games_tmp_port);
        mysqli_set_charset($games_tmp_conn, "utf8");
        if (!$games_tmp_conn) {
            echo 'spobit_games_tmp connect error'; 
        }

// Connect END

?>
