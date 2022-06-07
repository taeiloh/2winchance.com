<?php
class RankReward {
    // 파라미터 정리
    public $size;
    public $fee;
    public $prize;
    public $entry;

    // 변수 정리
    public $total_reward;
    public $summary;
    public $first_place;

    function __construct($g_size, $g_fee, $g_prize, $g_entry=0)
    {
        $this->size     = $g_size;
        $this->fee      = $g_fee;
        $this->prize    = $g_prize;
        $this->entry    = $g_entry;

        // 총 상금 계산
        $this->total_reward   = floor($this->size * $this->fee * (100 - COMMISSION) / 100);
    }

    // 총 상금
    function getTotal_reward() {
        return $this->total_reward;
    }

    // 1등 상금
    function getFirst_place() {
        $reward_info = $this->getReward_info($this->prize);

        return $this->first_place;
    }

    // 요약
    function getSummary($g_prize) {
        switch($g_prize) {
            case 0:
                break;
            case 1:
                $one_reward     = $this->total_reward / $this->size * 2;
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금을 상위 순위 50%에게 지급합니다.<br/>
                    * 우승자의 상금은 각 {$one_reward} FP입니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
            case 2:
                $one_reward     = $this->total_reward / $this->size * 2;
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금을 상위 순위 50%에게 지급합니다.<br/>
                    * 우승자의 상금은 각 {$one_reward} FP입니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
            case 3:
                $one_reward     = $this->total_reward / $this->size * 2;
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금을 상위 3위의 입상자에게 지급됩니다.<br/>
                    * 1등은 $,$$$FP를 획득합니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
            case 4:
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금을 상위 4위의 입상자에게 지급됩니다.<br/>
                    * 1등은 {$this->first_place} FP를 획득합니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
            case 5:
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금을 상위 5위의 입상자에게 지급됩니다.<br/>
                    * 1등은 {$this->first_place} FP를 획득합니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
            case 6:
                $one_reward     = $this->total_reward / $this->size * 2;
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금을 상위 순위 50%에게 지급합니다.<br/>
                    * 우승자의 상금은 각 {$one_reward} FP입니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
            case 7:
                $one_reward     = $this->fee * 2;
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금은 상위 입상자에게 지급됩니다.<br/>
                    * 상금은 각 {$one_reward} FP를 획득합니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
            case 8:
                $one_reward     = $this->fee * 3;
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금은 상위 입상자에게 지급됩니다.<br/>
                    * 상금은 각 {$one_reward} FP를 획득합니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
            case 9:
                $one_reward     = $this->fee * 10;
                $total_reward   = number_format($this->total_reward);
                $this->summary  = "
                    * {$this->size}명으로 구성된 본 콘테스트는 총 {$total_reward} FP의 상금은 상위 입상자에게 지급됩니다.<br/>
                    * 상금은 각 {$one_reward} FP를 획득합니다.<br/>
                    * 최종 참가자 수에 따라 상금이 다를 수 있습니다.
                ";
                break;
        }

        return $this->summary;
    }

    // 상금 정보
    function getReward_info($g_prize, $rtn_type='html') {
        switch($g_prize) {
            case 0:
                $info   = $this->reward_t1($rtn_type);
                break;
            case 1:
                $info   = $this->reward_half($rtn_type);
                break;
            case 2:
                $info   = $this->reward_t2($rtn_type);
                break;
            case 3:
                $info   = $this->reward_t3($rtn_type);
                break;
            case 4:
                $info   = $this->reward_t4($rtn_type);
                break;
            case 5:
                $info   = $this->reward_t5($rtn_type);
                break;
            case 6:
                $info   = $this->reward_multi($rtn_type);
                break;
            case 7:
                $info   = $this->reward_x(2, $rtn_type);
                break;
            case 8:
                $info   = $this->reward_x(3, $rtn_type);
                break;
            case 9:
                $info   = $this->reward_x(10, $rtn_type);
                break;
        }

        return $info;
    }

    // 상금 정보 로직(50/50)
    function reward_half($rtn_type) {
        $rtn        = '';
        $arrRtn     = array();
        $Tpz        = $this->fee * $this->entry;
        $TpzU       = floor($Tpz * (100 - COMMISSION) / 100);

        if($this->size > 6) {
            // 참가 인원이 짝수인지 체크
            if($this->size % 2 == 0) {
                $half   = $this->entry / 2;
                if($half > 0) {
                    $reward     = floor($TpzU / $half);
                } else {
                    $reward     = 0;
                }
                $this->first_place  = $reward;

                if ($rtn_type == 'html') {
                    $rtn    = "
                        <ul>
                            <li class=\"first\">
                                <label>50/50</label>
                                <p>{$reward} FP</p>
                            </li>
                        </ul>
                    ";
                } else {
                    $arrRtn[0]['rank']     = '50/50';
                    $arrRtn[0]['reward']   = $reward;
                    $arrRtn[0]['limit']    = $half;
                }
            }
        }

        if ($rtn_type != 'html') {
            $rtn    = $arrRtn;
        }

        return $rtn;
    }

    // 상금 정보 로직(더블)
    function reward_x($x, $rtn_type) {
        $rtn        = '';
        $arrRtn     = array();
        $Tpz        = $this->fee * $this->size;
        $TpzU       = floor($Tpz * (100 - COMMISSION) / 100);
        $max        = floor($TpzU / ($this->fee * $x));

        if($max > 1) {
            $rank   = '1~'. $max;
            $reward = $this->fee * $x;
            $this->first_place  = $reward;

            if ($rtn_type == 'html') {
                $rtn = "
                    <ul>
                        <li class=\"first\">
                            <label>{$rank}</label>
                            <p>{$reward} FP</p>
                        </li>
                    </ul>
                ";
            } else {
                $arrRtn[0]['rank']     = $rank;
                $arrRtn[0]['reward']   = $reward;
                $arrRtn[0]['limit']    = $max;
            }
        }

        if ($rtn_type != 'html') {
            $rtn    = $arrRtn;
        }

        return $rtn;
    }

    function reward_t1() {
        $rtn        = '';
        $Tpz        = $this->fee * $this->entry;
        $TpzU       = floor($Tpz * (100 - COMMISSION) / 100);

        $rtn    = "
            <ul>
        ";
        for($i=0; $i<1; $i++) {
            //$rank   = $this->ranking_name($i);
            $rtn .= "
                    <li class=\"first\">
                        <label>{$i}위</label>
                        <p>{$TpzU} FP</p>
                    </li>
            ";
        }
        $rtn    .= "
            </ul>
        ";

        return $rtn;
    }

    function reward_t2() {
    }

    function reward_t3() {
    }

    function reward_t4($rtn_type) {
        $rtn        = '';
        $arrRtn     = array();
        $Tpz        = $this->fee * $this->entry;
        $TpzU       = floor($Tpz * (100 - COMMISSION) / 100);
        $remainder  = $TpzU;

        if ($this->size > 9) {
            $rtn    .= "
                <ul>
            ";
            for($i=0; $i<4; $i++) {
                $liClass    = '';
                $rank       = $i + 1; //$this->ranking_name($i);

                if($i == 0) {
                    $liClass    = 'first';
                    $reward     = round($TpzU * (6/18));
                    $remainder  -= $reward;
                    $this->first_place  = $reward;

                } else if($i == 1) {
                    $reward     = round($TpzU * (5/18));
                    $remainder  -= $reward;

                } else if($i == 2) {
                    $reward     = round($TpzU * (4/18));
                    $remainder  -= $reward;

                } else if($i == 3) {
                    $reward     = $remainder;
                }

                if ($rtn_type == 'html') {
                    $rtn .= "
                        <li class=\"{$liClass}\" style=\"height: 5rem\">
                            <label>{$rank}위</label>
                            <p>{$reward} FP</p>
                        </li>
                    ";
                } else {
                    $arrRtn[0]['rank']     = $rank;
                    $arrRtn[0]['reward']   = $reward;
                    $arrRtn[0]['limit']    = 1;
                }

            }
            $rtn    .= "
                </ul>
            ";
        }

        if ($rtn_type != 'html') {
            $rtn    = $arrRtn;
        }

        return $rtn;
    }

    function reward_t5($rtn_type) {
        $rtn        = '';
        $arrRtn     = array();
        $Tpz        = $this->fee * $this->entry;
        $TpzU       = floor($Tpz * (100 - COMMISSION) / 100);
        $remainder  = $TpzU;

        if ($this->size > 13) {
            $rtn    .= "
                <ul>
            ";
            for($i=0; $i<5; $i++) {
                $liClass    = '';
                $rank       = $i + 1; //$this->ranking_name($i);

                if($i == 0) {
                    $liClass    = 'first';
                    $reward     = round($TpzU * (7/25));
                    $remainder  -= $reward;
                    $this->first_place  = $reward;

                } else if($i == 1) {
                    $reward     = round($TpzU * (6/25));
                    $remainder  -= $reward;

                } else if($i == 2) {
                    $reward     = round($TpzU * (5/25));
                    $remainder  -= $reward;

                } else if($i == 3) {
                    $reward     = round($TpzU * (4/25));
                    $remainder  -= $reward;

                } else if($i == 4) {
                    $reward     = $remainder;
                }

                if ($rtn_type == 'html') {
                    $rtn .= "
                        <li class=\"{$liClass}\" style=\"height: 4rem\">
                            <label>{$rank}위</label>
                            <p>{$reward} FP</p>
                        </li>
                    ";
                } else {
                    $arrRtn[$i]['rank']     = $rank;
                    $arrRtn[$i]['reward']   = $reward;
                    $arrRtn[$i]['limit']    = 1;
                }
            }
            $rtn    .= "
                </ul>
            ";
        }

        if ($rtn_type != 'html') {
            $rtn    = $arrRtn;
        }

        return $rtn;
    }

    function reward_multi() {
        if ($this->size > 27) {
            // 명수에 따른 구간 함수 찾기
            if ($this->size > 27 && $this->size < 32) {
                return $this->cal_multi(1);
            } else if ($this->size > 31 && $this->size < 44) {
                return $this->cal_multi(2);
            } else if ($this->size > 43 && $this->size < 64) {
                return $this->cal_multi(3);
            } else if ($this->size > 63 && $this->size < 84) {
                return $this->cal_multi(4);
            } else if ($this->size > 83 && $this->size < 104) {
                return $this->cal_multi(5);
            } else if ($this->size > 103 && $this->size < 144) {
                return $this->cal_multi(6);
            } else if ($this->size > 143 && $this->size < 184) {
                return $this->cal_multi(7);
            } else if ($this->size > 183 && $this->size < 224) {
                return $this->cal_multi(8);
            } else if ($this->size > 223 && $this->size < 324) {
                return $this->cal_multi(9);
            } else if ($this->size > 323 && $this->size < 424) {
                return $this->cal_multi(10);
            } else if ($this->size > 423 && $this->size < 624) {
                return $this->cal_multi(11);
            } else if ($this->size > 623 && $this->size < 824) {
                return $this->cal_multi(12);
            } else if ($this->size > 823 && $this->size < 1224) {
                return $this->cal_multi(13);
            } else if ($this->size > 1223 && $this->size < 1624) {
                return $this->cal_multi(14);
            } else if ($this->size > 1623 && $this->size < 2024) {
                return $this->cal_multi(15);
            } else if ($this->size > 2023 && $this->size < 3224) {
                return $this->cal_multi(16);
            } else if ($this->size > 3223 && $this->size < 5224) {
                return $this->cal_multi(17);
            } else if ($this->size > 5223 && $this->size < 9224) {
                return $this->cal_multi(18);
            } else if ($this->size > 9223 && $this->size < 17224) {
                return $this->cal_multi(19);
            }
        } else {
            return false;
        }
    }

    function cal_multi($type) {
        if ($type < 6) {
            $function_name = 'multi_preiod_' . $type;
            return $this->$function_name();

        } else {
            return $this->multi_preiod_define($type);
        }
    }

    function multi_preiod_define($type) {
        $this->last_rank = $this->total_reward;

        return $this->define_var($type);
    }

    function define_var($type) {
        switch ($type) {
            case 6:
                $define['gold'] = array(19, 15, 12, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5);
                $define['bouns'] = array(0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0);
                break;
            case 7:
                $define['gold'] = array(26, 19, 15, 13, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10);
                $define['bouns'] = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0.2, 0.1);
                break;
            case 8:
                $define['gold'] = array(33, 23, 20, 16, 13, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10);
                $define['bouns'] = array(2, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0);
                break;
            case 9:
                $define['gold'] = array(40, 30, 20, 15, 13, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10);
                $define['bouns'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                break;
            case 10:
                $define['gold'] = array(58, 43, 31, 22, 16, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25);
                $define['bouns'] = array(0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                break;
            case 11:
                $define['gold'] = array(65, 49, 39, 29, 19, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25);
                $define['bouns'] = array(10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                break;
            case 12:
                $define['gold'] = array(112, 84, 63, 46, 34, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25, 50);
                $define['bouns'] = array(-12, -4, -3, -6, -4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                break;
            case 13:
                $define['gold'] = array(148, 102, 68, 45, 29, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25, 50, 50);
                $define['bouns'] = array(-8, -2, -8, -5, -1, 0, 0, 0, -0.3, 0, 0, 0, -0.3, 0, 0, 0, 0, 0);
                break;
            case 14:
                $define['gold'] = array(220, 143, 98, 65, 42, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25, 50, 50, 100);
                $define['bouns'] = array(1, 1, 1, 5, 8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                break;
            case 15:
                $define['gold'] = array(292, 175, 105, 63, 37, 20, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25, 50, 50, 100, 100);
                $define['bouns'] = array(0, 0, 0, 0, 0, 0, 3, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                break;
            case 16:
                $define['gold'] = array(360, 210, 130, 75, 45, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25, 50, 50, 100, 100, 100);
                $define['bouns'] = array(0, 0, 0, 0, 0, 3, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 0);
                break;
            case 17:
                $define['gold'] = array(465, 275, 165, 100, 60, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25, 50, 50, 100, 100, 100, 300);
                $define['bouns'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                break;
            case 18:
                $define['gold'] = array(715, 425, 255, 150, 90, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25, 50, 50, 100, 100, 100, 300, 500);
                $define['bouns'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                break;
            case 19:
                $define['gold'] = array(1000, 600, 360, 125, 125, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3);
                $define['limit'] = array(1, 1, 1, 1, 1, 2, 2, 2, 5, 5, 5, 10, 10, 10, 25, 25, 50, 50, 100, 100, 100, 300, 500, 1000);
                $define['bouns'] = array(0, 0, 0, 0, 0, -8, -7, -7, -7, -7, -6, -6, -5, -5, -5, -4, -4, -3, -3, -2, -2, -1, -1, -1);
                break;
        }

        $standard       = $this->cal_standard($define);
        $result_define  = $this->cal_define_var($standard);

        return $result_define;
    }

    function cal_define_var($standard) {
        $rtn                = '';
        $liClass            = '';
        $Tpz                = $this->fee * $this->size;
        $TpzU               = floor($Tpz * (100 - COMMISSION) / 100);

        $define_gold        = $standard['gold'];
        $define_limit       = $standard['limit'];
        $sum                = $standard['sum'];
        $count              = $standard['count'];

        $rtn    .= "
            <ul style=\"overflow-y: auto; height: 250px;\">
        ";
        for ($i=0; $i<$count; $i++) {
            $rank           = $i + 1;
            $limit          = $define_limit[$i];
            if ($i == $count - 1) {
                // 마지막 행렬을 수식 변경
                $reward = round($this->last_rank / $limit);

                $rtn .= "
                    <li class=\"{$liClass}\" style=\"height: 4rem\">
                        <label>{$rank}위</label>
                        <p>{$reward} FP</p>
                    </li>
                ";

            } else {
                $reward     = round($TpzU * ($define_gold[$i] / $sum));
                if ($limit > 1) {
                    $reward = round(($TpzU * ($define_gold[$i] / $sum)) / $limit);
                }
                $this->last_rank -= $reward * $limit;

                $rtn .= "
                    <li class=\"{$liClass}\" style=\"height: 4rem\">
                        <label style=\"padding-right: 6rem;\">{$rank}위</label>
                        <p>{$reward} FP</p>
                    </li>
                ";
            }
        }
        $rtn    .= "
            </ul>
        ";

        return $rtn;
    }

    // 고정 값이 존재함 이에 따른 수식 변화가 추가됨
    function cal_standard($define) {
        $count = count($define['gold']);
        for ($i = 0; $i < $count; $i++) {
            $gold = $define['gold'][$i];
            $limit = $define['limit'][$i];
            $bouns = $define['bouns'][$i];

            $temp_gold = $gold * $limit;
            $temp_bonus = $limit * $bouns;

            $standard['gold'][$i] = $temp_gold + $temp_bonus;
            $standard['limit'][$i] = $limit;
        }
        $standard['sum'] = array_sum($standard['gold']);
        $standard['count'] = $count;
        return $standard;
    }

    function ranking_name($rank) {
        switch ($rank) {
            case 0:
                return '1st';
            case 1:
                return '2nd';
            case 2:
                return '3rd';
            case 3:
                return '4th';
            case 4:
                return '5th';
            case 5:
                return '6~7';
            case 6:
                return '8~9';
            case 7:
                return '10~11';
            case 8:
                return '12~16';
            case 9:
                return '17~21';
            case 10:
                return '22~26';
            case 11:
                return '27~36';
            case 12:
                return '37~46';
            case 13:
                return '47~56';
            case 14:
                return '57~81';
            case 15:
                return '82~106';
            case 16:
                return '107~156';
            case 17:
                return '157~206';
            case 18:
                return '207~306';
            case 19:
                return '307~406';
            case 20:
                return '407~506';
            case 21:
                return '507~806';
            case 22:
                return '807~1306';
            case 23:
                return '1307~2306';
        }
    }
}
