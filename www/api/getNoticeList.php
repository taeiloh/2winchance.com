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
            'total_page'    => 0,
            'total_cnt'     => 0,
            'searchKey'     => '',
            'searchVal'     => '',
            'list'          => array()
        )
    );

    // 파라미터 정리
    $page           = !empty($_GET['page'])         ? $_GET['page']         : 1;
    $searchKey      = !empty($_GET['searchKey'])    ? $_GET['searchKey']    : '';
    $searchVal      = !empty($_GET['searchVal'])    ? $_GET['searchVal']    : '';
    $size           = !empty($_GET['size'])         ? $_GET['size']         : PAGING_SIZE;
    $scale          = !empty($_GET['scale'])        ? $_GET['scale']        : PAGING_SCALE;

    // 파라미터 체크
    if (!is_numeric($page)) $page = 1;
    if (!is_numeric($size)) $size = PAGING_SIZE;
    if (!is_numeric($scale)) $scale = PAGING_SCALE;

    // 변수 정리
    $offset         = ($page - 1) * $size;
    $where          = '';

    // 검색
    if (!empty($searchKey) && !empty($searchVal)) {
        if ($searchKey == 'TITLE' || $searchKey == 'CONTENT') {
            $where      .= "AND {$searchKey} LIKE '%{$searchVal}%' ";
        }
    }

    // db
    $query  = "
        SELECT
            SQL_CALC_FOUND_ROWS
            SEQ, TITLE, CONTENT, READ_CNT, SHOW_YN, 
            CREATED_BY, CREATED_AT, CREATED_IP
        FROM NOTICE
        WHERE 1=1
            AND DEL_YN = 'N'
            {$where}
        ORDER BY SEQ DESC
        LIMIT {$offset}, {$size}
    ";
    //p($query);
    $result = $_mysqli->query($query);
    if (!$result) {
        $msg    = '조회 실패';
        $code   = 501;
        throw new Exception($msg, $code);
    }
    while($db = $result->fetch_assoc()) {
        $arrRtn['data']['list'][]   = $db;
    }

    // 기타 정보
    $query  = "SELECT FOUND_ROWS() AS TOTAL";
    $result = $_mysqli->query($query);
    if (!$result) {
        $msg    = '조회 실패';
        $code   = 502;
        throw new Exception($msg, $code);
    }
    $db     = $result->fetch_assoc();
    $total  = !empty($db['TOTAL'])      ? $db['TOTAL']      : 0;

    // rtn 값
    $arrRtn['data']['total_page']   = ceil($total / $size);
    $arrRtn['data']['total_cnt']    = (int) $total;
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
