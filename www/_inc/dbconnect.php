<?php
$_mysqli = @new mysqli(DBHOST, DBUSERNAME, DBPASSWD, DBNAME);

if ($_mysqli->connect_errno) {
    die('Connect Error : '. $_mysqli->connect_errno);
}

$_mysqli->set_charset('utf8');

// 추가
//$_mysqli_game = @new mysqli(DBHOST, 'games_db', 'GDFe35^412#aFDhe5s_d%@!', 'spobit_games');

//if ($_mysqli_game->connect_errno) {
//    die('Connect Error : '. $_mysqli_game->connect_errno);
//}

//$_mysqli_game->set_charset('utf8');