<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-12-17
 * Time: 오후 2:23
 */

$_mysqli2 = @new mysqli(DBHOST2, DBUSERNAME2, DBPASSWD2, DBNAME2);

if ($_mysqli2->connect_errno) {
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $_mysqli2->connect_errno . "\n";
    echo "Error: " . $_mysqli2->connect_error . "\n";
    exit;
}

$_mysqli2->set_charset('utf8');
