<?php
class FightsController extends AppController {
   //var $scaffold;
   var $name = 'Fights';
   var $uses = array('User','Fight');  
   
   
   function checkSession()
    {
        // If the session info hasn't been set...
        if (!$this->Session->check('User'))
        {
            // Force the user to login
            $this->redirect('/users/login');
            exit();
        }
    }
   
      function checkAdmin()
    {
        // If the session info hasn't been set...
        if (!$this->Session->check('Admin'))
        {
            // Force the user to login
            $this->redirect('/users/login');
            exit();
                   }
    }
   
   
   
   function index($ref = 1)
    {

	$conditions = "Fight.active = '".$ref."'";
        $this->set('fights', $this->Fight->findAll($conditions));
	
	
		
	
    }



    function view($id = null)
    {
        
        
        $this->Fight->id = $id;
        $this->set('fight', $this->Fight->read());
				
		$this->data = $this->Fight->read();
		//	echo '<pre>';
		//	echo print_r($this->data);
		//	echo '</pre>';

		
		

    }

    function create()
    {

	// Only authenticated users to access this action.
        $this->checkSession();
	
    $this->set('user',$this->User->findAll()); 
    $this->set('userslist', $this->User->generateList(  
                null, "username ASC", null, "{n}.User.id",  
                "{n}.User.username") 
                ); 
          
        if (!empty($this->data))
        {
            if ($this->Fight->save($this->data))
            {
                $this->flash('Your fight has been created.','/fights');
            }
        }
    }
    
    
    
    
    function delete($id)
    {
     // Only authenticated users to access this action.
        $this->checkSession();
     
     
     $this->Fight->del($id);
     $this->flash('The fight with id: '.$id.' has been deleted.', '/fights');
    }
    
    
    function edit($id = null)
    {
    // Only authenticated users to access this action.
        $this->checkSession();
    
    
    if (empty($this->data))
    {
        $this->set('user',$this->User->findAll()); 
        $this->set('userslist', $this->User->generateList(  
                null, "username ASC", null, "{n}.User.id",  
                "{n}.User.username") 
                ); 
        
        
        $this->Fight->id = $id;
        $this->data = $this->Fight->read();
        $this->set('fight', $this->Fight->read());
    }
    else
    {
        if ($this->Fight->save($this->data['Fight']))
        {
            $this->flash('The fight has been updated.','/fights');
        }
    }
    }


        function activate($id = null)
    {
        // Only authenticated users to access this action.
        $this->checkSession();
        // Only ADMIN users to access this action.
        $this->checkAdmin();
        
        $this->Fight->id = $id;
        $this->data = $this->Fight->read();
        $this->set('fight', $this->Fight->read());
        $this->data['Fight']['active'] = '1';
        if ($this->Fight->save($this->data['Fight']))
        {
            $this->flash('The fight has been activated.','/fights');
        }

    }


        function deactivate($id = null)
    {
        // Only authenticated users to access this action.
        $this->checkSession();
        // Only ADMIN users to access this action.
        $this->checkAdmin();
        
        
        
        $this->Fight->id = $id;
        $this->data = $this->Fight->read();
        $this->set('fight', $this->Fight->read());
        $this->data['Fight']['active'] = '0';
        if ($this->Fight->save($this->data['Fight']))
        {
            $this->flash('The fight has been deactivated.','/fights');
        }

    }



	function rss() 
    { 
        $this->layout = 'xml'; 
        $this->set('fights', $this->Fight->findAll('Fight.result_confirmed = 1')); 
        //echo print_r($this->Fight->findAll('Fight.result_confirmed = 1'));
    } 



}
?>