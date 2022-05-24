<?php
//config
$config                 = array();

//로컬 개발 IP
$config['ip']['dev']    = array(
    '127.0.0.1',
    '::1'
);

//테스트 장비 IP
$config['ip']['test']   = array(
    '172.31.1.138',
);

//실 장비 IP
$config['ip']['real']   = array(
    '',
);

//사무실 IP
$config['ip']['office'] = array(
    '218.49.254.228'
);

//ip check
$config['isDev']        = in_array( $_SERVER['SERVER_ADDR'], $config['ip']['dev'] );
$config['isTest']       = in_array( $_SERVER['SERVER_ADDR'], $config['ip']['test'] );
$config['isReal']       = in_array( $_SERVER['SERVER_ADDR'], $config['ip']['real'] );
$config['isOffice']     = in_array( $_SERVER['REMOTE_ADDR'], $config['ip']['office'] );

//database
if ( $config['isDev'] ) {
    define('DBHOST',        'localhost');
    define('DBUSERNAME',    'root');
    define('DBPASSWD',      '');
    define('DBNAME',        'db2winchance_web');
    define('WWW',           '//www.2winchance.com');
    define('UPLOAD',        '/uploads');
};
/*
if ( $config['isDev'] ) {
    define('DBHOST',        'localhost');
    define('DBUSERNAME',    '2winchance');
    define('DBPASSWD',      '2winchance!2022@');
    define('DBNAME',        'db2winchance_web');
    define('WWW',           '//www.2winchance.com');
    define('UPLOAD',        '/uploads');
};
*/
if ( $config['isTest'] ) {
    define('DBHOST',        'localhost');
    // define('DBUSERNAME',    '2winchance');
    // define('DBPASSWD',      '2winchance!2022@');
    // define('DBNAME',        'db2winchance_web');
    define('DBUSERNAME',    'web_db');
    define('DBPASSWD',      'Wdfig^df75!&^!Q3e36W');
    define('DBNAME',        'spobit_web');
    define('WWW',           '//www.2winchance.com');
    define('UPLOAD',        '/uploads');
}
if ( $config['isReal'] ) {
    define('DBHOST',        'localhost');
    define('DBUSERNAME',    '2winchance');
    define('DBPASSWD',      '2winchance!2022@');
    define('DBNAME',        'db2winchance_web');
    define('WWW',           '//www.2winchance.com');
    define('UPLOAD',        '/uploads');
}

//사무실
if ( $config['isOffice'] ) {
    define('ISOFFICE',  TRUE);
} else {
    define('ISOFFICE',  FALSE);
}

//캐시
define('CSSYYYYMMDD',   time());
define('JSYYYYMMDD',    time());
define('IP',                $_SERVER['REMOTE_ADDR']);

//페이징
const PAGING_SIZE   = 10;
const PAGING_SCALE  = 10;

//세션 정리
$_se_seq            = !empty($_SESSION['SE_SEQ'])            ? $_SESSION['SE_SEQ']          : 0;
$_se_idx            = !empty($_SESSION['_se_idx'])           ? $_SESSION['_se_idx']         : 0;
$_se_id             = !empty($_SESSION['SE_ID'])             ? $_SESSION['SE_ID']           : '';
$_se_nm             = !empty($_SESSION['SE_NM'])             ? $_SESSION['SE_NM']           : '';

define('SE_SEQ',            $_se_seq);
define('SE_ID',             $_se_id);
define('SE_NM',             $_se_nm);

//로그인 여부
if ($_se_seq) {
    define('ISLOGIN',       TRUE);
} else {
    define('ISLOGIN',       FALSE);
}

//DB include
require_once __DIR__ .'/../_inc/dbconnect.php';
