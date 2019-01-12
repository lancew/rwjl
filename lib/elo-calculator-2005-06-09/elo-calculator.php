<?php
class elo_calculator
{ public function rating($S1, $S2, $R1, $R2)
		//Error checking
		{ if (empty($S1) or empty($S2) or empty($R1) or empty($R2)) return null;
		//If it's not a draw
		if ($S1!=$S2)
			//If player 1 won
			{ if ($S1>$S2)
				//Calculate the expected chance/probability of them winning; add this to their current ranking; subtract this from the other player's ranking
				{ $E=120-round(1/(1+pow(10, (($R2-$R1)/400)))*120); $R['R3']=$R1+$E; $R['R4']=$R2-$E; }
			//If player 2 won do the opposite
			else { $E=120-round(1/(1+pow(10, (($R1-$R2)/400)))*120); $R['R3']=$R1-$E; $R['R4']=$R2+$E; }}
		//If it is a draw - ignore this
		else { if ($R1==$R2) { $R['R3']=$R1; $R['R4']=$R2; }
			else { if ($R1>$R2) { $E=(120-round(1/(1+pow(10, (($R1-$R2)/400)))*120))-(120-round(1/(1+pow(10, (($R2-$R1)/400)))*120)); $R['R3']=$R1-$E; $R['R4']=$R2+$E; }
				else { $E=(120-round(1/(1+pow(10, (($R2-$R1)/400)))*120))-(120-round(1/(1+pow(10, (($R1-$R2)/400)))*120)); $R['R3']=$R1+$E; $R['R4']=$R2-$E; }}}
		//Inputs added
		$R['S1']=$S1; $R['S2']=$S2; $R['R1']=$R1; $R['R2']=$R2;
		//Calculates points awarded for each player - if they have increased thier ranking it returns "+" . [the increase], otherwise it returns [the 
		//new score - the old score], which will be negative
		$R['P1']=((($R['R3']-$R['R1'])>0)?"+".($R['R3']-$R['R1']):($R['R3']-$R['R1']));
		//Same for other player
		$R['P2']=((($R['R4']-$R['R2'])>0)?"+".($R['R4']-$R['R2']):($R['R4']-$R['R2']));
		return $R; }}
?>