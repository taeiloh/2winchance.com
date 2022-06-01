<?php
/**
 * Created by PhpStorm.
 * User: gsjin
 * Date: 2018-12-17
 * Time: 오후 2:27
 */

function p($msg) {
    echo '<pre>';
    print_r($msg);
    echo '</pre>';
}

function write_log($fp_path, $txt, $fp_mode="w") {
    //변수 정리
    $his    = date('H:i:s');
    $fp_txt = "{$his} ===> {$txt}\r\n";

    $fp     = fopen($fp_path, $fp_mode);
    fwrite($fp, $fp_txt);
    fclose($fp);
}

function progressBar($done, $total) {
    $perc = floor(($done / $total) * 100);
    $left = 100 - $perc;
    $write = sprintf("\033[0G\033[2K[%'={$perc}s>%-{$left}s] - $perc%% - $done/$total", "", "");
    fwrite(STDERR, $write);
}

// 만능 4칙연산
function digitMath($value1, $value2, $type = 'plus') {
    if (is_numeric($value1) && is_numeric($value2)) {
        $num1 = $value1 * 100000000;
        $num2 = $value2 * 100000000;

        $digits = 8;

        $base = pow(10, $digits);

        $num1 = round($num1 * $base) / $base;
        $num2 = round($num2 * $base) / $base;

        $result1 = floor($num1);
        $result2 = floor($num2);

        switch ($type) {
            case 'plus' :
                $result = $result1 + $result2;
                break;

            case 'minus' :
                $result = $result1 - $result2;
                break;

            case 'multiply' :
                $result = $result1 * $result2;
                break;

            case 'divide' :
                $result = $result1 / $result2;
                break;

            default :
                $result = $result1 + $result2;
                $str = ' + ';
        }

        $result = $result / 100000000;
    } else {
        $result = null;
    }

    return $result;
}