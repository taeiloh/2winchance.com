<?php
			#User Type 설정
			$UserAry = array(
				"Spo_Bit"     => "m_type =  1 AND m_type <> 8",
				"Facebook"    => "m_type =  2 AND m_type <> 8",
				//"Google"      => "m_type =  3 AND m_type <> 8",
				//"Yahoo"       => "m_type =  4 AND m_type <> 8",
				//"Twitter"     => "m_type =  5 AND m_type <> 8",
				"TotalAmount" => "m_type <> 8",
			);

		    #Contest Type 설정(요일)
			$ContestAry = array(
				"Mon"     => 2,
				"Tue"     => 3,
				"Wed"     => 4,
				"Thu"     => 5,
				"Fri"     => 6,
				"Sat"     => 7,
				"Sun"     => 1,
			);


			#Gold Type 설정
			$GoldAry = array(
				"Paypal"  => "1",
				//"Dragon"  => "11",
				//"Coin_ph" => "12",
				//"G_cash"  => "13",
				//"MOL"     => "14",
			);



			#BitCoin Type 설정
			$BitCoinAry = array(
				"BTC"  => "bc_pay_type = 1 ",  
				//"ETH"  => "bc_pay_type = 2 ",  
				//"DSN"  => "bc_pay_type = 3 ",  
				//"UDIA" => "bc_pay_type = 4 ",
				//"XRP"  => "bc_pay_type = 5 ",  
				//"EOS"  => "bc_pay_type = 6 ",  
			);