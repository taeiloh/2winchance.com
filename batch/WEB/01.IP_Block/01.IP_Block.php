<?php
/**
 * Created by Sublime Text.
 * User: AlexKim
 * Date: 2019-04-24
 * Time: 오후 12:11
 */

//config
require __DIR__ .'/../../inc/config.php';


try {
    //변수 정리
	$ymd                = date('Ymd');

	//Log 생성
    $log_folder     = __DIR__ . '/log';
    $log_filename   = "{$ymd}_01.IP_Block.log";
    $log_path       = $log_folder . '/' . $log_filename;
    $log_txt        = "Start_IP_Block";
    write_log($log_path, $log_txt, "a");


    #IP XML 다운로드
    $api_url        = "https://xn--3e0bx5euxnjje69i70af08bea817g.xn--3e0b707e/jsp/statboard/IPAS/inter/sec/interProCurrentXml.jsp";
    $save_folder    = __DIR__ .'/xml';
    $save_filename  =  "kor_use_ip.xml";
    $save_file      = $save_folder."/".$save_filename;
    $xml_file_down = "curl -k -X GET ".$api_url." > ".$save_file;
    exec($xml_file_down);


    //IP XML File 불러오기
	$xml_file = $save_file;
	$xml = file_get_contents($xml_file, true);
	$arrIP = simplexml_load_string($xml);
    
    $i      = 0;
    $cnt    = count($arrIP);

    //트랜잭션    
    $_mysqli->begin_transaction();
        

    //테이블 초기화(기존 내용 삭제)
    $query = "truncate rok_ip";
    $result = $_mysqli->query($query);


    foreach ($arrIP as $val) {
    	$i++;
        progressBar($i, $cnt);
		
        //변수정리
		$saddr = ip2long($val->sno);
		$eaddr = ip2long($val->eno);
		$sip   = $val->sno;
		$eip   = $val->eno;


        $query = "
             INSERT INTO rok_ip SET
                 saddr = '{$saddr}',
                 eaddr = '{$eaddr}',
                 sip   = '{$sip}',
                 eip   = '{$eip}'
         ";
         //print_r($query);
         $result = $_mysqli->query($query);
         
         if ($result) {
             $affected_rows  = $_mysqli->affected_rows;
             if ($affected_rows > 0) {
                 $log_txt = "SUCCESS - [$i] INSERT INTO [{$affected_rows} rows affected] [IP = {$sip} - {$eip}]";
                 write_log($log_path, $log_txt, "a");
             }
         }
    }


    //커밋
    $_mysqli->commit();

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        = "SQL ERROR: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} catch (Exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        = "ERROR";
    write_log($log_path, $log_txt, "a");
    $log_txt        .= "MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} finally {
    $log_txt        = "END";
    write_log($log_path, $log_txt, "a");
}

