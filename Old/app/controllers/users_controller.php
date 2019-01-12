<?php
class UsersController extends AppController {
   //var $scaffold;
   var $name = 'Users';
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
   
    
   function login()
    {
        //Don't show the error message if no data has been submitted.
        $this->set('error', false); 

        // If a user has submitted form data:
        if (!empty($this->data))
        {
            // First, let's see if there are any users in the database
            // with the username supplied by the user using the form:

            $someone = $this->User->findByUsername($this->data['User']['username']);

            // At this point, $someone is full of user data, or its empty.
            // Let's compare the form-submitted password with the one in 
            // the database.

            if(!empty($someone['User']['password']) && $someone['User']['password'] == sha1($this->data['User']['password']))
            {
                // Note: hopefully your password in the DB is hashed, 
                // so your comparison might look more like:
                // md5($this->data['User']['password']) == ...

                // This means they were the same. We can now build some basic
                // session information to remember this user as 'logged-in'.

                $this->Session->write('User', $someone['User']);
                if($someone['User']['admin_user']) 
                {
                	$this->Session->write('Admin', '1');
                }

                // Now that we have them stored in a session, forward them on
                // to a landing page for the application. 

                $this->redirect('/fights');
            }
            // Else, they supplied incorrect data:
            else
            {
                // Remember the $error var in the view? Let's set that to true:
                $this->set('error', true);
            }
        }
    }

    function logout()
    {
        // Redirect users to this action if they click on a Logout button.
        // All we need to do here is trash the session information:

        $this->Session->delete('User');

        // And we should probably forward them somewhere, too...
     
        $this->redirect('/');
    } 
    
     
   
   function index()
    {
        $conditions = "ORDER BY elo_rating DESC";
	$this->set('users', $this->User->findAll($conditions));
    }

    function view($id = null)
    {
       
        
        $this->User->id = $id;
        $this->set('user', $this->User->read());
        
        
        
        $conditions = "Fight.challenger_user_id = '".$id."' or Fight.challenged_user_id = '".$id."'";
        $this->set('fights', $this->Fight->findAll($conditions));
    }
    
    

    function create()
    {
        if (!empty($this->data))
        {
           
           // Generate a random salt
			$salt = substr(md5(uniqid(rand(), true)), 0, 5);

			// Hash password
			$secure_password = sha1($this->data['User']['password']);
           
           
           
           $this->data['User']['password'] = $secure_password;
           //echo ' - ' . $this->data['User']['password'];
            if ($this->User->save($this->data))
            {
                $this->flash('Your user has been created.','/users');
            }
        }
    }
    
    function delete($id)
    {
     // Only authenticated users to access this action.
     $this->checkSession();
     $this->User->del($id);
     $this->flash('The user with id: '.$id.' has been deleted.', '/users');
    }
    
    
    
    function edit($id = null)
    {
    // Only authenticated users to access this action.
        $this->checkSession();
    if (empty($this->data))
    {
        $this->User->id = $id;
        $this->data = $this->User->read();
    }
    else
    {
        if ($this->User->save($this->data['User']))
        {
            $this->flash('The user has been updated.','/users');
        }
    }
    }
    




}
?>