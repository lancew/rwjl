<?php
class ResultsController extends AppController {
   //var $scaffold;
   var $name = 'Results';
   var $uses = array('User','Fight');  
   

   function record($id = null)
    {

    if (empty($this->data))
    {
        $this->Fight->id = $id;
        $this->data = $this->Fight->read();
        $this->set('fight', $this->Fight->read());
        // echo print_r($this->data);
    	        
        $this->set('userslist', array($this->data['Challenger']['id'] => $this->data['Challenger']['username'], $this->data['Challenged']['id'] => $this->data['Challenged']['username']));
        
        
    }
    else
    {
		$this->Fight->id = $this->data['Fight']['id'];
        $this->data2 = $this->Fight->read();
       
       // If both results have been entered, then do the ELO rating, if the results match.
        if ($this->data['Fight']['winner_from_challenger'] && $this->data['Fight']['winner_from_challenged']) {
            if ($this->data['Fight']['winner_from_challenger'] == $this->data['Fight']['winner_from_challenged']) {
             //echo "the results Match";
             
            
            
            			//echo '<pre>';
						//echo print_r($this->data);
						//echo print_r($this->data2);
						//echo '</pre>';
             
            ## * S1 = 1st player's score                          ##
			## * S2 = 2nd player's score                          ##
			## * R1 = 1st player's result                         ##
			## * R2 = 2nd player's result  
                    
            $R1 = $this->data2['Challenger']['elo_rating'];
            $R2 = $this->data2['Challenged']['elo_rating'];
            
            //echo "<br>Challenger: " . $R1;
            //echo "<br>Challenged: " . $R2;            
            
            if ($this->data['Fight']['winner_from_challenger'] == $this->data2['Challenger']['id']) {
            		//echo "<br>Challenger Won";
            		$this->data2['Challenger']['wins'] = $this->data2['Challenger']['wins'] + 1;
            		$this->data2['Challenged']['losses'] = $this->data2['Challenged']['losses'] + 1;
            		$S1 = 2;
            		$S2 = 1;
            } else {
            		//echo "<br>Challenged Won";
            		$this->data2['Challenged']['wins'] = $this->data2['Challenged']['wins'] + 1;
            		$this->data2['Challenger']['losses'] = $this->data2['Challenger']['losses'] + 1;            		
            		$S1 = 1;
            		$S2 = 2;            
            }
 
			
    		if ($S1!=$S2) { 
    						if ($S1>$S2) { 
    										$E=120-round(1/(1+pow(10,(($R2-$R1)/400)))*120); 
    										$result['R3']=$R1+$E; 
    										$result['R4']=$R2-$E; 
    									  } else { 
    										$E=120-round(1/(1+pow(10,(($R1-$R2)/400)))*120); 
    										$result['R3']=$R1-$E; 
    										$result['R4']=$R2+$E; 
    									  }
    					   } else { 
    						if ($R1==$R2) { 
    										$result['R3']=$R1; 
    										$result['R4']=$R2; 
    						              } else { 
    										if($R1>$R2) { 
    														$E=(120-round(1/(1+pow(10,(($R1-$R2)/400)))*120))-(120-round(1/(1+pow(10,(($R2-$R1)/400)))*120));
    														$result['R3']=$R1-$E; 
    														$result['R4']=$R2+$E; 
    													 } else { 
    														$E=(120-round(1/(1+pow(10,(($R2-$R1)/400)))*120))-(120-round(1/(1+pow(10,(($R1-$R2)/400)))*120)); 																		
    														$result['R3']=$R1+$E; 
    														$result['R4']=$R2-$E; 
    													 }
    								      }
    							   } 
    		$result['S1']=$S1; 
    		$result['S2']=$S2; 
    		$result['R1']=$R1; 
    		$result['R2']=$R2; 
   			$result['P1']=((($result['R3']-$result['R1'])>0)?"+".($result['R3']-$result['R1']):($result['R3']-$result['R1'])); 
  			$result['P2']=((($result['R4']-$result['R2'])>0)?"+".($result['R4']-$result['R2']):($result['R4']-$result['R2'])); 
 
			//echo "<pre>";
			//echo print_r($result);
			//echo "</pre>";
   
            $this->data2['Challenger']['elo_rating'] = $result['R3'];
            $this->data2['Challenged']['elo_rating'] = $result['R4'];   			
   
   
         }   
        }
        
 
 // Set the result_confirmed field to 1, which removes the update result from the index menu.
 // --------------------------------------------------------------------------------------------
 $this->data['Fight']['result_confirmed'] = 1;      
 
 if ($this->Fight->save($this->data['Fight']))
        {
			$this->User->save($this->data2['Challenger']);
			$this->User->save($this->data2['Challenged']);
            $this->flash('The result has been recorded.','/fights');
        }
        
        
        
        
    }
    }

	

	
}
?>