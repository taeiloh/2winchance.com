<?php
exit;
// config
require_once __DIR__ .'/../_inc/config.php';

try {
    //TEAM_RESULT
    /*$matched_seq = 0;
    for($round=1; $round<=43; $round++) {
        for($match=1; $match<=5; $match++) {
            $matched_seq++;
            for($rank=1; $rank<=16; $rank++) {
                $query  = "
                    INSERT INTO TEAM_RESULT
                        (ROUNDS_SEQ, MATCHES_SEQ, RANKING)
                    VALUES
                        ({$round}, {$matched_seq}, {$rank})
                ";
                $result = $_mysqli->query($query);
            }
        }
    }*/

    //PLAYER_RESULT
    $query  = "
        SELECT * FROM TEAM_RESULT
        ORDER BY SEQ ASC
    ";
    $result = $_mysqli->query($query);
    while($db = $result->fetch_assoc()) {
        $team_score = 0;
        switch($db['RANKING']) {
            case 1:
                $team_score = 10;
                break;
            case 2:
                $team_score = 6;
                break;
            case 3:
                $team_score = 5;
                break;
            case 4:
                $team_score = 4;
                break;
            case 5:
                $team_score = 3;
                break;
            case 6:
                $team_score = 2;
                break;
            case 7:
            case 8:
                $team_score = 1;
                break;
            default:
                $team_score = 0;
                break;
        }

        for ($i=0; $i<=3; $i++) {
            $rand1 = rand(0, 10);
            $rand2 = rand(0, 10);
            $rand3 = rand(0, 10);
            $rand4 = rand(0, 10);

            $q = "
                INSERT INTO PLAYER_RESULT
                    (ROUNDS_SEQ, MATCHES_SEQ, TEAM_SEQ, 
                     TEAM_SCORE, KILLED, TEAMKILLED, SLEFKILLED, REVIVED)
                VALUES
                    ({$db['ROUNDS_SEQ']}, {$db['MATCHES_SEQ']}, {$db['TEAM_SEQ']},
                     {$team_score}, {$rand1}, {$rand2}, {$rand3}, {$rand4})
            ";
            p($q);
            $r  = $_mysqli->query($q);
        }
    }

} catch (Exception $e) {

}