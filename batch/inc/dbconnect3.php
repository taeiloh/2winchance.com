<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-12-18
 * Time: 오전 3:22
 */

$_mysqli3 = @new mysqli(DBHOST3, DBUSERNAME3, DBPASSWD3, DBNAME3);

if ($_mysqli3->connect_errno) {
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $_mysqli3->connect_errno . "\n";
    echo "Error: " . $_mysqli3->connect_error . "\n";
    exit;
}

$_mysqli3->set_charset('utf8');
