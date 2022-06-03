<?php
//config
require_once __DIR__ . '/../_inc/config.php';

$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);
try {
    //파라미터 정리
    //p($_POST['carArr']);
    $m_sns_type       = !empty($_POST['m_sns_type'])           ? $_POST['m_sns_type']         : '';
    $m_sns_id     = !empty($_POST['m_sns_id'])         ? $_POST['m_sns_id']                   : "";

    //세션
    $mem_seq     = SE_SEQ;
    $mem_name    = SE_NM;

    //변수 정리
    $ip         = IP;

    //
    $query  = "
        SELECT
            COUNT(1) AS CNT
        FROM members
        WHERE 1 
            AND m_sns_type = '{$m_sns_type}'
            AND m_sns_id  = '{$m_sns_id}'
            AND m_name is NOT NULL
    ";
    //echo $query;
    //exit;
    $result = $_mysqli->query($query);
    if (!$result) {
        $arrRtn['code'] = 501;
        $arrRtn['msg']  = "error 1";
        echo $query;
    }
    $db     = $result->fetch_assoc();
    $cnt    = $db['CNT'];

    //아이디가 1개인 경우 로그인 처리
    if ($cnt == 1) {
        //회원 정보 확인
        $query =  "
            SELECT
                *
            FROM members
            WHERE 1 
                AND m_sns_type = '{$m_sns_type}'
                AND m_sns_id = '{$m_sns_id}'
                AND m_name is not null 
        ";
        $result = $_mysqli->query($query);

        if (!$result) {
            $arrRtn['code'] = 502;
            $arrRtn['msg']  = "조회 오류가 발생했습니다.\n관리자에게 문의해 주세요.";
            p($query);
            echo json_encode($arrRtn);
            exit;
        }
        else{
            $query2 = "SELECT set_time from members where m_sns_id='{$m_sns_id}'";
            $result2 = $_mysqli->query($query2);
            $mdb = $result2->fetch_array();
            $set_time = $mdb['set_time'];

            $today = date('Y-m-d h:i:s.n', time());
            if($set_time <= $today) {
                $db = $result->fetch_assoc();
                $db_seq = !empty($db['m_idx']) ? $db['m_idx'] : 0;
                $db_name = !empty($db['m_name']) ? $db['m_name'] : '';
                $db_deposit = !empty($db['m_deposit']) ? $db['m_deposit'] : '';

                //세션
                //세션 생성
                $_SESSION['_se_idx'] = $db_seq;
                $_SESSION['_se_name'] = $db_name;
                $_SESSION['_se_deposit'] = $db_deposit;

                $arrRtn['code'] = 200;
            }
            else{
                $arrRtn['code'] = 205;
                $arrRtn['msg'] = "본인 요청으로 게임입장 제한기간 설정에 따라 로그인이 제한 되었습니다. 설정기간 후 로그인이 가능합니다";
                echo json_encode($arrRtn);
                exit;
            }
        }
    }
    else{
        $query2  = "
            SELECT
                count(*)
            FROM members
            WHERE 1 
                AND m_sns_type = '{$m_sns_type}'
                AND m_sns_id = '{$m_sns_id}'
                AND m_name is null 
        ";
       /* echo $query2;
        exit;*/
        $result2 = $_mysqli->query($query2);
        $row1 = mysqli_fetch_row($result2);
        $total_count = $row1[0];

        if($total_count > 0)
        {
            $arrRtn['code'] = 201;
            $arrRtn['msg'] = "가입 진행중인 계정이 있습니다. 가입을 마저 진행해주세요.";
            echo json_encode($arrRtn);
            exit;
        }
    }

    //성공

    //$arrRtn['cnt']  = (int) $cnt;
    //$arrRtn['msg']  = "아이디 중복 확인";

} catch (mysqli_sql_exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} catch (Exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();

} finally {
    echo json_encode($arrRtn);
}