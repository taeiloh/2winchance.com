<?php
/*
$file_server_path = realpath(__FILE__);
// PHP 파일 이름이 들어간 절대 서버 경로

$php_filename = basename(__FILE__);
// PHP 파일 이름

$server_path = str_replace(basename(__FILE__), "", $file_server_path);
// PHP 파일 이름을 뺀 절대 서버 경로

$server_root_path = $_SERVER['DOCUMENT_ROOT'];
// 서버의 웹 뿌리(루트) 경로(절대 경로)

$relative_path = eregi_replace("\/[^/]*\.php$", "/", $_SERVER['PHP_SELF']);
$relative_path = preg_replace("`\/[^/]*\.php$`i", "/", $_SERVER['PHP_SELF']);
// 웹 문서의 뿌리 경로를 뺀 상대 경로

$relative_file_server_path = $relative_path.$php_filename;
// PHP 파일 이름이 들어간 상대 경로
*/



date_default_timezone_set('GMT');

//서버 IP 체크
$server_ip = exec("hostname -I");

//Today_date
$today_yesr = date("Y");
$today_month = date("m");
$today_day = date("d");
$today_time = date("h:i:s");
$today_date = date("Y-m-d H:i");
$today_ymd = date("Y-m-d");
//날짜 형식변환[START] -1(yesterday) / 0(today) / 1(tomorrow)
if (isset($argv[1])){
	$start_date['Y/m/d'] = date("Y/m/d",strtotime($argv[1]." day"));
	$start_date['Y-m-d'] = date("Y-m-d",strtotime($argv[1]." day"));
	$start_date['Y/m']   = date("Y/m",strtotime($argv[1]." day"));
	$start_date['Y']     = date("Y",strtotime($argv[1]." day"));
	$start_date['m']     = date("m",strtotime($argv[1]." day"));
	$start_date['d']     = date("m",strtotime($argv[1]." day"));
}
//날짜 형식변환[END] -1(yesterday) / 0(today) / 1(tomorrow)
if (isset($argv[2])){
	$end_date['Y/m/d']   = date("Y/m/d",strtotime($argv[2]." day"));
	$end_date['Y-m-d']   = date("Y-m-d",strtotime($argv[2]." day"));
	$end_date['Y/m']     = date("Y/m",strtotime($argv[2]." day"));
	$end_date['Y']       = date("Y",strtotime($argv[2]." day"));
	$end_date['m']       = date("m",strtotime($argv[2]." day"));
	$end_date['d']       = date("m",strtotime($argv[2]." day"));
}

$count_num = 1;


function cron_log($title, $txt) {
    $today          = date('Ymd');
    $log_dir        = $_SERVER['DOCUMENT_ROOT'];
    //폴더 생성
    @mkdir($log_dir . 'log', 0777);
    $log_filename   = $title.'_'.date('Ymd') .'.log';
    $log_txt        = date('[Y-m-d H:i:s] '). $txt;
    $log_file       = fopen($log_dir . 'log/'. $log_filename, 'a');
    fwrite($log_file, "{$log_txt}\r\n");
    fclose($log_file);

}

require_once 'api_key.php';
require_once 'db_conn.php';
require_once 'contests_rules.php';
require_once 'simple_html_dom.php';
?>
