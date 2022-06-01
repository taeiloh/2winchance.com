<?php
/**
 * Created by Sublime Text.
 * User: AlexKim
 * Date: 2019-04-25
 * Time: 오후 13:56
 */

//config
require __DIR__ .'/../../inc/config.php';


    #환경설정
    $coin_type = $argv[1];
    //테스트
    //$coin_type = "bitcoin";  // "bitcoin" or "dsn"


try {
    $ymd            = date('Ymd');
    $today          = date('Y-m-d H:i:s');

    //로그
    $log_folder     = __DIR__ .'/log';
    if (!is_dir($log_folder)){ mkdir($log_folder); }  #폴더 없을경우 생성
    $log_filename   = "{$ymd}_{$coin_type}_current_prices.log";
    $log_path       = $log_folder .'/'. $log_filename;
    $log_txt        = " ";
    write_log($log_path, $log_txt, "a");
    $log_txt        = "=======================";
    write_log($log_path, $log_txt, "a");
    $log_txt        = "START";
    write_log($log_path, $log_txt, "a");




    if($coin_type == 'bitcoin'){
        #Json URL
        $api_url  = 'https://api.coindesk.com/v1/bpi/currentprice.json';
        
        #Json Decode
        $json     = file_get_contents($api_url);
        $json_ary = json_decode($json, true);

        #변수 정리
        $CoinType         = $json_ary['time']['chartName'];
        $CoinPrice        = $json_ary['bpi']['USD']['rate_float'];
        $CoinPrice_Source = $CoinPrice;
        $UpDateTime       = date('Y-m-d H:i:s', strtotime($json_ary['time']['updatedISO']));
        $Bpi_code         = 'USD';

    }else if ($coin_type == 'dsn'){

        #BitCoin 시세 불러와 환율 계산하기
            $api_url['BitCoin']  = 'https://api.coindesk.com/v1/bpi/currentprice.json';
            $json['BitCoin']     = file_get_contents($api_url['BitCoin']);
            $json_ary['BitCoin'] = json_decode($json['BitCoin'], true);
                $CoinPrice['BitCoin'] = $json_ary['BitCoin']['bpi']['USD']['rate_float'];

        #DSN 시세 불러오기 
            #Json URL
            $api_url  = 'https://user-api.hanbitco.com/v1/markets/dsn_btc/ticker';        

            #Json Decode
            $json     = file_get_contents($api_url);
            $json_ary = json_decode($json, true);        
            
            #변수 정리
            $CoinType         = $json_ary['data']['currencyPair'];
            $CoinPrice_Source = $json_ary['data']['lastPrice'];
            $CoinPrice        = $CoinPrice_Source*$CoinPrice['BitCoin'];

            $UpDateTime       = date("Y-m-d h:i:s", $json_ary['data']['timestamp']);
            $Bpi_code         = 'DSN';
    
    }else {
    }


    #CoinPrice 값이 정상적일 경우에만 실행
    if ($CoinPrice !== 0 || $CoinPrice !== ''){

        //트랜잭션
        $_mysqli->begin_transaction();

        #Coin Price 업데이트
        $sub_query  = "
            UPDATE
                bitcoin_price
            SET
                price       = '{$CoinPrice}',
                last_update = '{$UpDateTime}'
            WHERE 
                price <> '{$CoinPrice}'
        ";
        //p($sub_query);
        $sub_result = $_mysqli->query($sub_query);
        if ($sub_result) {
            $sub_rows = $_mysqli->affected_rows;
            if ($sub_rows > 0) {
                //업데이트 되었음
                $log_txt = "UPDATE bitcoin_price: rate = {$CoinPrice}";
                write_log($log_path, $log_txt, "a");
            }
        }



        #Coin Price History 남기기
        $sub_query  = "
            INSERT INTO bitcoin_price_history SET
                cointype    = '{$CoinType}',
                bpi_code    = '{$Bpi_code}',
                rate        = '{$CoinPrice}',
                rate_source = '{$CoinPrice_Source}',
                updated     = '{$UpDateTime}'
        ";
        //p($sub_query);
        $sub_result = $_mysqli->query($sub_query);
        if ($sub_result) {
            $sub_rows = $_mysqli->affected_rows;
            if ($sub_rows > 0) {
                //업데이트 되었음
                $log_txt = "INSERT INTO bitcoin_price_history: rate = {$CoinPrice}";
                write_log($log_path, $log_txt, "a");
            }
        }



        //커밋
        $_mysqli->commit();
    }

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        = "SQL ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} catch (Exception $e) {
    $_mysqli->rollback();  //롤백
    $log_txt        .= "ERROR - MSG: {$e->getMessage()}";
    write_log($log_path, $log_txt, "a");

} finally {
    $log_txt        = "END";
    write_log($log_path, $log_txt, "a");
}