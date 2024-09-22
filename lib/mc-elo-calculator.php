<?php
/**
 * elo_calculator class.
 *
 */


class elo_calculator
{
    public function rating($S1, $S2, $R1, $R2, $K = 120)
    //Error checking
    { //if (empty($S1) or empty($S2) or empty($R1) or empty($R2)) return null;




        //If player 1 won
        { if ($S1 > $S2) {
            //we calculate the probability of one player winning (between 0 and 1, the probability of the other player winning is
            // 1 - this amount), multiply by the K factor
            $E = $K * (1 - (1 / (1 + pow(10, (($R2 - $R1) / 400)))));
            $E = round($E);
            //print $E;

            //Add this number to the winner's score
            $R['R3'] = round($R1 + $E / 2);

            //subtract it from the loser's score
            $R['R4'] = $R2 - $E;
        }




            //If player 2 won do the opposite
            else {
                $E = $K * (1 - (1 / (1 + pow(10, (($R1 - $R2) / 400)))));
                $E = round($E);
                $R['R3'] = round($R1 - $E / 2);


                $R['R4'] = $R2 + $E;
            }
        }



        return $R;
    }
}
