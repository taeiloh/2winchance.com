<?php
/**
 * Created by Sublime Text.
 * User: AlexKim
 * Date: 2019-03-04
 * Time: 오후 02:05
 */

//config
require __DIR__ .'/../../inc/config.php';
require __DIR__ .'/Report_Config.php';

try {
    //변수 정리
	$tbl         = "report"; // 리포트 테이블명
	$report_type = "Daily";  // 리포트 작성 날짜('Daily' , 'Weekly')

	$ymd                = date('Ymd');
	$CkeckDate['Y-m-d'] = date("Y-m-d",strtotime("-1 day"));
	//$CkeckDate['Y-m-d'] = '2019-01-18';
	//$CkeckDate['Y-m-d'] = date("Y-m-d",strtotime("{$argv[1]} day"));
	$CheckDateAry = array("CheckDate" => $CkeckDate['Y-m-d']);

	//Log 생성
    $log_folder     = __DIR__ . '/log';
    $log_filename   = "{$ymd}_01.Daily_Report.log";
    $log_path       = $log_folder . '/' . $log_filename;
    $log_txt        = "Start_{$report_type}";
    write_log($log_path, $log_txt, "a");

    //날짜 유무 조회
	$DailyDate_Ckeck_qry = "
		SELECT 
		  report_date 
		FROM
		  report 
		WHERE report_date = '{$CkeckDate['Y-m-d']}' 
		  AND report_type = '{$report_type}'
	";
    $result = $_mysqli->query($DailyDate_Ckeck_qry);
    
    //트랜잭션    
    $_mysqli2->begin_transaction();

    if ($result) {
        $rows = $result->num_rows;

		//날짜 없을시 날짜부분 추가
        if ($rows == 0) {
			$DailyDate_create_qry = "
				INSERT INTO {$tbl} SET
					report_date  = '{$CkeckDate['Y-m-d']}',
					report_type  = '{$report_type}'
			";
	    	$result = $_mysqli->query($DailyDate_create_qry);
            //추가 되었음
            $log_txt = "INSERT INTO report_date: {$CkeckDate['Y-m-d']}";
            write_log($log_path, $log_txt, "a");	    	
        }
    }





	#User Report 조회 및 업데이트 		
		#User Type 설정
	    	#Report_Config.php 체크

		#Report Json 만들기
		 #TotalCount_{$Name} = 전체 유저(Dummy 제외)
		 #NewCount_{$Name}   = 가입 유저(Dummy 제외)
		 #DAUCount_{$Name}   = 일간 순수 유저(Dummy 제외)
		$UserReport_qry = "	SELECT ";
	    	foreach($UserAry as  $Name => $Key){
				$UserReport_qry .= "
			  		COUNT(IF({$Key} AND m_type <> 8, 1 , NULL))                                                                                                             AS TotalCount_{$Name},
			  		COUNT(IF({$Key} AND DATE_FORMAT(m_enter_datetime, '%Y-%m-%d') = '{$CkeckDate['Y-m-d']}' , 1 , NULL))                                                    AS NewCount_{$Name},
			  		(SELECT COUNT(DISTINCT m_idx) FROM members_login WHERE {$Key} AND join_check = 'o' AND DATE_FORMAT(reg_datetime, '%Y-%m-%d') = '{$CkeckDate['Y-m-d']}') AS DAUCount_{$Name},
				";
			}
		$UserReport_qry .= "
			''
			FROM
			  members
		";
	    //print_r($UserReport_qry);
	    $UserReport_qry_result = $_mysqli->query($UserReport_qry);

	    //Json 그룹으로 묶기
		$Group_UserReport = array();
		foreach($UserAry as $Name=>$Key){
			$return = [];
			foreach ($UserReport_qry_result as $UserReport_ary) {
			    $return = [ 
					"TotalCount" => $UserReport_ary["TotalCount_{$Name}"], 
					"NewCount"   => $UserReport_ary["NewCount_{$Name}"],
					"DAUCount"   => $UserReport_ary["DAUCount_{$Name}"]
			    ];
			}
			$Group_UserReport[$Name] = $return;			
		}
		$UserReport_merge = array_merge($Group_UserReport, $CheckDateAry);
		$UserReport_json = json_encode($UserReport_merge);
    	//print_r($UserReport_json); 
	#//User Report 조회 및 업데이트





		#Contest Report 조회 및 업데이트

			#Report Json 만들기
				#ActualUser = 실 유저   참가수
				#DummyUser  = Dummy    참가수
				#MaxEntries = 참가 가능 총수
			$ContestReport_qry = "
							SELECT 
                              game_category.gc_name AS Contest_Name,
			";
			$ContestReport_qry .= "
                              COUNT(IF(members.m_type <> 8 , 1 , NULL))                                                                    AS ActualUser,
                              COUNT(IF(members.m_type = 8  , 1 , NULL))                                                                    AS DummyUser,
                              (SELECT IFNULL(SUM(g_size),0) FROM game WHERE g_sport = game_category.gc_idx AND DATE_FORMAT(g_date,'%Y-%m-%d') = '{$CkeckDate['Y-m-d']}') AS MaxEntries,
			";
			$ContestReport_qry .= "
				'{$CkeckDate['Y-m-d']}' AS CheckDate
                            FROM
                              game
                              LEFT OUTER JOIN
                              game_category
                              ON game.g_sport = game_category.gc_idx
                              LEFT OUTER JOIN
                              join_contest 
                              ON game.g_idx = join_contest.jc_game
                              LEFT OUTER JOIN
                              members
                              ON join_contest.jc_u_idx = members.m_idx
                            WHERE DATE_FORMAT(g_date, '%Y-%m-%d') = '{$CkeckDate['Y-m-d']}'
                           GROUP BY game_category.gc_name
			";
			$ContestReport_qry_result = $_mysqli->query($ContestReport_qry);
	    	//print_r($ContestReport_qry);
	    	$Group_ContestReport=array();
			while ($ContestReport_ary = $ContestReport_qry_result->fetch_assoc()){
			   $Group_ContestReport[$ContestReport_ary['Contest_Name']] = $ContestReport_ary;
			}
			$ContestReport_json = json_encode($Group_ContestReport);
			//print_r($ContestReport_json);
		#//Contest Report 조회 및 업데이트





	#Gold Report 조회 및 업데이트
	
	    #Server Hold(유저 보유 Gold 총 합계)
	    # m_type = 8 (Dummy) , m_level = 2 내부계정
	      $Total_User_Gold_qry = "
	        SELECT 
	          SUM(m_deposit) AS Holding_TotalUserGold
	        FROM
	          members
	        WHERE m_type <> 8
	          AND m_level <> 2
	      ";
	      $Total_User_Gold_qry_result = $_mysqli->query($Total_User_Gold_qry);
	       $Total_User_Gold_ary = $Total_User_Gold_qry_result->fetch_assoc();
	          $Holding_TotalUserGold = array("Holding_TotalUserGold" => $Total_User_Gold_ary['Holding_TotalUserGold']);			
	
		#Gold Type 설정
	    	#Report_Config.php 체크

		#Json 만들기
		#Total_Gold_{$Name}  = Gold 구매금
		#Count_Gold_{$Name}  = Gold 구매수
		#Total_Gross_{$Name} = Gold 구매금(VAT포함)
		$GoldReport_qry = "	SELECT ";
	    	foreach($GoldAry as $Name => $Key){
				$GoldReport_qry .= "
			  		COALESCE(SUM(IF(dh_paymethod = {$Key} , dh_amount, 0)),0) AS Total_Gold_{$Name},
			  		COUNT(IF(dh_paymethod = {$Key} , 1, NULL))                AS Count_Gold_{$Name},
					COALESCE(SUM(IF(dh_paymethod = {$Key} ,dh_deposit, 0)),0) AS Total_Gross_{$Name},
				";
			}
		$GoldReport_qry .= "
			''
            FROM
              deposit_history
            WHERE DATE_FORMAT(dh_req_date, '%Y-%m-%d') = '{$CkeckDate['Y-m-d']}'
		";
	    //print_r($GoldReport_qry);
	    $GoldReport_qry_result = $_mysqli->query($GoldReport_qry);

	    //Json 그룹으로 묶기
		$Group_GoldReport = array();
		foreach($GoldAry as $Name=>$Key){
			$return = [];
			foreach ($GoldReport_qry_result as $GoldReport_ary) {
			    $return = [ 
					"Total_Gold"  => $GoldReport_ary["Total_Gold_{$Name}"], 
					"Count_Gold"  => $GoldReport_ary["Count_Gold_{$Name}"],
					"Total_Gross" => $GoldReport_ary["Total_Gross_{$Name}"]
			    ];
			}
			$Group_GoldReport[$Name] = $return;			
		}
		$GoldReport_merge = array_merge($Group_GoldReport, $Holding_TotalUserGold, $CheckDateAry);
		$GoldReport_json  = json_encode($GoldReport_merge);


	    //print_r($GoldReport_json); 
	#//Gold Report 조회 및 업데이트





	#BitCoin Report 조회 및 업데이트
		#BitCoin Type 설정
	    	#Report_Config.php 체크

		#Json 만들기
		#Total_Waiting_{$Name}  = BitCoin 지급 예정 금액
		#Count_Waiting_{$Name}  = BitCoin 지급 예정 금액 수량
		#Total_Complete_{$Name} = BitCoin 지급 완료 금액 
		#Count_Complete_{$Name} = BitCoin 지급 완료 금액 수량
		$BitCoinReport_qry = "	SELECT ";
	    	foreach($BitCoinAry as $Name => $Key){
				$BitCoinReport_qry .= "
			  		COALESCE(SUM(IF({$Key} AND bc_condition = 0 , bc_amount, 0)),0) AS Waiting_Coin_{$Name},
			  		COUNT(IF({$Key} AND bc_condition = 0 , 1, NULL))                AS Waiting_Count_{$Name},
					COALESCE(SUM(IF({$Key} AND bc_condition = 1 , bc_amount, 0)),0) AS Complete_Coin_{$Name},
					COUNT(IF({$Key} AND bc_condition = 1 , 1, NULL))                AS Complete_Count_{$Name},
				";
			}
		$BitCoinReport_qry .= "
			'{$CkeckDate['Y-m-d']}' AS Date
            FROM
              bitcoin_history
            WHERE DATE_FORMAT(bc_req_date, '%Y-%m-%d') = '{$CkeckDate['Y-m-d']}'
		";
	    //print_r($BitCoinReport_qry);
	    $BitCoinReport_qry_result = $_mysqli->query($BitCoinReport_qry);

	    //Json 그룹으로 묶기
		$Group_BitCoinReport = array();
		foreach($BitCoinAry as $Name=>$Key){
			$return = [];
			foreach ($BitCoinReport_qry_result as $BitCoinReport_ary) {
			    $return = [ 
					"Waiting_Coin"   => $BitCoinReport_ary["Waiting_Coin_{$Name}"], 
					"Waiting_Count"  => $BitCoinReport_ary["Waiting_Count_{$Name}"],
					"Complete_Coin"  => $BitCoinReport_ary["Complete_Coin_{$Name}"],
					"Complete_Count" => $BitCoinReport_ary["Complete_Count_{$Name}"],
					'Date'           => $BitCoinReport_ary['Date'] 
			    ];
			}
			$Group_BitCoinReport[$Name] = $return;			
		}		
		$BitCoinReport_merge = array_merge($Group_BitCoinReport, $CheckDateAry);
		$BitCoinReport_json = json_encode($BitCoinReport_merge);
	    //print_r($BitCoinReport_json); 
	#//BitCoin Report 조회 및 업데이트


	#Ticket Report 조회 및 업데이트
		#Json 만들기
		#Waiting = Ticket Waiting
		#Answer  = Ticket Answer
		$TicketReport_qry = "
	        SELECT 
	          COUNT(IF(cu_status = 0 AND DATE_FORMAT(cu_req_date, '%Y-%m-%d') = '{$CkeckDate['Y-m-d']}', 1, NULL)) AS Waiting,
	          COUNT(IF(cu_status = 1 AND DATE_FORMAT(cu_res_date, '%Y-%m-%d') = '{$CkeckDate['Y-m-d']}', 1, NULL)) AS Answer,
	          '{$CkeckDate['Y-m-d']}' AS CheckDate
	        FROM
	          contactus
		";
	    //print_r($TicketReport_qry);
	    $TicketReport_qry_result = $_mysqli->query($TicketReport_qry);
        $arrData = $TicketReport_qry_result->fetch_assoc();
        $TicketReport_json = json_encode($arrData);		
	    //print_r($TicketReport_json); 
	#//Ticket Report 조회 및 업데이트

    if ($UserReport_qry_result && $ContestReport_qry_result && $GoldReport_qry_result && $BitCoinReport_qry_result && $TicketReport_qry_result) {
		$Update_qry  = "
	    	UPDATE {$tbl} SET
				report_user    = '{$UserReport_json}',
				report_contest = '{$ContestReport_json}',
				report_gold    = '{$GoldReport_json}',
				report_bitcoin = '{$BitCoinReport_json}',
				report_ticket  = '{$TicketReport_json}',
				reg_datetime   = NOW()
			WHERE 1 = 1 
	  		  AND report_date = '{$CkeckDate['Y-m-d']}'
	  		  AND report_type = '{$report_type}'
	    ";
	    //print_r($Update_qry);
	    $Update_qry_result = $_mysqli->query($Update_qry);
	    if ($Update_qry_result) {
	    	//등록 성공
	        $log_txt = "SUCCESS - UPDATE {$tbl} [Daily_Report]";
	        write_log($log_path, $log_txt, "a");
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
    $log_txt        = "END_{$report_type}";
    write_log($log_path, $log_txt, "a");
}
