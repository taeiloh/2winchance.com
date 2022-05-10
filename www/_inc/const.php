<?php
//캐시
define('CSSYYYYMMDD', time());
define('JSYYYYMMDD', time());
define('G_UNIXTIME', time());
define('IP',$_SERVER['REMOTE_ADDR']);
define('G_MD',md5(G_UNIXTIME.' '. 'http://' . $_SERVER["HTTP_HOST"]));

//페이징
//const PAGING_SIZE   = 15;
//const PAGING_SCALE  = 5;