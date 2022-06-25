<?php
/**
 * 20220625 진경수 (공지사항 등록 및 수정)
 */
//config
require_once __DIR__ .'/../_inc/config.php';

try {
    // 전역 변수
    $arrRtn         = array(
        'msg'   => '',
        'code'  => 500,
        'data'  => array(
        )
    );

    // 파라미터 정리
    $mode       = !empty($_POST['mode'])        ? $_POST['mode']        : 'c'; // cud
    $seq        = !empty($_POST['seq'])         ? $_POST['seq']         : 0;
    $title      = !empty($_POST['title'])       ? $_POST['title']       : '';
    $content    = !empty($_POST['content'])     ? $_POST['content']     : '';
    $show_yn    = !empty($_POST['show_yn'])     ? $_POST['show_yn']     : 'Y';
    $reg_nm     = !empty($_POST['reg_nm'])      ? $_POST['reg_nm']      : '';

    // 파라미터 체크
    if (empty($title) || empty($content) || empty($reg_nm)) {
        $msg    = '필수 입력 항목을 입력해 주세요.';
        $code   = 501;
        throw new Exception($msg, $code);
    }
    if (!is_numeric($seq)) {
        $seq    = 0;
    }

    // 트랜잭션
    $_mysqli->begin_transaction();

    // 변수 정리
    $ip         = IP;
    $title      = $_mysqli->real_escape_string($title);
    $content    = $_mysqli->real_escape_string($content);
    $reg_nm     = $_mysqli->real_escape_string($reg_nm);

    // 등록
    if ($mode == 'c') {
        $msg    = '등록';
        $code   = 502;
        $query  = "
            INSERT INTO NOTICE
                (TITLE, CONTENT, SHOW_YN, 
                 CREATED_BY, CREATED_IP)
            VALUES
                ('{$title}', '{$content}', '{$show_yn}',
                 '{$reg_nm}', '{$ip}')
        ";

    } else if ($mode == 'u') {
        $msg    = '수정';
        $code   = 503;
        $query  = "
            UPDATE NOTICE SET
                TITLE = '{$title}',
                CONTENT = '{$content}',
                SHOW_YN = '{$show_yn}',
                UPDATED_BY = '{$reg_nm}',
                UPDATED_IP = '{$ip}'
            WHERE 1=1
                AND SEQ = {$seq}
            LIMIT 1
        ";

    } else if ($mode == 'd') {
        $msg    = '삭제';
        $code   = 504;
        $query  = "
            UPDATE NOTICE SET
                DEL_YN = 'Y',
                UPDATED_BY = '{$reg_nm}',
                UPDATED_IP = '{$ip}'
            WHERE 1=1
                AND SEQ = {$seq}
            LIMIT 1
        ";
    }
    $result = $_mysqli->query($query);
    if (!$result) {
        $msg    = $msg ." 중 오류가 발생했습니다.\r\n관리자에게 문의해 주세요.";
        throw new Exception($msg, $code);
    }

    // 완료
    $_mysqli->commit();
    $arrRtn['msg']  = $msg .'되었습니다.';
    $arrRtn['code'] = 200;

} catch (Exception $e) {
    $_mysqli->rollback();
    $arrRtn['msg']  = $e->getMessage();
    $arrRtn['code'] = $e->getCode();

} finally {
    echo json_encode($arrRtn);
}
