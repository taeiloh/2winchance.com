<?php
function p($arr) {
    if (ISOFFICE) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}

function alert($msg) {
    echo <<<SCRIPT
        <script>
            alert("{$msg}");
        </script>
SCRIPT;
    exit;
}

function alertBack($msg) {
    echo <<<SCRIPT
        <script>
            alert("{$msg}");
            history.back();
        </script>
SCRIPT;
    exit;
}

function alertReplace($msg, $url) {
    echo <<<SCRIPT
        <script>
            alert("{$msg}");
            location.replace("{$url}");
        </script>
SCRIPT;
    exit;
}

function locationReplace($url) {
    echo <<<SCRIPT
        <script type="text/javascript">
            location.replace("{$url}");
        </script>
SCRIPT;
    exit;
}

// 리퍼러 체크
function check_referer($url='') {
    if (strpos($_SERVER['HTTP_REFERER'], $url) === FALSE) {
        $msg    = '잘못된 접근입니다.';
        $url    = '/main/';
        alertReplace($msg, $url);
        exit;
    }
}