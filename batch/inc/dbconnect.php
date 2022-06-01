<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-12-17
 * Time: 오후 2:09
 */

$_mysqli = @new mysqli(DBHOST, DBUSERNAME, DBPASSWD, DBNAME);

if ($_mysqli->connect_errno) {
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $_mysqli->connect_errno . "\n";
    echo "Error: " . $_mysqli->connect_error . "\n";
    exit;
}

$_mysqli->set_charset('utf8');
