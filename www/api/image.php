<?php
/**
 * 20220701 진경수 (이미지 업로드 모듈)
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Headers: x-requested-with');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//config
require_once __DIR__ .'/../_inc/config.php';

// 변수 정리
//p($_FILES);
$arrRtn = array(
    'msg'       => '',
    'code'      => 500,
    'filename'  => '',
    'uploaded'  => 0,
    'fileUrl'   => ''
);

try {
    if (!isset($_FILES['image']['error']) || is_array($_FILES['image']['error'])) {
        $msg    = '이미지 등록 중 오류가 발생했습니다.';
        $code   = 501;
        throw new Exception($msg, $code);
    }

    switch ($_FILES['image']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            //throw new RuntimeException('No file sent.');
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $msg    = '이미지 용량은 8MB까지 가능합니다.';
            $code   = 502;
            throw new Exception($msg, $code);
        default:
            $msg    = '이미지 등록 중 오류가 발생했습니다.';
            $code   = 503;
            throw new Exception($msg, $code);
    }

    if (empty($_FILES['image']['error'])) {
        // You should also check filesize here.
        if ($_FILES['image']['size'] > 20 * 1024 * 1024) {
            $msg    = '이미지 용량은 20MB까지만 가능합니다.';
            $code   = 504;
            throw new Exception($msg, $code);
        }

        // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($_FILES['image']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif'
                ),
                true
            )) {
            $msg    = '이미지는 jpg, jpeg, png, gif 파일만 가능합니다.';
            $code   = 505;
            throw new Exception($msg, $code);
        }

        // You should name it uniquely.
        // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        $yyyymmdd           = date('Ymd');
        $hhiiss             = date('his');
        $rand               = rand(1, 9999);
        $upload_filename    = "{$yyyymmdd}_{$hhiiss}_{$rand}";
        $filename           = "{$upload_filename}.{$ext}";
        $path               = __DIR__ .'/../upload/'. $yyyymmdd;
        $full_filename      = SSLWWW ."/upload/{$yyyymmdd}/{$filename}";

        //폴더 생성
        if (!is_dir($path)) {
            mkdir($path, 0700, true);
        }

        if (!move_uploaded_file(
            $_FILES['image']['tmp_name'],
            sprintf($path .'/%s.%s',
                $upload_filename,
                $ext
            )
        )) {
            $msg    = '이미지 등록 중 오류가 발생했습니다.';
            $code   = 506;
            throw new Exception($msg, $code);
        }
    }

    $arrRtn['code']     = 200;
    $arrRtn['filename'] = $_FILES['image']['name'];
    $arrRtn['uploaded'] = 1;
    $arrRtn['fileUrl']  = $full_filename;

} catch (Exception $e) {
    $arrRtn['msg']  = $e->getMessage();
    $arrRtn['code'] = $e->getCode();

} finally {
    echo json_encode($arrRtn);
}