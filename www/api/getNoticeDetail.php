<?php
/**
 * 20220625 진경수 (관리자 연동 api)
 * 20220628 CORS 허용 (todo-gsjin 오픈 시 주석 필요)
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Headers: x-requested-with');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 전역 변수
    $arrRtn         = array(
        'msg'   => '',
        'code'  => 500,
        'data'  => array(
            'page'          => 1,
            'searchKey'     => '',
            'searchVal'     => '',
            'detail'          => array()
        )
    );

    // 파라미터 정리
    $seq            = !empty($_GET['seq'])          ? $_GET['seq']          : 0;
    $page           = !empty($_GET['page'])         ? $_GET['page']         : 1;
    $searchKey      = !empty($_GET['searchKey'])    ? $_GET['searchKey']    : '';
    $searchVal      = !empty($_GET['searchVal'])    ? $_GET['searchVal']    : '';

    // 파라미터 체크
    if (!is_numeric($page)) $page = 1;

    // 변수 정리
    $where          = '';

    // 검색

    // 조회수 업데이트
    $query  = "
        UPDATE NOTICE SET
            READ_CNT = READ_CNT + 1
        WHERE 1=1
            AND SEQ = {$seq}
        LIMIT 1
    ";
    $result = $_mysqli->query($query);
    if (!$result) {
        $msg    = '조회수 업데이트 실패';
        $code   = 501;
        throw new Exception($msg, $code);
    }

    // 상세 정보
    $query  = "
        SELECT
            SEQ, TITLE, CONTENT, READ_CNT, SHOW_YN,
            CREATED_BY, CREATED_AT
        FROM NOTICE
        WHERE 1=1
            AND DEL_YN = 'N'
            AND SEQ = {$seq}
        LIMIT 1
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        $msg    = '상세 내용 조회 실패';
        $code   = 502;
        throw new Exception($msg, $code);
    }
    $db = $result->fetch_assoc();
    $arrRtn['data']['detail']   = $db;

    // rtn 값
    $arrRtn['data']['searchKey']    = $searchKey;
    $arrRtn['data']['searchVal']    = $searchVal;
    $arrRtn['code'] = 200;

    $result->free();

} catch (Exception $e) {
    $arrRtn['msg']  = $e->getMessage();
    $arrRtn['code'] = $e->getCode();

} finally {
    echo json_encode($arrRtn);
}
